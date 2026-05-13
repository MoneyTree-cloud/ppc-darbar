<?php
session_start();
// Enable error reporting and logging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ini_set("log_errors", 1);
ini_set("error_log", "php-error.log");


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// PHPMailer files
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

// Database connection
include 'config.php';


// Admin Email
// $adminEmail = "firoz.fkofficial@gmail.com";
$mailUsername = "noreply@rohitsinghrealestate.in";
$mailPassword = "Tanmay@2701";

// Get form values
$employ_id = $_POST['employ_id'] ?? '';
$calls = $_POST['calls'] ?? '';
$prospects = $_POST['prospects'] ?? '';
$hot_prospects = $_POST['hot_prospects'] ?? '';
$v_hot_prospects = $_POST['v_hot_prospects'] ?? '';
$meetings = $_POST['meetings'] ?? '';
$no_of_ob = $_POST['no_ob'] ?? '';
$project_training  = $_POST['project_training'] ?? '';
$client_names = $_POST['client_name'] ?? [];
$mobiles = $_POST['mobile'] ?? [];
$projects = $_POST['project'] ?? [];
$units = $_POST['unit'] ?? [];
$sizes = $_POST['size'] ?? [];
$costs = $_POST['total_cost'] ?? [];
$inventories = $_POST['inventory_status'] ?? [];

date_default_timezone_set("Asia/Kolkata");
$checkout = date("Y-m-d h:i:s A"); // → 2025-06-25 02:45:30 PM


// --- [NEW] TIME VALIDATION ---
// date_default_timezone_set("Asia/Kolkata");
$currentTime = new DateTime();
$startTime = new DateTime('today 09:00:00'); // 9:00 AM
$endTime = new DateTime('today 22:00:00');   // 10:00 PM

// Check if the current time is outside the allowed window
if ($currentTime < $startTime) {
    header("Location: ../leader_eod.php?type=error&message=EOD reports can only be submitted after 9:00 AM.");
    exit;
}

if ($currentTime > $endTime) {
    header("Location: ../leader_eod.php?type=error&message=Sorry, you missed your EOD report. It can't be filled after 10:00 PM. For further details, contact the admin.");
    exit;
}
// --- END OF TIME VALIDATION ---


$domain = "rohitsinghrealestate.in";
// Email credentials
$mailUsername = 'noreply@' . $domain;
$mailPassword = 'Tanmay@2701'; // Change before production



// 1. Fetch employee name
$employ_id = $conn->real_escape_string($employ_id);
$res = $conn->query("SELECT name FROM team_login WHERE employ_id = '$employ_id' LIMIT 1");

if ($res && $res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $employee_full = $row['name'] . " ($employ_id)";
} else {
    // $employee_full = "Unknown ($employ_id)";
    header("Location: ../leader_eod.php?type=error&message=Employ Id: $employ_id does not exist in the team, Please fill with Correct Employ Id!!");
    exit;
}


// Check if this user has already submitted today
$today = date("Y-m-d"); // only date part
$checkQuery = "SELECT id FROM team_leader_eod WHERE employ_id = '$employee_full' AND DATE(check_out) = '$today' LIMIT 1";
$checkResult = $conn->query($checkQuery);

if ($checkResult && $checkResult->num_rows > 0) {
    header("Location: ../leader_eod.php?type=error&message=You have already submitted today's EOD. Only one submission allowed per day.");
exit;

}



// Loop and insert each expected sale
for ($i = 0; $i < count($client_names); $i++) {
    $client = $conn->real_escape_string($client_names[$i]);
    $mobile = $conn->real_escape_string($mobiles[$i]);
    $project = $conn->real_escape_string($projects[$i]);
    $unit = $conn->real_escape_string($units[$i]);
    $size = $conn->real_escape_string($sizes[$i]);
    $cost = $conn->real_escape_string($costs[$i]);
    $inventory = $conn->real_escape_string($inventories[$i] ?? '-');

   $sql = "INSERT INTO team_leader_eod (employ_id, calls, prospects, total_team_hot_prospect, total_team_very_hot_prospect, meetings, no_of_ob, project_training, client_name, mobile, project, unit, size, total_cost, inventory_status, check_out)
VALUES ('$employee_full', '$calls', '$prospects', '$hot_prospects', '$v_hot_prospects', '$meetings', '$no_of_ob', '$project_training', '$client', '$mobile', '$project', '$unit', '$size', '$cost', '$inventory', '$checkout')";

    $conn->query($sql);
}
$conn->close();

// Now send email

$emailStyle = "
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f9f9f9;
            padding: 20px;
        }
        .email-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        h2 {
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
            margin-top: 0;
        }
        h3 {
            color: #2980b9;
            margin-top: 25px;
        }
        .summary-section {
            background-color: #f8fafc;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            border-left: 4px solid #3498db;
        }
        .summary-item {
            display: flex;
            margin-bottom: 8px;
        }
        .summary-label {
            font-weight: 600;
            min-width: 200px;
            color: #2c3e50;
        }
        .summary-value {
            color: #34495e;
        }
        .divider {
            height: 1px;
            background-color: #e0e0e0;
            margin: 20px 0;
        }
        .client-card {
            background-color: #f8fafc;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
            border: 1px solid #e0e0e0;
        }
        .client-header {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
        }
        .highlight {
            font-weight: 600;
            color: #e74c3c;
        }
        .inventory-yes {
            color: #27ae60;
            font-weight: 600;
        }
        .inventory-no {
            color: #7f8c8d;
        }
    </style>
";

$message = "
<html>
<head>
    <title>Team Leader EOD Report - $employee_full</title>
    $emailStyle
</head>
<body>
    <div class='email-container'>
        <h2>Team Leader EOD Report</h2>
        
        <div class='summary-section'>
            <div class='summary-item'>
                <span class='summary-label'>Employee Name:</span>
                <span class='summary-value'>$employee_full</span>
            </div>
            <div class='summary-item'>
                <span class='summary-label'>Check Out Time:</span>
                <span class='summary-value'>$checkout</span>
            </div>
        </div>
        
        <div class='summary-section'>
            <h3>Team Performance Summary</h3>
            <div class='summary-item'>
                <span class='summary-label'>Teams Calls:</span>
                <span class='summary-value'>$calls</span>
            </div>
            <div class='summary-item'>
                <span class='summary-label'>Team Prospects:</span>
                <span class='summary-value'>$prospects</span>
            </div>
            <div class='summary-item'>
                <span class='summary-label'>Team Hot Prospects:</span>
                <span class='summary-value'>$hot_prospects</span>
            </div>
            <div class='summary-item'>
                <span class='summary-label'>Team Very Hot Prospects:</span>
                <span class='summary-value'>$v_hot_prospects</span>
            </div>
            <div class='summary-item'>
                <span class='summary-label'>Team Meetings:</span>
                <span class='summary-value'>$meetings</span>
            </div>
            <div class='summary-item'>
                <span class='summary-label'>No. of OB:</span>
                <span class='summary-value'>$no_of_ob</span>
            </div>
            <div class='summary-item'>
                <span class='summary-label'>Project Training:</span>
                <span class='summary-value'>$project_training</span>
            </div>
        </div>
        
        <h3>Expected Sales Details</h3>";

for ($i = 0; $i < count($client_names); $i++) {
    if (empty($client_names[$i])) continue;
    
    $inventoryStatus = $inventories[$i] ?? 'no';
    $inventoryClass = ($inventoryStatus == 'yes') ? 'inventory-yes' : 'inventory-no';
    
    $message .= "
        <div class='client-card'>
            <div class='client-header'>Client #" . ($i + 1) . "</div>
            <div class='summary-item'>
                <span class='summary-label'>Client Name:</span>
                <span class='summary-value'>" . htmlspecialchars($client_names[$i]) . "</span>
            </div>
            <div class='summary-item'>
                <span class='summary-label'>Mobile:</span>
                <span class='summary-value'>" . htmlspecialchars($mobiles[$i] ?? 'N/A') . "</span>
            </div>
            <div class='summary-item'>
                <span class='summary-label'>Project:</span>
                <span class='summary-value'>" . htmlspecialchars($projects[$i] ?? 'N/A') . "</span>
            </div>
            <div class='summary-item'>
                <span class='summary-label'>Unit:</span>
                <span class='summary-value'>" . htmlspecialchars($units[$i] ?? 'N/A') . "</span>
            </div>
            <div class='summary-item'>
                <span class='summary-label'>Size:</span>
                <span class='summary-value'>" . htmlspecialchars($sizes[$i] ?? 'N/A') . "</span>
            </div>
            <div class='summary-item'>
                <span class='summary-label'>Total Cost:</span>
                <span class='summary-value'>" . htmlspecialchars($costs[$i] ?? 'N/A') . "</span>
            </div>
            <div class='summary-item'>
                <span class='summary-label'>Inventory Hold on SAP:</span>
                <span class='summary-value $inventoryClass'>" . 
                htmlspecialchars(ucfirst($inventoryStatus)) . "</span>
            </div>
        </div>";
}

$message .= "
    </div>
</body>
</html>";

$mail = new PHPMailer(true);
try {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.hostinger.com';
    $mail->SMTPAuth = true;
    $mail->Username = $mailUsername;
    $mail->Password = $mailPassword; 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    $mail->setFrom($mailUsername, "Leaders EOD Report $employee_full");

    $mail->addAddress('work.official0904@gmail.com');
    $mail->addAddress('akash.esports4g@gmail.com');
    $mail->addAddress('singhrohit16988@gmail.com');

    $mail->isHTML(true);
    $mail->Subject = "Leaders EOD Report of $employee_full";
    $mail->Body = $message;

    $mail->send();
    $_SESSION['valid_eod_submission'] = true;
    $_SESSION['employee_full'] = $employee_full;
    $_SESSION['previous_page'] = 'leader_eod.php';
    header("Location: ../thank-you-eod.php?type=success&message=Data Submitted Successfully!!");
    exit;
} catch (Exception $e) {
    echo "Mailer Error: " . $mail->ErrorInfo;
}
?>
