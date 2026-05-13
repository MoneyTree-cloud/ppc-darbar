<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

date_default_timezone_set("Asia/Kolkata");

// Form data
$name = $_POST['name'] ?? '';
$mobile = $_POST['mobile'] ?? '';
$email = $_POST['email'] ?? '';
$domain = $_POST['domain'] ?? '';
$domainName = $_POST['projectName'] ?? ''; // Changed to use projectName
$ip = $_SERVER['REMOTE_ADDR'];
$bot = !empty($_POST['website']) ? 'Bot' : 'Human';
$status = "New lead";
$read_status = "unread";
$referer = $_SERVER['HTTP_REFERER'] ?? 'Direct Access';

$postedDateTime = $_POST['date_time'] ?? '';  // Example: 2025-09-25T16:42

// Correct parsing for datetime-local input
$date = DateTime::createFromFormat("Y-m-d\TH:i", $postedDateTime);

if ($date) {
    // Set seconds = 21
    $date->setTime($date->format("H"), $date->format("i"), 21);

    // Format into Y-m-d H:i:s
    $dateTimeWithSeconds = $date->format("Y-m-d H:i:s");
} else {
    die("Invalid date format: " . htmlspecialchars($postedDateTime));
}

$mailUsername = 'info@' . $domain;




$mailPassword = 'Hooda@ql2'; // Change before production

try {
    // Only send admin mail if Human
    if ($bot === 'Human') {
        $adminMail = new PHPMailer(true);
        $adminMail->isSMTP();
        $adminMail->Host = 'smtp.hostinger.com';
        $adminMail->SMTPAuth = true;
        $adminMail->Username = $mailUsername;
        $adminMail->Password = $mailPassword;
        $adminMail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $adminMail->Port = 465;

        $adminMail->setFrom($mailUsername, "$domainName Lead Notification");
        $adminMail->addAddress('vivekhoodaql2@gmail.com'); 
        $adminMail->isHTML(true);
        $adminMail->Subject = "New Lead from $domainName";
        $adminMail->Body = '
            <div style="font-family:Segoe UI, sans-serif; background: #f5f5f5; padding: 20px;">
                <div style="max-width: 600px; margin: auto; background: #ffffff; border-radius: 8px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); overflow: hidden;">
                    <div style="background-color: #163b6e; padding: 20px; color: white; text-align: center;">
                        <h2 style="margin: 0;">‼️New Lead Alert‼️ <br> ' . $domain . '</h2>
                    </div>
                    <div style="padding: 25px;">
                        <p style="font-size: 16px; margin-bottom: 20px;">A new lead has submitted their details on the ' . $domainName . ':</p>
                        <table style="width: 100%; border-collapse: collapse; font-size: 15px;">
                            <tr><td style="padding: 10px; background: #f1f1f1; width: 35%;"><strong>Name</strong></td><td style="padding: 10px;"><strong>' . htmlspecialchars($name) . '</strong></td></tr>
                            <tr>
                                <td style="padding: 10px; background: #f1f1f1;"><strong>Mobile</strong></td>
                                <td style="padding: 10px;"><a href="tel:' . htmlspecialchars($mobile) . '" style="color: #2980b9; text-decoration: none;"><strong>' . htmlspecialchars($mobile) . '</strong></a></td></tr>
                            <tr><td style="padding: 10px; background: #f1f1f1;"><strong>Email</strong></td><td style="padding: 10px;">' . htmlspecialchars($email) . '</td></tr>
                            <tr><td style="padding: 10px; background: #f1f1f1;"><strong>Submitted At</strong></td><td style="padding: 10px;">' . $dateTimeWithSeconds . '</td></tr>
                        </table>
                        <p style="margin-top: 30px; font-size: 14px; color: #555;">Check <a href="https://rohitsinghrealestate.in/">Dashboard</a> or follow up directly for conversion opportunity.</p>
                    </div>
                    <div style="background: #f1f1f1; text-align: center; padding: 10px; font-size: 13px; color: #888;">
                        ' . $domainName . ' - Lead Notification System
                    </div>
                </div>
            </div>
        ';
        $adminMail->send();
    }    

    header("Location: ../index.php?type=success&message=Lead Submitted Successfully!!");
    exit();

} catch (Exception $e) {
    echo "Failed to process request. Mail error: " . $e->getMessage();
}

?>