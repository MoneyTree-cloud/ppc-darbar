<?php
/**
 * Real Estate Chatbot Admin - Index Redirect
 * This file simply redirects to the dashboard or login page as appropriate.
 */

// Include configuration
require_once '../config/config.php';
require_once '../api/auth.php';

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to dashboard if logged in, otherwise to login page
if (isLoggedIn()) {
    header('Location: dashboard.php');
} else {
    header('Location: login.php');
}

exit;
