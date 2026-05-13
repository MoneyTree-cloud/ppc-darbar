<?php
// config.php


$host = "localhost";
$user = "u832687858_crm";
$password = "Demo@ql2";
$database = "u832687858_crm";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}


// [NEW] Add these lines for email credentials
// define('SMTP_HOST', 'smtp.hostinger.com');
// define('SMTP_USERNAME', 'info@signatureglobaldakshin.in');
// define('SMTP_PASSWORD', 'YOUR PASSWORD'); // Your actual password
// define('SMTP_PORT', 465);

// --- [NEW] TIME VALIDATION ---
date_default_timezone_set("Asia/Kolkata");

// Always remember to use `$conn` wherever you want database connection
?>
