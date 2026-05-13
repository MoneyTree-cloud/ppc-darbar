<?php
/**
 * Real Estate Chatbot Database Connection Handler
 */

// Include configuration if not already included
if (!defined('DB_HOST')) {
    require_once __DIR__ . '/config.php';
}

/**
 * Get database connection
 * 
 * @return PDO|null Database connection or null if using file-based storage
 */
function getDbConnection() {
    static $pdo = null;
    
    // If we're using file-based storage, don't attempt to connect to the database
    if (defined('STORAGE_TYPE') && STORAGE_TYPE === 'file') {
        return null;
    }
    
    if ($pdo === null) {
        try {
            // MySQL connection
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
            
        } catch (PDOException $e) {
            // Log error but don't expose database details
            error_log("Database connection error: " . $e->getMessage());
            return null;
        }
    }
    
    return $pdo;
}

/**
 * Save lead data to file storage
 * 
 * @param array $leadData Lead data to save
 * @return int|bool Generated ID or false on failure
 */
function saveLeadToFile($leadData) {
    if (!is_dir(DATA_DIR)) {
        mkdir(DATA_DIR, 0755, true);
    }
    
    if (!is_dir(DATA_DIR . '/leads')) {
        mkdir(DATA_DIR . '/leads', 0755, true);
    }
    
    // Generate a unique ID for the lead
    $id = time() . rand(1000, 9999);
    $leadData['id'] = $id;
    $leadData['created_at'] = date('Y-m-d H:i:s');
    $leadData['status'] = $leadData['status'] ?? 'new';
    
    // Save complete lead data to JSON file
    $jsonFile = DATA_DIR . '/leads/' . $id . '.json';
    file_put_contents($jsonFile, json_encode($leadData, JSON_PRETTY_PRINT));
    
    // Append lead to CSV file for easy viewing
    $csvFile = DATA_DIR . '/leads.csv';

    // Create CSV header if file doesn't exist
    if (!file_exists($csvFile)) {
        file_put_contents($csvFile, "ID,Name,Phone,Requirements,Website,Created At,Status\n");
    }

    // Append lead data to CSV with file locking
    $csvLine = $id . ',"' .
        str_replace('"', '""', $leadData['name']) . '","' .
        str_replace('"', '""', $leadData['phone']) . '","' .
        str_replace('"', '""', $leadData['requirements'] ?? '') . '","' .
        str_replace('"', '""', $leadData['website_id'] ?? 'default') . '","' .
        $leadData['created_at'] . '","' .
        $leadData['status'] . '"' . "\n";

    $fp = fopen($csvFile, 'a');
    if ($fp) {
        if (flock($fp, LOCK_EX)) {
            fwrite($fp, $csvLine);
            flock($fp, LOCK_UN);
        }
        fclose($fp);
    }
    
    return $id;
}

/**
 * Get all leads from file storage
 * 
 * @return array Array of leads
 */
function getLeadsFromFile() {
    $csvFile = DATA_DIR . '/leads.csv';
    
    if (!file_exists($csvFile)) {
        return [];
    }
    
    $leads = [];
    $rows = array_map('str_getcsv', file($csvFile));
    $headers = array_shift($rows); // Remove header row
    
    foreach ($rows as $row) {
        if (count($row) === count($headers)) {
            $lead = array_combine($headers, $row);
            $leads[] = $lead;
        }
    }
    
    return $leads;
}

/**
 * Get a specific lead from file storage
 * 
 * @param int $id Lead ID
 * @return array|null Lead data or null if not found
 */
function getLeadFromFile($id) {
    $jsonFile = DATA_DIR . '/leads/' . $id . '.json';
    
    if (!file_exists($jsonFile)) {
        return null;
    }
    
    return json_decode(file_get_contents($jsonFile), true);
}

/**
 * Update lead status in file storage
 * 
 * @param int $id Lead ID
 * @param string $status New status
 * @return bool Success status
 */
function updateLeadStatusInFile($id, $status) {
    $jsonFile = DATA_DIR . '/leads/' . $id . '.json';
    
    if (!file_exists($jsonFile)) {
        return false;
    }
    
    $lead = json_decode(file_get_contents($jsonFile), true);
    $lead['status'] = $status;
    
    // Update JSON file
    file_put_contents($jsonFile, json_encode($lead, JSON_PRETTY_PRINT));
    
    // Update CSV file
    $csvFile = DATA_DIR . '/leads.csv';
    if (file_exists($csvFile)) {
        $rows = array_map('str_getcsv', file($csvFile));
        $headers = array_shift($rows); // Remove header row
        
        foreach ($rows as $key => $row) {
            if (count($row) === count($headers)) {
                $rowData = array_combine($headers, $row);
                if ($rowData['id'] == $id) {
                    $rows[$key][array_search('status', $headers)] = $status;
                    break;
                }
            }
        }
        
        // Prepare CSV content
        $csvContent = implode(',', $headers) . "\n";
        foreach ($rows as $row) {
            $csvContent .= implode(',', array_map(function($cell) {
                return '"' . str_replace('"', '""', $cell) . '"';
            }, $row)) . "\n";
        }

        $fp = fopen($csvFile, 'w');
        if ($fp) {
            if (flock($fp, LOCK_EX)) {
                fwrite($fp, $csvContent);
                flock($fp, LOCK_UN);
            }
            fclose($fp);
        }
    }
    
    return true;
}

/**
 * Check if database tables exist, create if they don't
 */
function initDatabase() {
    $pdo = getDbConnection();
    
    if (!$pdo) {
        return false;
    }
    
    try {
        // MySQL implementation
        
        // Check if leads table exists
        $stmt = $pdo->query("SHOW TABLES LIKE 'leads'");
        if ($stmt->rowCount() === 0) {
            // Create leads table
            $pdo->exec("
                CREATE TABLE `leads` (
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `name` VARCHAR(255) NOT NULL,
                    `phone` VARCHAR(50) NOT NULL,
                    `requirements` TEXT NULL,
                    `chat_history` TEXT NULL,
                    `status` ENUM('new', 'contacted', 'converted', 'closed') NOT NULL DEFAULT 'new',
                    `website_id` VARCHAR(255) NOT NULL DEFAULT 'default',
                    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`),
                    INDEX `idx_website_id` (`website_id`),
                    INDEX `idx_status` (`status`),
                    INDEX `idx_created_at` (`created_at`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ");
        }
        
        // Check if users table exists
        $stmt = $pdo->query("SHOW TABLES LIKE 'users'");
        if ($stmt->rowCount() === 0) {
            // Create users table
            $pdo->exec("
                CREATE TABLE `users` (
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `username` VARCHAR(50) NOT NULL,
                    `password` VARCHAR(255) NOT NULL,
                    `email` VARCHAR(255) NOT NULL,
                    `name` VARCHAR(255) NULL,
                    `role` ENUM('admin', 'user') NOT NULL DEFAULT 'user',
                    `last_login` DATETIME NULL,
                    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`),
                    UNIQUE KEY `username` (`username`),
                    UNIQUE KEY `email` (`email`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ");
            
            // Insert default admin user
            $stmt = $pdo->prepare("
                INSERT INTO `users` (`username`, `password`, `email`, `name`, `role`) 
                VALUES (?, ?, ?, 'Administrator', 'admin')
            ");
            $stmt->execute([ADMIN_USERNAME, ADMIN_PASSWORD, ADMIN_EMAIL]);
        }
        
        // Check if websites table exists
        $stmt = $pdo->query("SHOW TABLES LIKE 'websites'");
        if ($stmt->rowCount() === 0) {
            // Create websites table
            $pdo->exec("
                CREATE TABLE `websites` (
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `website_id` VARCHAR(255) NOT NULL,
                    `name` VARCHAR(255) NOT NULL,
                    `url` VARCHAR(255) NULL,
                    `theme_color` VARCHAR(20) DEFAULT '#3498db',
                    `initial_message` TEXT NULL,
                    `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `updated_at` DATETIME NULL ON UPDATE CURRENT_TIMESTAMP,
                    PRIMARY KEY (`id`),
                    UNIQUE KEY `website_id` (`website_id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ");
            
            // Insert default website
            $stmt = $pdo->prepare("
                INSERT INTO `websites` (`website_id`, `name`, `url`) 
                VALUES ('default', 'Default Website', ?)
            ");
            $stmt->execute([APP_URL]);
        }
        
        // Check if chat_sessions table exists
        $stmt = $pdo->query("SHOW TABLES LIKE 'chat_sessions'");
        if ($stmt->rowCount() === 0) {
            // Create chat_sessions table
            $pdo->exec("
                CREATE TABLE `chat_sessions` (
                    `id` INT(11) NOT NULL AUTO_INCREMENT,
                    `session_id` VARCHAR(255) NOT NULL,
                    `website_id` VARCHAR(255) NOT NULL DEFAULT 'default',
                    `user_ip` VARCHAR(45) NULL,
                    `user_agent` TEXT NULL,
                    `message_count` INT(11) NOT NULL DEFAULT 0,
                    `lead_id` INT(11) NULL,
                    `started_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                    `last_message_at` DATETIME NULL,
                    PRIMARY KEY (`id`),
                    UNIQUE KEY `session_id` (`session_id`),
                    INDEX `idx_website_id` (`website_id`),
                    INDEX `idx_lead_id` (`lead_id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ");
        }
        
        return true;
    } catch (PDOException $e) {
        error_log("Database initialization error: " . $e->getMessage());
        return false;
    }
}
