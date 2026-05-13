<?php
//----------- CUSTOMIZE YOUR REMINDER HERE -----------
$recipientNumber = '7007218007'; // The mobile number to send the reminder to
$eventName       = 'Proptree Mela 2.0';
$eventDateTime   = 'August 1, 2025 at 5:00 PM';
//----------------------------------------------------

// 1. Construct the reminder message
$messageText = "Hi there! This is a reminder for your upcoming event: '" . $eventName . "' on " . $eventDateTime . ".";

// 2. URL-encode the message to handle spaces and special characters
$encodedMessage = urlencode($messageText);

// 3. Construct the full API URL with all the parameters
$url = 'https://cpaas.messagecentral.com/verification/v3/send?countryCode=91&customerId=C-269B8C722E174C1&senderId=UTOMOB&type=SMS&flowType=SMS&mobileNumber=' . $recipientNumber . '&message=' . $encodedMessage;

// 4. Set up the authorization token
// IMPORTANT: This token might expire. You may need to generate a new one from your Message Central dashboard.
$authToken = 'eyJhbGciOiJIUzUxMiJ9.eyJzdWIiOiJDLTI2OUI4QzcyMkUxNzRDMSIsImlhdCI6MTc0ODg2MTUwNywiZXhwIjoxOTA2NTQxNTA3fQ.lgBFMiDU4RUaE-GpCe0N3AGRzIvAbNDGMSpWxE2dria_Y_iL2HRuHMd9OlDAgOUNzqVXgbJUZykkVtbG3Tt4vQ';

$headers = [
    'authToken: ' . $authToken
];

// 5. Initialize cURL session
$ch = curl_init();

// 6. Set cURL options
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true); // Set the request method to POST
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers); // Set the custom headers
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string instead of printing it
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects, equivalent to curl's --location flag

// 7. Execute the cURL session
$response = curl_exec($ch);

// 8. Check for cURL errors
if (curl_errno($ch)) {
    echo 'cURL Error: ' . curl_error($ch);
} else {
    // If successful, print the response from the server
    echo "Request sent! Server response: \n";
    echo $response;
}

// 9. Close the cURL session
curl_close($ch);

?>
