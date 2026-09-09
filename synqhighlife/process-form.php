<?php
require_once __DIR__ . '/../includes/lead-form-handler.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$home   = trim((string)($_POST['home'] ?? ''));
$source = 'Synq Highlife | https://synqhighlife.com'
    . ($home !== '' ? ' · ' . $home : '');

handleLeadForm([
    'project'        => 'Synq Highlife',
    'city'           => 'Greater Noida West',
    'website'        => 'https://synqhighlife.com',
    'redirect'       => 'index.php#enquire',
    'nameMaxLength'  => 100,
    'requiredFields' => ['consent' => 'Please agree to be contacted about your enquiry.'],
    'sourceOverride' => $source,
    'message'        => 'Your enquiry has been accepted. Our team will follow up using the details you provided.',
]);
