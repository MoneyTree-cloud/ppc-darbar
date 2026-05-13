<?php
/**
 * Real Estate Chatbot API - Authentication Helper
 * This file provides authentication functions for the admin panel.
 */

// Include configuration if not already included
if (!defined('DB_HOST')) {
    require_once '../config/config.php';
}

/**
 * Authenticate user with username and password
 * 
 * @param string $username Username
 * @param string $password Password
 * @return array|bool User data or false if authentication fails
 */
function authenticateUser($username, $password) {
    // First try database authentication if possible
    $pdo = getDbConnection();
    
    if ($pdo) {
        try {
            $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
            $stmt->execute([$username]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password'])) {
                // Update last login time
                $updateStmt = $pdo->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
                $updateStmt->execute([$user['id']]);
                
                // Remove password from returned user data
                unset($user['password']);
                return $user;
            }
        } catch (PDOException $e) {
            error_log("Database authentication error: " . $e->getMessage());
            // Continue to fallback authentication
        }
    }
    
    // Fallback to config-based authentication if database fails or no user found
    if ($username === ADMIN_USERNAME) {
        // For config-based admin, check if password matches
        // If ADMIN_PASSWORD is already hashed (starts with $), use password_verify
        // Otherwise, do a direct comparison
        $isValid = false;
        
        if (substr(ADMIN_PASSWORD, 0, 1) === '$') {
            $isValid = password_verify($password, ADMIN_PASSWORD);
        } else {
            $isValid = ($password === ADMIN_PASSWORD);
        }
        
        if ($isValid) {
            // Create a user array for the admin
            return [
                'id' => 1,
                'username' => ADMIN_USERNAME,
                'email' => ADMIN_EMAIL ?? 'admin@example.com',
                'name' => 'Administrator',
                'role' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ];
        }
    }
    
    return false;
}

/**
 * Check if user is logged in
 * 
 * @return bool Whether user is logged in
 */
function isLoggedIn() {
    return isset($_SESSION['user']) && !empty($_SESSION['user']['id']);
}

/**
 * Ensure user is logged in, redirect to login page if not
 */
function requireLogin() {
    if (!isLoggedIn()) {
        header('Location: login.php');
        exit;
    }
}

/**
 * Get current user data
 * 
 * @return array Current user data or empty array if not logged in
 */
function getCurrentUser() {
    return $_SESSION['user'] ?? [];
}

/**
 * Log out current user
 */
function logoutUser() {
    // Unset session variables
    unset($_SESSION['user']);
    
    // Destroy the session
    session_destroy();
    
    // Delete session cookie
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
}

/**
 * Change user password
 * 
 * @param int $userId User ID
 * @param string $currentPassword Current password
 * @param string $newPassword New password
 * @return bool Success or failure
 */
function changePassword($userId, $currentPassword, $newPassword) {
    $pdo = getDbConnection();
    
    if (!$pdo) {
        return false;
    }
    
    try {
        // First verify current password
        $stmt = $pdo->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();
        
        if (!$user || !password_verify($currentPassword, $user['password'])) {
            return false;
        }
        
        // Hash new password and update
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateStmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
        $updateStmt->execute([$hashedPassword, $userId]);
        
        return $updateStmt->rowCount() > 0;
    } catch (PDOException $e) {
        error_log("Password change error: " . $e->getMessage());
        return false;
    }
}

/**
 * Create CSRF token
 * 
 * @return string CSRF token
 */
function createCsrfToken() {
    $token = bin2hex(random_bytes(32));
    $_SESSION['csrf_token'] = $token;
    return $token;
}

/**
 * Verify CSRF token
 * 
 * @param string $token Token to verify
 * @return bool Whether token is valid
 */
function verifyCsrfToken($token) {
    if (!isset($_SESSION['csrf_token'])) {
        return false;
    }
    
    $valid = hash_equals($_SESSION['csrf_token'], $token);
    
    // Consume token after validation (one-time use)
    unset($_SESSION['csrf_token']);
    
    return $valid;
}
