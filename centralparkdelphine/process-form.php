<?php
require_once __DIR__ . '/../includes/lead-form-handler.php';

// Accept legacy fallback field names in case any older page still uses them.
$_POST['name']  = $_POST['name']  ?? $_POST['name_contact']  ?? '';
$_POST['email'] = $_POST['email'] ?? $_POST['email_contact'] ?? '';
$_POST['phone'] = $_POST['phone'] ?? $_POST['phone_contact'] ?? '';

handleLeadForm([
    'project'       => 'Central Park Delphine',
    'city'          => 'Gurugram',
    'website'       => 'https://centralparkdelphine.info',
    'redirect'      => 'index.php',
    'errorRedirect' => 'index.php#contact-us',
    'phonePattern'  => '/^[6-9][0-9]{9}$/',
    'phoneError'    => 'Please enter a valid 10-digit Indian mobile number',
]);
