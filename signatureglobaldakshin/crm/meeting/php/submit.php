<?php
/**
 * submit.php
 *
 * This script handles the meeting registration form submission.
 * It validates the inviter's code, fetches inviter details,
 * saves the meeting data, sends confirmation emails,
 * and redirects the user upon success.
 */

// --- PHPMailer Integration ---
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

// 1. Include the database configuration file
include '../../php/config.php';

// Initialize a variable for potential error messages
$error_message = '';

// 2. Check if the form was submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 3. Sanitize and retrieve form data
    $client_name = trim($_POST['client_name']);
    $contact_no = trim($_POST['contact_no']);
    $email = trim($_POST['email']);
    $date = trim($_POST['date']);
    $timing = trim($_POST['timing']);
    $employ_id = trim($_POST['code_id']);

    // --- Data Validation (Basic) ---
    if (empty($client_name) || empty($contact_no) || empty($email) || empty($date) || empty($timing) || empty($employ_id)) {
        die("Error: All fields are required.");
    }

    // --- OPTIMIZATION 1: Validate Inviter Code First ---
    // This is a quick check. If the code is invalid, we can stop immediately
    // without performing the more complex phone number check.
    $stmt_inviter = $conn->prepare("SELECT name, contact, email FROM team_login WHERE employ_id = ?");
    if ($stmt_inviter === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt_inviter->bind_param("s", $employ_id);
    $stmt_inviter->execute();
    $result_inviter = $stmt_inviter->get_result();

    if ($result_inviter->num_rows > 0) {
        $inviter_data = $result_inviter->fetch_assoc();
        $invited_by = $inviter_data['name'];
        $inviter_phone = $inviter_data['contact'];
        $inviter_email = $inviter_data['email'];
    } else {
        // Exit immediately if the invite code is invalid.
        die("Error: Invalid Invite Code. Please check the code provided by your inviter.");
    }
    $stmt_inviter->close();

    // --- OPTIMIZATION 2: Check for Existing Phone Number After Inviter Check ---
    // Now that we know the inviter is valid, we check the phone number.
    $stmt_check = $conn->prepare("SELECT unique_id FROM meeting WHERE phone = ?");
    if ($stmt_check === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt_check->bind_param("s", $contact_no);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // If the phone number exists, we can now display the inviter's details in the error message.
        $stmt_check->close();
        $conn->close();
        
        echo "<!DOCTYPE html>
              <html lang='en'>
              <head>
                  <meta charset='UTF-8'>
                  <title>Already Registered</title>
                  <style>
                      body { font-family: Arial, sans-serif; background-color: #f4f4f4; text-align: center; padding-top: 50px; }
                      .alert-box { background-color: #fff; border: 1px solid #ddd; padding: 20px; max-width: 400px; margin: auto; box-shadow: 0 2px 4px rgba(0,0,0,0.1); border-radius: 8px; }
                      a { padding: 8px 15px; background: #00584f; color: #fff; border-radius: 5px; text-decoration: none; display: inline-block; margin-top: 15px;}
                  </style>
              </head>
              <body>
                  <div class='alert-box'>
                      <p>A meeting has already been scheduled using this contact number.</p>
                      <p>Please check your email for confirmation or contact Coordinator ($invited_by - <a href='tel:$inviter_phone' style='all: unset; cursor: pointer;color: #00584f;' >$inviter_phone</a>) for assistance.</p>
                      <a href='../index.html'>Go Back</a>
                  </div>
              </body>
              </html>";
        exit(); // Stop the script
    }
    $stmt_check->close();

    
    // 5. Generate a unique ID and get the current timestamp
    $unique_id = mt_rand(10000000, 99999999);
    date_default_timezone_set('Asia/Kolkata');
    $created_at = date('Y-m-d H:i:s');
    $meeting_status = 'pending';
    $reminder_status = 'on';
    
    // 6. Prepare an INSERT statement for the 'meeting' table
    $stmt_meeting = $conn->prepare(
        "INSERT INTO meeting (name, unique_id, email, phone, meeting_on, timing, employ_id, invited_by, inviter_phone, created_at, meeting_status, reminder) 
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)"
    );
    if ($stmt_meeting === false) {
        die("Error preparing statement: " . $conn->error);
    }
    
    // ✅ Fixed variable name ($reminder_status instead of $reminder_Status)
    $stmt_meeting->bind_param(
        "ssssssssssss", 
        $client_name, 
        $unique_id, 
        $email, 
        $contact_no, 
        $date, 
        $timing, 
        $employ_id, 
        $invited_by, 
        $inviter_phone, 
        $created_at, 
        $meeting_status, 
        $reminder_status
    );

   if ($stmt_meeting->execute()) {

    // Format date & time once
    $formatted_date = date("l, F j, Y", strtotime($date));
    $formatted_time = date("g:i A", strtotime($timing));

    // AiSensy API URL & Key
    $url = "https://backend.aisensy.com/campaign/t1/api/v2";
    $apiKey = "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpZCI6IjY4NjY4NjE3YTBlNTE4MGMwOGRiZGYyMyIsIm5hbWUiOiJNb25leVRyZWUgUmVhbHR5IFNlcnZpY2VzIFByaXZhdGUgTGltaXRlZCIsImFwcE5hbWUiOiJBaVNlbnN5IiwiY2xpZW50SWQiOiI2ODY2ODYxN2EwZTUxODBjMDhkYmRmMWQiLCJhY3RpdmVQbGFuIjoiRlJFRV9GT1JFVkVSIiwiaWF0IjoxNzUxNTQ5NDYzfQ.tJWgoC1qLDRKPqvqPk_kt5BR3eXPrtjUKxv3HRYL87s"; // replace with your AiSensy API key

    // ✅ Function to send WhatsApp
    function sendWhatsApp($url, $apiKey, $campaignName, $destination, $params) {
        $payload = [
            "apiKey" => $apiKey,
            "campaignName" => $campaignName,
            "destination" => "91" . $destination, // India country code
            "userName" => "MoneyTree Realty",
            "templateParams" => $params
        ];

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type:application/json']);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    // 1️⃣ Send WhatsApp to CLIENT
    $clientParams = [
        $client_name,     // {{1}}
        $formatted_date,  // {{2}}
        $formatted_time,  // {{3}}
        $invited_by,      // {{4}}
        $inviter_phone    // {{5}}
    ];
    $clientResponse = sendWhatsApp(
        $url,
        $apiKey,
        "meeting confirmation | 20-Aug-25", // your live template name
        $contact_no,
        $clientParams
    );

    // 2️⃣ Send WhatsApp to ADMIN/ASSOCIATE
    $adminParams = [
        $client_name,     // {{1}}
        $contact_no,      // {{2}}
        $formatted_date,  // {{3}}
        $formatted_time   // {{4}}
    ];
    $adminResponse = sendWhatsApp(
        $url,
        $apiKey,
        "associate meeting confirmation | 20-Aug-25", // your live template name
        $inviter_phone,
        $adminParams
    );

    
    // }

    // // 7. Execute the statement and handle the result
    // if ($stmt_meeting->execute()) {
        
        // --- NOTE: Email sending is the most time-consuming part of this script ---
        // The delay is caused by connecting to the external SMTP server.
        
        // --- SEND CONFIRMATION EMAIL TO CLIENT ---
        try {
            $clientMail = new PHPMailer(true);
            //Server settings
            $clientMail->isSMTP();
            $clientMail->Host       = 'smtp.hostinger.com';
            $clientMail->SMTPAuth   = true;
            $clientMail->Username   = 'noreply@rohitsinghrealestate.com';
            $clientMail->Password   = 'Tanmay@2701';
            $clientMail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $clientMail->Port       = 465;

            //Recipients
            $clientMail->setFrom('noreply@rohitsinghrealestate.com', 'MoneyTree Realty LTD. - Meeting Booked');
            $clientMail->addAddress($email, $client_name);

            // --- BUG FIX: Define formatted variables BEFORE using them ---
            $formatted_date = date("l, F j, Y", strtotime($date));
            $formatted_time = date("g:i A", strtotime($timing));
            
            // Email Content
            $clientMail->isHTML(true);
            $clientMail->Subject = 'Your Meeting on ' . htmlspecialchars($formatted_date) . ' is Confirmed!';
            
            $clientMail->Body = "
            <html>
            <body style='font-family: Arial, sans-serif; margin: 0; padding: 0; background-color: #f4f4f4;'>
                <div style='max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1);'>
                    <div style='background: rgba(0, 88, 79, 1); padding: 30px; text-align: center;'>
                        <h1 style='margin: 0; color: #fcf6ba; font-size: 28px;'>Meeting Confirmed!</h1>
                    </div>
                    <div style='padding: 30px 40px; color: #333;'>
                        <p style='font-size: 16px; line-height: 1.6;'>Dear " . htmlspecialchars($client_name) . ",</p>
                        <p style='font-size: 16px; line-height: 1.6;'>Thank you for scheduling a meeting with us. We are pleased to confirm your appointment.</p>
                        
                        <div style='margin: 30px 0; padding: 20px; background: #f9f9f9; border-left: 5px solid; border-image: linear-gradient(45deg, #b38728, #fcf6ba, #bf953f) 1; border-image-slice: 1;'>
                            <h3 style='margin-top: 0; color: rgba(0, 88, 79, 1);'>Your Meeting Details:</h3>
                            <p style='font-size: 16px; margin: 10px 0;'><strong>Date:</strong> " . htmlspecialchars($formatted_date) . "</p>
                            <p style='font-size: 16px; margin: 10px 0;'><strong>Time:</strong> " . htmlspecialchars($formatted_time) . "</p>
                            <p style='font-size: 16px; margin: 10px 0;'><strong>Venue:</strong> Floor No-2, Tower B, Tapasya Corp Heights, Sector 126, Noida, Uttar Pradesh - 201303</p>
                        </div>

                        <p style='font-size: 16px; line-height: 1.6;'>Your meeting has been arranged with:</p>
                        <div style='margin-top: 10px;'>
                            <p style='font-size: 16px; margin: 5px 0;'><strong>" . htmlspecialchars($invited_by) . "</strong></p>
                            <p style='font-size: 16px; margin: 5px 0;'>Contact: " . htmlspecialchars($inviter_phone) . "</p>
                        </div>
                        
                        <p style='margin-top: 30px; font-size: 16px; line-height: 1.6;'>We look forward to speaking with you.</p>
                        <p style='font-size: 16px; line-height: 1.6;'>Best regards,<br><strong>MoneyTree Realty Team</strong></p>
                    </div>
                    <div style='background: linear-gradient(45deg, #b38728, #fcf6ba, #bf953f, #fbf5b7, #aa771c); padding: 15px; text-align: center;'>
                        <p style='margin: 0; font-size: 12px; color: #333;'>MONEYTREE REALTY SERVICES LTD.</p>
                    </div>
                </div>
            </body>
            </html>";

            $clientMail->send();
        } catch (Exception $e) {
            error_log("Client email could not be sent. Mailer Error: {$clientMail->ErrorInfo}");
        }

        // --- SEND NOTIFICATION EMAIL TO ADMIN ---
        try {
            
        
    
            
            // Send email to admin 
            $adminMail = new PHPMailer(true);
            //Server settings
            $adminMail->isSMTP();
            $adminMail->Host       = 'smtp.hostinger.com';
            $adminMail->SMTPAuth   = true;
            $adminMail->Username   = 'noreply@rohitsinghrealestate.com';
            $adminMail->Password   = 'Tanmay@2701';
            $adminMail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            $adminMail->Port       = 465;

            //Recipients
            $adminMail->setFrom('noreply@rohitsinghrealestate.com', 'Received Meeting Confirmation');
            $adminMail->addAddress('firoz.fkofficial@gmail.com');
            $adminMail->addAddress('akash.developerbrothers@gmail.com');
            $adminMail->addAddress($inviter_email);
            // Add other admin emails here if needed

            // Email Content
            $adminMail->isHTML(true);
            $adminMail->Subject = "New Meeting Scheduled: " . htmlspecialchars($client_name);
            $adminMail->Body = "
                <html><body style='font-family: Arial, sans-serif; line-height: 1.6;'>
                    <h2>New Meeting Confirmation</h2>
                    <p>A new client has scheduled a meeting.</p>
                    <table style='width: 100%; border-collapse: collapse;'>
                        <tr style='background-color: #f2f2f2;'><td style='padding: 8px; border: 1px solid #ddd;'>Client Name</td><td style='padding: 8px; border: 1px solid #ddd;'>" . htmlspecialchars($client_name) . "</td></tr>
                        <tr><td style='padding: 8px; border: 1px solid #ddd;'>Contact</td><td style='padding: 8px; border: 1px solid #ddd;'><a href='tel:" . htmlspecialchars($contact_no) . "'>" . htmlspecialchars($contact_no) . "</a></td></tr>
                        <tr style='background-color: #f2f2f2;'><td style='padding: 8px; border: 1px solid #ddd;'>Email</td><td style='padding: 8px; border: 1px solid #ddd;'>" . htmlspecialchars($email) . "</td></tr>
                        <tr><td style='padding: 8px; border: 1px solid #ddd;'>Meeting Date</td><td style='padding: 8px; border: 1px solid #ddd;'>" . htmlspecialchars($date) . "</td></tr>
                        <tr style='background-color: #f2f2f2;'><td style='padding: 8px; border: 1px solid #ddd;'>Meeting Time</td><td style='padding: 8px; border: 1px solid #ddd;'>" . htmlspecialchars($timing) . "</td></tr>
                        <tr><td style='padding: 8px; border: 1px solid #ddd;'>Invited By</td><td style='padding: 8px; border: 1px solid #ddd;'>" . htmlspecialchars($invited_by) . " (" . htmlspecialchars($employ_id) . ")</td></tr>
                    </table>
                </body></html>";
            $adminMail->send();
        } catch (Exception $e) {
            error_log("Admin notification could not be sent. Mailer Error: {$adminMail->ErrorInfo}");
        }

        // On successful insertion, redirect to the thank you page.
        header("Location: ../thank-you.html");
        exit();
    } else {
        $error_message = "Error: Could not process your request. Please try again later. " . $stmt_meeting->error;
    }
    $stmt_meeting->close();

} else {
    $error_message = "Invalid request method.";
}

// Close the database connection
$conn->close();

// Display error message if any occurred
if (!empty($error_message)) {
    echo "<!DOCTYPE html><html><head><title>Error</title></head><body><h1>Request Failed</h1><p>" . htmlspecialchars($error_message) . "</p></body></html>";
}
?>
