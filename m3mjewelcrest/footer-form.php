<?php
require_once __DIR__ . '/../includes/lead-form-handler.php';

$_POST['name']  = $_POST['name']  ?? $_POST['name_contact']  ?? '';
$_POST['email'] = $_POST['email'] ?? $_POST['email_contact'] ?? '';
$_POST['phone'] = $_POST['phone'] ?? $_POST['phone_contact'] ?? '';

handleLeadForm([
    'project'       => 'M3M Jewel Crest',
    'city'          => 'Noida',
    'website'       => 'https://m3mjewelcrest.info',
    'redirect'      => 'thankyou.php',
    'errorRedirect' => 'index.html',
    'requireEmail'  => false,
    'message'       => 'Thank you for your enquiry!',
]);
