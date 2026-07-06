<?php
require_once __DIR__ . '/../includes/lead-form-handler.php';

handleLeadForm([
    'project'       => 'Elan 49 Gurgaon',
    'city'          => 'Gurugram',
    'website'       => 'https://elan49gurgaon.co.in',
    'redirect'      => 'thankyou.php',
    'errorRedirect' => 'index.html',
    'requireEmail'  => false,
    'message'       => 'Thank you for your enquiry!',
]);
