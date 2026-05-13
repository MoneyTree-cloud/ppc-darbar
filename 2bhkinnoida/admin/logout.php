<?php
/**
 * Real Estate Chatbot Admin - Logout
 */

// Include configuration
require_once '../config/config.php';
require_once '../api/auth.php';

// Log out the user
logoutUser();

// Redirect to login page
header('Location: login.php');
exit;
