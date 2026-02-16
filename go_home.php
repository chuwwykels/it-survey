<?php
session_start();
	
require_once 'connection/dbconfig.php';

unset($_SESSION['fullname']);
unset($_SESSION['primary_id']);
unset($_SESSION['user_type']);
unset($_SESSION['assist_type']);

header('location: index.php');
exit;
?>
