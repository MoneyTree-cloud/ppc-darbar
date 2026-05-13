<?php
session_start();
session_unset(); 
session_destroy(); 

header("Location: ../../team_login.html");
exit();
?>
