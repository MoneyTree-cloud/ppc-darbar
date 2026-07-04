<?php
require_once __DIR__ . '/../includes/lead-form-handler.php';

handleLeadForm([
    'project'       => 'M3M Jewel Crest',
    'city'          => 'Noida',
    'website'       => 'https://m3mjewelcrest.info',
    'redirect'      => 'thankyou.php',
    'errorRedirect' => 'index.html',
    'requireEmail'  => false,
    'message'       => 'Thank you for your enquiry!',
]);
