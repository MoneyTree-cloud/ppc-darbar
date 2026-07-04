<?php
require_once __DIR__ . '/../includes/lead-form-handler.php';

handleLeadForm([
    'project'       => 'Ace Terra',
    'city'          => 'Noida',
    'website'       => 'https://aceterrayamunaexpressway.in',
    'redirect'      => 'index.php',
    'errorRedirect' => 'index.php#contact',
]);
