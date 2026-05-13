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

// --- DB Connection ---
$conn = new mysqli($dbHost, $dbUser, $dbPass, $dbName);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// --- Email Validation Function ---
function isValidEmail($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return false;
    $domain = substr(strrchr($email, "@"), 1);
    return checkdnsrr($domain, "MX");
}

// --- [MODIFIED] Countdown for Navratri Event ---
date_default_timezone_set('Asia/Kolkata');
$today = new DateTime();
$eventDate = new DateTime('2025-09-28'); // Updated event date
$diffDays = (int)$today->diff($eventDate)->format('%r%a');

$days_remain_text = $diffDays > 1 ? "$diffDays Days to go" :
                  ($diffDays == 1 ? "Tomorrow!" :
                  ($diffDays == 0 ? "Today is the day!" : "Event Over"));

// --- Batch Sending Settings ---
// Use OFFSET to skip records and LIMIT to define the batch size.
$offset = 360; // Example: skip the first 360 records. Adjust as needed.
$limit  = 1;  // Example: send the next 30 emails in this batch.

$sql = "SELECT t.id, t.ticket_id, t.name, t.email, t.timing, t.invited_by, t.inviter_phone
        FROM meeting t
        INNER JOIN (
            SELECT MIN(id) as min_id
            FROM meeting
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
        $meetingTiming  = date("g:i A", strtotime($row["timing"])); // Format time
        $invitedBy      = $row["invited_by"];
        $inviterPhone   = $row["inviter_phone"];
        $ticket_id      = $row["ticket_id"];

        // Validate Email Before Sending
        if (!isValidEmail($recipientEmail)) {
            $conn->query("UPDATE meeting SET is_invalid = 1 WHERE id = $id");
            echo "❌ Skipped invalid email: {$recipientEmail}<br>";
            continue;
        }

        // --- [MODIFIED] Navratri Themed Email Body ---
        $emailBody = <<<HTML
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">
            <title>PROPTREE Navratri Celebration - Reminder!</title>
            <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Cinzel:wght@700&display=swap" rel="stylesheet">
        </head>
        <body style="margin: 0; padding: 0; background-color: #fdf8e1; font-family: 'Poppins', Arial, sans-serif;">
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="center" style="padding: 20px;">
                        <table width="100%" style="max-width: 600px; background-color: #ffffff; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.1); overflow: hidden; border: 1px solid #D4AF37;">
                            
                            <tr>
                                <td align="center" style="background-color: #B91C1C; padding: 25px;">
                                    <h2 style="color: #FFD700; margin: 0; font-size: 24px; font-family: 'Cinzel', serif;">The Countdown Has Begun!</h2>
                                    <p style="color: #ffffff; margin: 5px 0 0; font-size: 16px;">PROPTREE Navratri Celebration</p>
                                </td>
                            </tr>

                            <tr>
                                <td align="center" style="padding: 30px 20px;">
                                    <h1 style="margin: 0; font-size: 48px; color: #8B0000; font-weight: 700;">{$days_remain_text}</h1>
                                    <p style="margin: 5px 0 0; font-size: 18px; color: #555;">for our grand celebration!</p>
                                </td>
                            </tr>

                            <tr>
                                <td style="padding: 0 25px 25px;">
                                    <table width="100%" border="0" cellspacing="0" cellpadding="0" style="text-align:center;">
                                        <tr>
                                            <td style="border-top: 1px solid #eee; padding-top: 25px;">
                                                <h3 style="margin: 0; font-size: 20px; color: #8B0000;">Event Details</h3>
                                                <p style="font-size: 18px; margin: 5px 0;"><strong>28th September 2025</strong></p>
                                                <p style="font-size: 16px; margin: 0;">Your appointment is at <strong>{$meetingTiming}</strong></p>
                                                <p style="font-size: 16px; margin: 20px 0;"><strong>Venue:</strong> Radisson Blu, Sector 18, Noida</p>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td style="background-color: #FFF8E1; padding: 20px 25px; text-align: center;">
                                    <h4 style="margin: 0 0 10px; font-size: 16px; color: #8B0000;">Your Host</h4>
                                    <p style="margin: 5px 0; font-size: 18px; color: #333;"><strong>{$invitedBy}</strong></p>
                                    <a href="tel:{$inviterPhone}" style="color: #B91C1C; text-decoration: none; font-weight: bold;">{$inviterPhone}</a>
                                </td>
                            </tr>

                            <tr>
                                <td align="center" style="padding: 30px;">
                                    <a href="https://rohitsinghrealestate.in/meeting/ticket.php?ticket_id={$ticket_id}" style="background-color: #B91C1C; color: white; padding: 14px 28px; border-radius: 8px; text-decoration: none; font-weight: bold; display: inline-block;">View Your Event Pass</a>
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

            $clientMail->setFrom($mailUsername, 'PROPTREE Navratri Celebration');
            $clientMail->addAddress($recipientEmail, $recipientName);
            $clientMail->isHTML(true);
            $clientMail->Subject = "Reminder: {$days_remain_text} for the PROPTREE Navratri Celebration!";
            $clientMail->Body    = $emailBody;

            $clientMail->send();
            echo "✅ Sent reminder to {$recipientEmail}<br>";

        } catch (Exception $e) {
            echo "❌ Failed to send to {$recipientEmail} - {$clientMail->ErrorInfo}<br>";
        }
    }
} else {
    echo "No more recipients found in the specified range.";
}

$conn->close();
?>