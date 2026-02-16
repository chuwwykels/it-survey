<?php
	session_start();


	require_once '../connection/dbconfig.php';

  if(!isset($_SESSION['email']) || $_SESSION['email'] === null){
    header('location: index.php');
}

    date_default_timezone_set("Asia/Manila"); 
                   
    $time = date("H:i:s");
    $date = date("Y-m-d");
    $act = "Logged out the system";
    
    
    
    $DATEE = $date;
    $TIMEE = $time;
    $email = $_SESSION['email'];
    $access_level = $_SESSION['access_level'];
    $action = $act;
    
    /*          name Of table                  Rows                               target names */
    $query = "INSERT INTO auditlogs (date,time,email,access_level,action) VALUES (:date, :time, :email, :access_level, :action)";
    $query_run = $conn->prepare($query);
    
    
    /* Getting The Values */
    
    $data = [
        ':date' => $DATEE,
        ':time' => $TIMEE,
        ':email' => $email,
        ':access_level' => $access_level,
        ':action' => $act,
    
    
    
    ];
    
      /* Executing the command */
    $query_execute = $query_run->execute($data);

$_SESSION['email']="";
session_destroy();



header('location: index.php');
	
?>