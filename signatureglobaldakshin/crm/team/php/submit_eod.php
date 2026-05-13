<?php
session_start();
// Enable error reporting and logging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ini_set("log_errors", 1);
ini_set("error_log", "php-error.log");


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// PHPMailer files
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

// Database connection
include 'config.php';

// Admin Email
// $adminEmail = "firoz.fkofficial@gmail.com";
$mailUsername = "noreply@rohitsinghrealestate.in";
$mailPassword = "Tanmay@2701";


// Get form values
$employ_id = $_POST['employ_id'] ?? '';
$calls = $_POST['calls'] ?? '';
$prospects = $_POST['prospects'] ?? '';
$meetings = $_POST['meetings'] ?? '';
$client_names = $_POST['client_name'] ?? [];
$mobiles = $_POST['mobile'] ?? [];
$projects = $_POST['project'] ?? [];
$units = $_POST['unit'] ?? [];
$sizes = $_POST['size'] ?? [];
$costs = $_POST['total_cost'] ?? [];
$inventories = $_POST['inventory_status'] ?? [];

date_default_timezone_set("Asia/Kolkata");
$checkout = date("Y-m-d h:i:s A"); // → 2025-06-25 02:45:30 PM


// Fetch employee name
$employ_id = $conn->real_escape_string($employ_id);
$res = $conn->query("SELECT name FROM team_login WHERE employ_id = '$employ_id' LIMIT 1");

if ($res && $res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $employee_full = $row['name'] . " ($employ_id)";
    $employee_name =  $row['name'];
} else {
    // $employee_full = "Unknown ($employ_id)";
    header("Location: ../eod.php?type=error&message=Employ Id: $employ_id does not exist in the team, Please fill with Correct Employ Id!!");
    exit;
}



// --- [NEW] TIME VALIDATION ---
// date_default_timezone_set("Asia/Kolkata");
$currentTime = new DateTime();
$startTime = new DateTime('today 9:00:00'); // 9:00 AM
$endTime = new DateTime('today 22:00:00');   // 10:00 PM

// Check if the current time is outside the allowed window
if ($currentTime < $startTime) {
    header("Location: ../eod.php?type=error&message=Sorry  $employee_name, EOD reports can only be submitted after 9:00 AM.");
    exit;
}

if ($currentTime > $endTime) {
    header("Location: ../eod.php?type=error&message=Sorry  $employee_name, you missed your EOD report. It can't be filled after 10:00 PM. Please contact the admin.");
    exit;
}
// --- END OF TIME VALIDATION ---



// Check if this user has already submitted today
$today = date("Y-m-d"); // only date part
$checkQuery = "SELECT id FROM team_eod WHERE employ_id = '$employee_full' AND DATE(check_out) = '$today' LIMIT 1";
$checkResult = $conn->query($checkQuery);

if ($checkResult && $checkResult->num_rows > 0) {
    header("Location: ../eod.php?type=error&message=You have already submitted today's EOD. Only one submission allowed per day.");
    exit;
}

// Loop and insert each expected sale
for ($i = 0; $i < count($client_names); $i++) {
    // Skip empty client entries
    if (!isset($client_names[$i]) || trim($client_names[$i]) === '') continue;
    
    $client = $conn->real_escape_string($client_names[$i]);
    $mobile = $conn->real_escape_string($mobiles[$i] ?? '');
    $project = $conn->real_escape_string($projects[$i] ?? '');
    $unit = $conn->real_escape_string($units[$i] ?? '');
    $size = $conn->real_escape_string($sizes[$i] ?? '');
    $cost = $conn->real_escape_string($costs[$i] ?? '');
    $inventory = $conn->real_escape_string($inventories[$i] ?? 'No'); // Default to 'No' if not set
    
    $sale_no = $i + 1;

    $sql = "INSERT INTO team_eod (employ_id, calls, prospects, meetings, client_name, mobile, project, unit, size, total_cost, inventory_status, check_out, sale_no)
            VALUES ('$employee_full', '$calls', '$prospects', '$meetings', '$client', '$mobile', '$project', '$unit', '$size', '$cost', '$inventory', '$checkout', '$sale_no')";
    $conn->query($sql);
}
$conn->close();

// Prepare email message with enhanced styling
$emailStyle = "
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        h2 {
            color: #2c3e50;
            border-bottom: 2px solid #3498db;
            padding-bottom: 10px;
        }
        .summary-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .summary-table th, .summary-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .summary-table th {
            background-color: #f2f2f2;
        }
        .client-table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            background-color: #f9f9f9;
        }
        .client-table th, .client-table td {
            padding: 10px;
            border: 1px solid #ddd;
        }
        .client-table th {
            background-color: #e6e6e6;
        }
        .highlight {
            background-color: #fffde7;
            padding: 2px 5px;
            border-radius: 3px;
        }
    </style>
";

$message = "
<html>
<head>
    <title>EOD Report from $employee_full</title>
    $emailStyle
</head>
<body>
    <div class='container'>
        <h2>Team EOD Report</h2>
        
        <table class='summary-table'>
            <tr>
                <th>Employee Name</th>
                <td>$employee_full</td>
            </tr>
            <tr>
                <th>Total Calls</th>
                <td>$calls</td>
            </tr>
            <tr>
                <th>Prospects</th>
                <td>$prospects</td>
            </tr>
            <tr>
                <th>Meetings</th>
                <td>$meetings</td>
            </tr>
            <tr>
                <th>Check Out Time</th>
                <td>$checkout</td>
            </tr>
        </table>

        <h2>Expected Sales Details</h2>";

for ($i = 0; $i < count($client_names); $i++) {
    // Skip empty client entries
    if (empty($client_names[$i])) continue;
    
    $inventoryStatus = $inventories[$i] ?? 'No';
    $message .= "
        <table class='client-table'>
            <tr>
                <th colspan='2'>Client #" . ($i + 1) . "</th>
            </tr>
            <tr>
                <th>Client Name</th>
                <td>" . htmlspecialchars($client_names[$i]) . "</td>
            </tr>
            <tr>
                <th>Mobile</th>
                <td>" . htmlspecialchars($mobiles[$i] ?? '') . "</td>
            </tr>
            <tr>
                <th>Project</th>
                <td>" . htmlspecialchars($projects[$i] ?? '') . "</td>
            </tr>
            <tr>
                <th>Unit</th>
                <td>" . htmlspecialchars($units[$i] ?? '') . "</td>
            </tr>
            <tr>
                <th>Size</th>
                <td>" . htmlspecialchars($sizes[$i] ?? '') . "</td>
            </tr>
            <tr>
                <th>Total Cost</th>
                <td>" . htmlspecialchars($costs[$i] ?? '') . "</td>
            </tr>
            <tr>
                <th>Inventory Hold</th>
                <td><span class='highlight'>" . htmlspecialchars($inventoryStatus) . "</span></td>
            </tr>
        </table>";
}

$message .= "
    </div>
</body>
</html>";

$mail = new PHPMailer(true);
try {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host = 'smtp.hostinger.com';
    $mail->SMTPAuth = true;
    $mail->Username = $mailUsername;
    $mail->Password = $mailPassword; 
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;

    $mail->setFrom($mailUsername, "EOD Report $employee_full");

    $mail->addAddress('work.official0904@gmail.com');
    $mail->addAddress('akash.esports4g@gmail.com');
    $mail->addAddress('singhrohit16988@gmail.com');

    $mail->isHTML(true);
    $mail->Subject = "EOD Report of $employee_full";
    $mail->Body = $message;

    $mail->send();
    // Set a session flag to indicate valid submission
    $_SESSION['valid_eod_submission'] = true;
    $_SESSION['employee_full'] = $employee_full;
    $_SESSION['previous_page'] = 'eod.php';
    header("Location: ../thank-you-eod.php?type=success&message=Data Submitted Successfully!!");
    exit;
} catch (Exception $e) {
    echo "Mailer Error: " . $mail->ErrorInfo;
    header("Location: ../eod.php?type=error&message=Data submitted but email notification failed.");
}

?>
