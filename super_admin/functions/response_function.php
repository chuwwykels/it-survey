<?php
session_start();
include('../../connection/dbconfig.php');


// Delete Response Account


if(isset($_POST['response_delete']))
{

  $response_id = $_POST['responsedelete_id'];

  $select = $conn->prepare("SELECT * FROM `survey_result` WHERE id = ?");
  $select->execute([$response_id]);

  $row = $select->fetch(PDO::FETCH_ASSOC);
  
  if($select->rowCount() > 0){

    $fullname = $row['fullname'];
    
  }

//Audit Trail
        
date_default_timezone_set("Asia/Manila"); 
                   
$time = date("H:i:s");
$date = date("Y-m-d");
$act = "Deleted a Response from:  ".$fullname;

$DATEE = $date;
$TIMEE = $time;
$email = $_SESSION['email'];
$action = $act;
$access_level = $_SESSION['access_level'];

//Executing Audit Trail Command
$query1 = "INSERT INTO auditlogs (date,time,email,access_level,action) VALUES (:date, :time, :email, :access_level, :action)";
$query_run = $conn->prepare($query1);


/* Getting The Values */

$data1 = [
    ':date' => $DATEE,
    ':time' => $TIMEE,
    ':email' => $email,
    ':access_level' => $access_level,
    ':action' => $act,
];

  /* Executing the command */
$query_execute = $query_run->execute($data1);


  try {
    
    $query = "DELETE FROM survey_result WHERE id=:id";
    $statement = $conn->prepare($query);
    $data = [

     ':id' => $response_id

    ];

    $query_execute = $statement->execute($data);

  
if ($query_execute) {
    // ✅ Delete sa Google Sheets
    $data = [
        'action'     => 'delete',
        'id' => $response_id // o depende kung anong column gusto mong i-match
    ];

    $jsonData = json_encode($data);
    $url = "https://script.google.com/macros/s/AKfycbyZtUXUzN-KpP3U93x9n8mDH-I0JW2H9FdKaq5JdQdxoRhkzsoDwMAytAvzNMfjbaAcCw/exec"; // Web App URL mo

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
    $response = curl_exec($ch);
    curl_close($ch);

    // Debug kung gusto mo
    // error_log("Delete Response: " . $response);

    $_SESSION['status'] = "Response has been Deleted Succesfully";
    $_SESSION['status_code'] = "success";
    header('Location: ../responses.php');
    exit(0);
}

  } catch (PDOException $e) {
    echo $e->getMessage();
  }



}


?>