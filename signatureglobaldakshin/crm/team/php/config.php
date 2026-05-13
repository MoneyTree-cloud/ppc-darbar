<?php
// config.php

$host = "localhost";
$user = "u242458031_main_dashboard";
$password = "Tanmay@2701";
$database = "u242458031_dashboard";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection Failed: " . $conn->connect_error);
}

// --- [NEW] TIME VALIDATION ---
date_default_timezone_set("Asia/Kolkata");

// Always remember to use `$conn` wherever you want database connection
?>
