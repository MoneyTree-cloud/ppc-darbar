<?php
$plainPassword = "vivek@123";

$hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

echo $hashedPassword;


?>