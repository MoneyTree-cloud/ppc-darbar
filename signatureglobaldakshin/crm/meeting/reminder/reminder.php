<?php
$to = "work.official0904@gmail.com";
$to = "firozboy77@gmail.com";
// $to = "akash.esports4g@gmail.com";
$subject = "Event Reminder: 15 August 2025 at Redisson Hotel";
$from = "noreply@rohitsinghrealestate.com"; // Email from Hostinger
$headers = "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
$headers .= "From: Event Reminder <$from>" . "\r\n";

// Load the HTML template
$message = file_get_contents('template.html');

// Time and date
$timestamp = date("Y-m-d H:i:s");

if(mail($to, $subject, $message, $headers)) {
    $logMessage = "[$timestamp] Email sent successfully to $to\n";
    echo "Email sent successfully!";
} else {
    $logMessage = "[$timestamp] Failed to send email to $to\n";
    echo "Email sending failed.";
}

// Append to log file
file_put_contents("email-log.txt", $logMessage, FILE_APPEND);
?>
