<?php
require_once __DIR__ . '/../includes/lead-form-handler.php';

handleLeadForm([
    'project'       => 'Central Park Selene',
    'city'          => 'Gurugram',
    'website'       => 'https://centralparkselene.com',
    'redirect'      => 'index.php',
    'errorRedirect' => 'index.php#contact-us',
    'phonePattern'  => '/^[6-9][0-9]{9}$/',
    'phoneError'    => 'Please enter a valid 10-digit Indian mobile number',
]);
