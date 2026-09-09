<?php
require_once __DIR__ . '/../includes/lead-form-handler.php';

handleLeadForm([
    'project'      => 'SYNQ IQ Homes by Highlife',
    'city'         => 'Greater Noida West',
    'website'      => 'https://iqhomeshighlife.com',
    'redirect'     => 'index.php#enquire',
    'phonePattern' => '/^[6-9][0-9]{9}$/',
    'phoneError'   => 'Please enter a valid 10-digit mobile number.',
    'message'      => 'Thank you! Our SYNQ advisor will call you within 24 hours.',
]);
