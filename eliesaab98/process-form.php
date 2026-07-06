<?php
require_once __DIR__ . '/../includes/lead-form-handler.php';

$_POST['phone'] = $_POST['phone'] ?? $_POST['mobile'] ?? '';

handleLeadForm([
    'project'       => 'Smartworld Elie Saab Residences',
    'city'          => 'Noida',
    'website'       => 'https://eliesaab98.in',
    'redirect'      => 'thankyou.php',
    'errorRedirect' => 'index.php',
]);
