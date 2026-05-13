<?php
/**
 * Real Estate Chatbot Admin - Dashboard
 */

// Include configuration
require_once '../config/config.php';
require_once '../api/auth.php';

// Check if user is logged in
requireLogin();

// Get the current user
$currentUser = getCurrentUser();

// Initialize database connection
$pdo = getDbConnection();

// Handle lead status update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lead_id']) && isset($_POST['status'])) {
    $leadId = $_POST['lead_id'];
    $newStatus = $_POST['status'];
    $updated = false;
    
    try {
        // First try database update
        if ($pdo) {
            $stmt = $pdo->prepare("UPDATE leads SET status = ?, updated_at = NOW() WHERE id = ?");
            $stmt->execute([$newStatus, $leadId]);
            $updated = true;
        } else {
            throw new Exception("Database connection not available");
        }
    } catch (Exception $e) {
        // Use the file-based function if defined
        if (function_exists('updateLeadStatusInFile')) {
            $updated = updateLeadStatusInFile($leadId, $newStatus);
        } else {
            // Fallback to direct file manipulation
            $dataDir = DATA_DIR;
            $leadJsonFile = "$dataDir/leads/$leadId.json";
            $csvFile = "$dataDir/leads.csv";
            
            // Update the JSON file if it exists
            if (file_exists($leadJsonFile)) {
                $leadData = json_decode(file_get_contents($leadJsonFile), true);
                if ($leadData) {
                    $leadData['status'] = $newStatus;
                    file_put_contents($leadJsonFile, json_encode($leadData, JSON_PRETTY_PRINT));
                    $updated = true;
                }
            }
            
            // Update the CSV file
            if (file_exists($csvFile)) {
                $tempFile = "$dataDir/leads_temp.csv";
                $csvUpdated = false;
                
                if (($readHandle = fopen($csvFile, "r")) !== FALSE && ($writeHandle = fopen($tempFile, "w")) !== FALSE) {
                    // Copy header row
                    $header = fgetcsv($readHandle, 1000);
                    fputcsv($writeHandle, $header);
                    
                    // Update specific lead entry
                    while (($data = fgetcsv($readHandle, 1000)) !== FALSE) {
                        if ($data[0] === $leadId) {
                            $data[6] = $newStatus; // Update status column
                            $csvUpdated = true;
                        }
                        fputcsv($writeHandle, $data);
                    }
                    
                    fclose($readHandle);
                    fclose($writeHandle);
                    
                    // Only replace the file if we actually updated something
                    if ($csvUpdated) {
                        rename($tempFile, $csvFile);
                        $updated = true;
                    } else {
                        unlink($tempFile); // Delete temp file if no update happened
                    }
                }
            }
        }
        
        if (!$updated) {
            $updateError = 'Failed to update lead status.';
        }
    }
    
    // Redirect to avoid form resubmission
    if (!isset($updateError)) {
        header('Location: dashboard.php');
        exit;
    }
}

// Get statistics data
$stats = [
    'total_leads' => 0,
    'new_leads' => 0,
    'converted_leads' => 0,
    'conversion_rate' => 0,
    'total_chats' => 0
];

try {
    // First try database approach
    if ($pdo) {
        // Get total leads
        $stmt = $pdo->query("SELECT COUNT(*) AS count FROM leads");
        $result = $stmt->fetch();
        $stats['total_leads'] = $result['count'];
        
        // Get new leads
        $stmt = $pdo->query("SELECT COUNT(*) AS count FROM leads WHERE status = 'new'");
        $result = $stmt->fetch();
        $stats['new_leads'] = $result['count'];
        
        // Get converted leads
        $stmt = $pdo->query("SELECT COUNT(*) AS count FROM leads WHERE status = 'converted'");
        $result = $stmt->fetch();
        $stats['converted_leads'] = $result['count'];
        
        // Get total chats
        $stmt = $pdo->query("SELECT COUNT(*) AS count FROM chat_sessions");
        $result = $stmt->fetch();
        $stats['total_chats'] = $result['count'];
    } else {
        throw new Exception("Database connection not available");
    }
} catch (Exception $e) {
    // First try to use the file-based function
    if (function_exists('getLeadsFromFile')) {
        $fileLeads = getLeadsFromFile();
        
        $totalLeads = count($fileLeads);
        $newLeads = 0;
        $convertedLeads = 0;
        
        foreach ($fileLeads as $lead) {
            if (isset($lead['status'])) {
                if ($lead['status'] === 'new') {
                    $newLeads++;
                } else if ($lead['status'] === 'converted') {
                    $convertedLeads++;
                }
            } else {
                // If no status found, count as new by default
                $newLeads++;
            }
        }
        
        $stats['total_leads'] = $totalLeads;
        $stats['new_leads'] = $newLeads;
        $stats['converted_leads'] = $convertedLeads;
        $stats['total_chats'] = $totalLeads; // Assuming each lead had at least one chat session
    } else {
        // Fallback to direct file approach
        $dataDir = DATA_DIR;
        $csvFile = "$dataDir/leads.csv";
        
        if (file_exists($csvFile)) {
            // Read all leads from CSV
            $fileLeads = [];
            if (($handle = fopen($csvFile, "r")) !== FALSE) {
                // Skip header row
                fgetcsv($handle, 1000);
                
                $totalLeads = 0;
                $newLeads = 0;
                $convertedLeads = 0;
                
                while (($data = fgetcsv($handle, 1000)) !== FALSE) {
                    $totalLeads++;
                    
                    // Check status (column 6)
                    if (isset($data[6])) {
                        if ($data[6] === 'new') {
                            $newLeads++;
                        } else if ($data[6] === 'converted') {
                            $convertedLeads++;
                        }
                    } else {
                        // If no status found, count as new by default
                        $newLeads++;
                    }
                }
                fclose($handle);
                
                $stats['total_leads'] = $totalLeads;
                $stats['new_leads'] = $newLeads;
                $stats['converted_leads'] = $convertedLeads;
                $stats['total_chats'] = $totalLeads; // Assuming each lead had at least one chat session
            }
        }
    }
}

// Calculate conversion rate regardless of where the data came from
$stats['conversion_rate'] = $stats['total_leads'] > 0 ? 
    round(($stats['converted_leads'] / $stats['total_leads']) * 100, 2) : 0;

// Get leads with pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$perPage = 10;
$offset = ($page - 1) * $perPage;
$leads = [];
$totalLeads = 0;
$leadsError = null;

try {
    // First try the database approach
    if ($pdo) {
        // Get total lead count
        $stmt = $pdo->query("SELECT COUNT(*) AS count FROM leads");
        $result = $stmt->fetch();
        $totalLeads = $result['count'];
        
        // Get paginated leads
        $stmt = $pdo->prepare("
            SELECT * FROM leads
            ORDER BY created_at DESC
            LIMIT ? OFFSET ?
        ");
        $stmt->bindValue(1, $perPage, PDO::PARAM_INT);
        $stmt->bindValue(2, $offset, PDO::PARAM_INT);
        $stmt->execute();
        $leads = $stmt->fetchAll();
    } else {
        throw new Exception("Database connection not available");
    }
    
    // Calculate total pages
    $totalPages = ceil($totalLeads / $perPage);
} catch (Exception $e) {
    // First try to use the file-based API functions
    if (function_exists('getLeadsFromFile')) {
        $fileLeads = getLeadsFromFile();
        
        // Sort leads by created_at (newest first)
        usort($fileLeads, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });
        
        // Count total leads
        $totalLeads = count($fileLeads);
        
        // Paginate results
        $leads = array_slice($fileLeads, $offset, $perPage);
        $totalPages = ceil($totalLeads / $perPage);
    } else {
        // Fall back to direct file approach
        $dataDir = DATA_DIR;
        $csvFile = "$dataDir/leads.csv";
        
        if (file_exists($csvFile)) {
            // Read all leads from CSV
            $fileLeads = [];
            if (($handle = fopen($csvFile, "r")) !== FALSE) {
                // Skip header row
                fgetcsv($handle, 1000);
                
                while (($data = fgetcsv($handle, 1000)) !== FALSE) {
                    if (count($data) >= 7) {
                        $fileLeads[] = [
                            'id' => $data[0],
                            'name' => $data[1],
                            'phone' => $data[2],
                            'requirements' => $data[3],
                            'website_id' => $data[4],
                            'created_at' => $data[5],
                            'status' => $data[6]
                        ];
                    }
                }
                fclose($handle);
                
                // Sort leads by created_at (newest first)
                usort($fileLeads, function($a, $b) {
                    return strtotime($b['created_at']) - strtotime($a['created_at']);
                });
                
                // Count total leads
                $totalLeads = count($fileLeads);
                
                // Paginate results
                $leads = array_slice($fileLeads, $offset, $perPage);
                $totalPages = ceil($totalLeads / $perPage);
            } else {
                $leadsError = 'Failed to read leads file.';
            }
        } else {
            $totalLeads = 0;
            $totalPages = 0;
        }
    }
}

// Helper function for pagination
function getPaginationUrl($page) {
    $url = 'dashboard.php';
    return $url . '?page=' . $page;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Real Estate Chatbot Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <div class="admin-container">
        <div class="sidebar">
            <div class="sidebar-header">
                <h2><?php echo APP_NAME; ?></h2>
            </div>
            
            <ul class="sidebar-nav">
                <li><a href="dashboard.php" class="active"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                <li><a href="javascript:alert('This feature is not implemented yet.');"><i class="fas fa-cog"></i> Settings</a></li>
                <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
            </ul>
        </div>
        
        <div class="content">
            <div class="header">
                <h1>Dashboard</h1>
                <div class="header-actions">
                    <span>Welcome, <?php echo htmlspecialchars($currentUser['name'] ?? $currentUser['username']); ?></span>
                </div>
            </div>
            
            <div class="stats-container">
                <div class="stat-card">
                    <h3>Total Leads</h3>
                    <div class="value"><?php echo $stats['total_leads']; ?></div>
                </div>
                
                <div class="stat-card">
                    <h3>New Leads</h3>
                    <div class="value"><?php echo $stats['new_leads']; ?></div>
                </div>
                
                <div class="stat-card">
                    <h3>Conversion Rate</h3>
                    <div class="value"><?php echo $stats['conversion_rate']; ?>%</div>
                </div>
                
                <div class="stat-card">
                    <h3>Total Chats</h3>
                    <div class="value"><?php echo $stats['total_chats']; ?></div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h2>Recent Leads</h2>
                </div>
                
                <?php if (isset($leadsError)): ?>
                    <div class="alert alert-danger"><?php echo $leadsError; ?></div>
                <?php elseif (empty($leads)): ?>
                    <div class="alert alert-info">No leads found.</div>
                <?php else: ?>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Phone</th>
                                    <th>Requirements</th>
                                    <th>Website</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($leads as $lead): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($lead['name']); ?></td>
                                        <td><?php echo htmlspecialchars($lead['phone']); ?></td>
                                        <td>
                                            <?php if (!empty($lead['requirements'])): ?>
                                                <?php echo htmlspecialchars(substr($lead['requirements'], 0, 100)); ?>
                                                <?php if (strlen($lead['requirements']) > 100): ?>...<?php endif; ?>
                                            <?php else: ?>
                                                <em>No requirements specified</em>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo htmlspecialchars($lead['website_id']); ?></td>
                                        <td><?php echo date('M j, Y', strtotime($lead['created_at'])); ?></td>
                                        <td>
                                            <span class="status status-<?php echo $lead['status']; ?>">
                                                <?php echo ucfirst($lead['status']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                                    Change Status
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <form method="POST">
                                                            <input type="hidden" name="lead_id" value="<?php echo $lead['id']; ?>">
                                                            <input type="hidden" name="status" value="new">
                                                            <button type="submit" class="dropdown-item">New</button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form method="POST">
                                                            <input type="hidden" name="lead_id" value="<?php echo $lead['id']; ?>">
                                                            <input type="hidden" name="status" value="contacted">
                                                            <button type="submit" class="dropdown-item">Contacted</button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form method="POST">
                                                            <input type="hidden" name="lead_id" value="<?php echo $lead['id']; ?>">
                                                            <input type="hidden" name="status" value="converted">
                                                            <button type="submit" class="dropdown-item">Converted</button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form method="POST">
                                                            <input type="hidden" name="lead_id" value="<?php echo $lead['id']; ?>">
                                                            <input type="hidden" name="status" value="closed">
                                                            <button type="submit" class="dropdown-item">Closed</button>
                                                        </form>
                                                    </li>
                                                </ul>
                                            </div>
                                            
                                            <button type="button" class="btn btn-sm btn-primary mt-1" 
                                                    onclick="viewChatHistory(<?php echo $lead['id']; ?>)">
                                                View Chat
                                            </button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <?php if ($totalPages > 1): ?>
                        <div class="pagination">
                            <?php if ($page > 1): ?>
                                <a href="<?php echo getPaginationUrl(1); ?>">&laquo;</a>
                                <a href="<?php echo getPaginationUrl($page - 1); ?>">&lsaquo;</a>
                            <?php endif; ?>
                            
                            <?php
                            $startPage = max(1, $page - 2);
                            $endPage = min($totalPages, $page + 2);
                            
                            for ($i = $startPage; $i <= $endPage; $i++):
                            ?>
                                <a href="<?php echo getPaginationUrl($i); ?>" 
                                   class="<?php echo $i === $page ? 'active' : ''; ?>">
                                    <?php echo $i; ?>
                                </a>
                            <?php endfor; ?>
                            
                            <?php if ($page < $totalPages): ?>
                                <a href="<?php echo getPaginationUrl($page + 1); ?>">&rsaquo;</a>
                                <a href="<?php echo getPaginationUrl($totalPages); ?>">&raquo;</a>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <!-- Chat History Modal -->
    <div class="modal fade" id="chatHistoryModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chat History</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="chatHistoryContent">
                    Loading...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialize modals
        const chatHistoryModal = new bootstrap.Modal(document.getElementById('chatHistoryModal'));
        
        // Function to view chat history
        function viewChatHistory(leadId) {
            // Fetch chat history from server
            fetch('../api/get_chat_history.php?lead_id=' + leadId)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    const contentElement = document.getElementById('chatHistoryContent');
                    
                    if (data.error) {
                        contentElement.innerHTML = `<div class="alert alert-danger">${data.error}</div>`;
                        return;
                    }
                    
                    if (!data.chat_history || data.chat_history.length === 0) {
                        contentElement.innerHTML = `<div class="alert alert-info">No chat history available.</div>`;
                        return;
                    }
                    
                    // Format the chat history
                    let html = '<div class="chat-history">';
                    
                    data.chat_history.forEach(msg => {
                        const role = msg.role === 'user' ? 'User' : 'Chatbot';
                        const contentClass = msg.role === 'user' ? 'user-message' : 'bot-message';
                        
                        html += `
                            <div class="chat-message">
                                <div class="message-header">${role}</div>
                                <div class="message-content ${contentClass}">${msg.content}</div>
                            </div>
                        `;
                    });
                    
                    html += '</div>';
                    contentElement.innerHTML = html;
                })
                .catch(error => {
                    document.getElementById('chatHistoryContent').innerHTML = `
                        <div class="alert alert-danger">
                            Failed to load chat history: ${error.message}
                        </div>
                    `;
                });
            
            // Show the modal
            chatHistoryModal.show();
        }
    </script>
    
    <style>
        /* Chat history styles */
        .chat-history {
            max-height: 60vh;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        
        .chat-message {
            margin-bottom: 15px;
        }
        
        .message-header {
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }
        
        .message-content {
            padding: 10px 15px;
            border-radius: 10px;
            display: inline-block;
            max-width: 80%;
        }
        
        .user-message {
            background-color: #e3f2fd;
            color: #0d6efd;
        }
        
        .bot-message {
            background-color: #f1f0f0;
            color: #333;
        }
        
        .dropdown-menu {
            min-width: 100%;
        }
    </style>
</body>
</html>
