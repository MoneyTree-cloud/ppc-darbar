<?php
require_once __DIR__ . '/../includes/lead-form-handler.php';

handleLeadForm([
    'project'      => 'AI Homes by Highlife',
    'city'         => 'Greater Noida West',
    'website'      => 'https://synqiqhomes.com',
    'redirect'     => 'index.php#contact',
    'phonePattern' => '/^[6-9][0-9]{9}$/',
    'phoneError'   => 'Please enter a valid 10-digit mobile number.',
    'message'      => 'Thank you! Our AI Homes advisor will call you within 24 hours.',
]);
