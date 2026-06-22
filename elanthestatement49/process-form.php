<?php
require_once __DIR__ . '/../includes/lead-form-handler.php';

handleLeadForm([
    'project'      => 'Elan The Statement',
    'city'         => 'Gurugram',
    'website'      => 'https://elanthestatement49.in',
    'redirect'     => 'index.html',
    'phonePattern' => '/^[6-9][0-9]{9}$/',
    'phoneError'   => 'Please enter a valid 10-digit Indian mobile number',
]);
