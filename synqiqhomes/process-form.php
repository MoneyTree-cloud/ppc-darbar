<?php
require_once __DIR__ . '/../includes/lead-form-handler.php';

handleLeadForm([
    'project'  => 'AI Homes by Highlife',
    'city'     => 'Greater Noida West',
    'website'  => 'https://synqiqhomes.com',
    'redirect' => 'index.php#contact',
    'message'  => 'Thank you! Our AI Homes advisor will call you within 24 hours.',
]);
