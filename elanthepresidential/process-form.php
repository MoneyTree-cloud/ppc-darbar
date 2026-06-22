<?php
require_once __DIR__ . '/../includes/lead-form-handler.php';

handleLeadForm([
    'project'        => 'Elan The Presidential',
    'city'           => 'Gurugram',
    'website'        => 'https://elanthepresidential.com',
    'redirect'       => 'index.php',
    'errorRedirect'  => 'index.php#contact',
    'phonePattern'   => '/^[6-9][0-9]{9}$/',
    'phoneError'     => 'Please enter a valid 10-digit Indian mobile number',
    'requiredFields' => [
        'interested_in' => 'Please select what you are interested in',
    ],
]);
