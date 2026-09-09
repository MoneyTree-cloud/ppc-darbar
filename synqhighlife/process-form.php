<?php
require_once __DIR__ . '/../includes/lead-form-handler.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

handleLeadForm([
    'project'       => 'Synq Highlife',
    'city'          => 'Greater Noida West',
    'website'       => 'https://synqhighlife.com',
    'redirect'      => 'index.php#enquire',
    'nameMaxLength' => 100,
    'phonePattern'  => '/^[6-9][0-9]{9}$/',
    'phoneError'    => 'Please enter a valid 10-digit mobile number.',
    'message'       => 'Your enquiry has been accepted. Our team will follow up using the details you provided.',
]);
