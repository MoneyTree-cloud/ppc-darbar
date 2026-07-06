<?php
require_once __DIR__ . '/../includes/lead-form-handler.php';

handleLeadForm([
    'project'       => 'Great Value High Life',
    'city'          => 'Noida',
    'website'       => 'https://highlifenoida.in',
    'redirect'      => 'thankyou.php',
    'errorRedirect' => 'index.php#contact',
]);
