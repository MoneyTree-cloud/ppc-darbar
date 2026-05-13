<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// --- Database Credentials ---
$dbHost = 'localhost';
$dbUser = 'u242458031_main_dashboard';
$dbPass = 'Tanmay@2701';
$dbName = 'u242458031_dashboard';

// --- Email Credentials ---
$mailUsername = 'noreply@rohitsinghrealestate.in';
$mailPassword = 'Tanmay@2701';
$domainName  = 'MoneyTree Realty Services Ltd.';
$domain      = 'rohitsinghrealestate.com';

// --- DB Connection ---
$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// --- Email Validation Function ---
function isValidEmail($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return false;
    }
    $domain = substr(strrchr($email, "@"), 1);
    if (!checkdnsrr($domain, "MX")) {
        return false;
    }
    return true;
}

// --- Countdown ---
date_default_timezone_set('Asia/Kolkata');
$today = new DateTime();
$today->setTime(0, 0, 0);
$eventDate = new DateTime('2025-08-15');
$eventDate->setTime(0, 0, 0);
$diffDays = (int)$today->diff($eventDate)->format('%r%a');

$days_remain_text = $diffDays > 1 ? "$diffDays Days to go" :
                    ($diffDays == 1 ? "Tomorrow!" :
                    ($diffDays == 0 ? "Today!" : "Event Over"));

// Example: Fetch 0–30
$offset = 0; // skip first 0
$limit  = 30; // fetch next 0 till 30

$sql = "SELECT t.id, t.ticket_id, t.name, t.email, t.timing, t.invited_by, t.inviter_phone
        FROM event t
        INNER JOIN (
            SELECT MIN(id) as min_id
            FROM event
            WHERE (is_invalid IS NULL OR is_invalid = 0)
            GROUP BY email
        ) sub ON t.id = sub.min_id
        ORDER BY t.id ASC
        LIMIT $limit OFFSET $offset";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        
        $id             = $row["id"];
        $recipientEmail = trim($row["email"]);
        $recipientName  = $row["name"];
        $eventTiming    = $row["timing"];
        $invitedBy      = $row["invited_by"];
        $inviterPhone   = $row["inviter_phone"];
        $ticket_id      = $row["ticket_id"];

        // --- Validate Email Before Sending ---
        if (!isValidEmail($recipientEmail)) {
            $conn->query("UPDATE event SET is_invalid = 1 WHERE id = $id");
            echo "❌ Skipped invalid email: {$recipientEmail}<br>";
            continue;
        }

        // --- Email Body ---
        $emailBody = <<<HTML
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>PropTree Mela 2.0 - Countdown!</title>
            <link rel="preconnect" href="https://fonts.googleapis.com">
            <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
            <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
        </head>
        <body style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: 'Poppins', Arial, sans-serif;">
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr>
                    <td align="center">
                        <table width="100%" style="max-width: 480px; background: linear-gradient(to bottom, #FF9933 33.3%, #FFFFFF 33.3%, #FFFFFF 66.6%, #138808 66.6%); color: #2c3e50; border-radius: 12px; overflow: hidden; box     -shadow: 0 4px 12px rgba(0,0,0,0.2); border: 1px solid #ddd;">
                            
                            <!-- Header -->
                            <tr>
                                <td align="center" style="padding: 24px; background-color: #FF9933;">
                                    <img src="https://blanchedalmond-squid-383723.hostingersite.com/event/assets/img/proptree.png" alt="PropTree Logo" style="width: 180px; height: auto; filter: brightness(0.9);">
                                    <h1 style="margin: 10px 0 0; font-size: 28px; letter-spacing: 1px; color: white; text-shadow: 1px 1px 2px rgba(0,0,0,0.2);">Mela 2.0</h1>
                                </td>
                            </tr>
        
                            <!-- Countdown Timer -->
                            <tr>
                                <td align="center" style="padding: 20px; background-color: white;">
                                     <h2 style="margin: 0; font-size: 36px; color: #000080; font-weight: 700;">{$days_remain_text}</h2>
                                     <p style="margin: 5px 0 0; font-size: 18px; color: #555;">for PropTree Mela 2.0!</p>
                                </td>
                            </tr>
        
                            <!-- Date & Venue Info -->
                            <tr>
                                <td style="padding: 20px; background-color: white; color: #333;">
                                    <h2 style="margin-top: 0; text-align: center; font-size: 20px; color: #000080;"><img src="https://blanchedalmond-squid-383723.hostingersite.com/event/assets/img/calendar.png" alt="calendar" width="20" height="20"> Celebrate with Us!</h2>
                                    <p style="text-align: center; font-size: 18px; margin: 5px 0;"><strong>15th August 2025</strong></p>
                                    <p style="text-align: center; font-size: 16px; margin: 0;">At <strong>{$eventTiming}</strong></p>
                                    <hr style="margin: 20px 0; border: none; border-top: 1px solid #ccc;">
                                    <p style="text-align: center; font-size: 16px;"><strong>Venue:</strong> <br> <img style="width: 120px; transform: translateY(15px); background-color: #fff;" src="https://blanchedalmond-squid-383723.hostingersite.com/event/assets/img/Radisson_Blu_logo.png" alt="Radisson Blu Logo"> Sector 18, Noida</p>
                                </td>
                            </tr>
        
                            <!-- Name and Contact -->
                            <tr>
                                <td style="padding: 20px; background-color: #138808; color: white;">
                                    <h3 style="margin: 0; font-size: 18px; text-align: center; display: flex; align-items: center; justify-content: center; gap: 8px;"><img src="https://blanchedalmond-squid-383723.hostingersite.com/event/assets/img/inviter.png" alt="inviter" width="20" height="20">&nbsp; Invited By: {$invitedBy}</h3>
                                    <a href="tel:{$inviterPhone}" style="margin: 10px 0 0; text-align: center; display: flex; align-items: center; justify-content: center; gap: 8px; color: white; text-decoration: none;"><img src="https://blanchedalmond-squid-383723.hostingersite.com/event/assets/img/call.png" alt="Phone" width="20" height="20">&nbsp; {$inviterPhone}</a>
                                </td>
                            </tr>
        
                            <!-- Call to Action -->
                            <tr>
                                <td align="center" style="padding: 20px; background-color: #138808;">
                                    <a href="https://blanchedalmond-squid-383723.hostingersite.com/event/ticket.php?ticket_id={$ticket_id}" style="background-color: #000080; color: white; padding: 12px 24px; border-radius:6px;text-decoration: none; font-weight: bold; display: inline-block;">View Your pass</a>
                                </td>
                            </tr>
        
                            <!-- Footer -->
                            <tr>
                                <td align="center" style="background-color: #2c3e50; color: #aaa; font-size: 12px; padding: 15px;">
                                    © 2025 <a href="https://moneytreerealty.com/" style="color: white; text-decoration: none;">moneytreerealty.com</a>. All rights reserved.
                                </td>
                            </tr>
                
                        </table>
                    </td>       
                </tr>       
            </table>
        </body>
        </html>
HTML;

        try {
            $clientMail = new PHPMailer(true);
            $clientMail->isSMTP();
            $clientMail->Host = 'smtp.hostinger.com';
            $clientMail->SMTPAuth = true;
            $clientMail->Username = $mailUsername;
            $clientMail->Password = $mailPassword;
            $clientMail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $clientMail->Port = 465;

            $clientMail->setFrom($mailUsername, $domainName);
            $clientMail->addAddress($recipientEmail, $recipientName);
            $clientMail->isHTML(true);
            $clientMail->Subject = "Reminder: Just {$days_remain_text} for PropTree Mela 2.0!";
            $clientMail->Body    = $emailBody;

            $clientMail->send();
            echo "✅ Sent to {$recipientEmail}<br>";

        } catch (Exception $e) {
            echo "❌ Failed to send to {$recipientEmail} - {$clientMail->ErrorInfo}<br>";
        }
    }
} else {
    echo "No recipients found.";
}

$conn->close();
?>
