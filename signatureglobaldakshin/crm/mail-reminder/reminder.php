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
$mailUsername = 'noreply@rohitsinghrealestate.com';
$mailPassword = 'Tanmay@2701';
$domainName = 'MoneyTree Realty Services Ltd.';

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

// --- Dynamic meeting date and venue ---
$venue = "2nd Floor, Tower B, Tapasya Corp Heights, Sector 126, Noida";

// --- Fetch attendees based on specified conditions ---
$offset = 0; // skip rows
$limit = 40; // fetch a certain number of rows

$sql = "SELECT t.id, t.unique_id, t.name, t.email, t.meeting_on, t.timing, 
       t.invited_by, t.inviter_phone, t.meeting_status
        FROM (
            SELECT * 
            FROM meeting
            ORDER BY id ASC
            LIMIT $limit OFFSET $offset   
        ) AS t
        WHERE t.meeting_status = 'pending'
          AND t.reminder = 'on'
          AND (t.is_invalid IS NULL OR t.is_invalid = 0)
          AND t.meeting_on <> CURDATE()
          AND t.meeting_on > CURDATE()
        ORDER BY t.id ASC;
        ";


$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id = $row["id"];
        $recipientEmail = trim($row["email"]);
        $recipientName = $row["name"];
        $meetingDate = $row["meeting_on"];
        $meetingTiming = $row["timing"];
        $invitedBy = $row["invited_by"];
        $inviterPhone = $row["inviter_phone"];

        // Format Date & Time for email body
        $formattedDate = date("l, F j, Y", strtotime($meetingDate));
        $formattedTiming = date("g:i A", strtotime($meetingTiming));

        // --- Validate Email Before Sending ---
        if (!isValidEmail($recipientEmail)) {
            $conn->query("UPDATE meeting SET is_invalid = 1 WHERE id = $id");
            echo "❌ Skipped invalid email: {$recipientEmail}<br>";
            continue;
        }

        // --- Email Body (Updated HTML) ---
        $emailBody = <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Meeting Reminder</title>
    <style>
        body { font-family: sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); overflow: hidden; }
        .header { background-color: #000080; color: #ffffff; padding: 20px; text-align: center; }
        .header h1 { margin: 0; font-size: 24px; }
        .content { padding: 20px; color: #333333; }
        .content h2 { color: #000080; }
        .info-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .info-table th, .info-table td { padding: 10px; border-bottom: 1px solid #dddddd; text-align: left; }
        .info-table th { background-color: #f2f2f2; color: #555555; font-weight: bold; }
        .footer { background-color: #f9f9f9; color: #888888; padding: 15px; text-align: center; font-size: 12px; border-top: 1px solid #eeeeee; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Appointment Reminder</h1>
        </div>
        <div class="content">
            <p>Dear {$recipientName},</p>
            <p>This is a friendly reminder of your upcoming meeting with {$invitedBy} ({$inviterPhone}).</p>
            
            <table class="info-table">
                <tr>
                    <th>Date:</th>
                    <td>{$formattedDate}</td>
                </tr>
                <tr>
                    <th>Time:</th>
                    <td>{$formattedTiming}</td>
                </tr>
                <tr>
                    <th>Venue:</th>
                    <td>{$venue}</td>
                </tr>
            </table>

            <p style="margin-top: 20px;">We look forward to meeting you. If you have any questions or need to reschedule, please contact us.</p>
            
            <p>Best regards,</p>
            <p><strong>Team {$domainName}</strong></p>
            <p>Contact: {$inviterPhone}</p>
        </div>
        <div class="footer">
            <p>© 2025 {$domainName}. All rights reserved.</p>
        </div>
    </div>
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
            $clientMail->Subject = "Reminder: Your Upcoming Meeting with {$invitedBy}";
            $clientMail->Body = $emailBody;

            $clientMail->send();
            echo "✅ Sent reminder email to {$recipientEmail}<br>";

        } catch (Exception $e) {
            echo "❌ Failed to send email to {$recipientEmail} - {$clientMail->ErrorInfo}<br>";
        }
    }
} else {
    echo "No recipients found with 'pending' status and 'reminder on'.";
}

$conn->close();
?>