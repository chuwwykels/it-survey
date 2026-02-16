<?php
session_start();
include('../../connection/dbconfig.php');


// Delete Student Account


if(isset($_POST['student_delete']))
{

  $student_id = $_POST['studentdelete_id'];

  $select = $conn->prepare("SELECT * FROM `student` WHERE id = ?");
  $select->execute([$student_id]);

  $row = $select->fetch(PDO::FETCH_ASSOC);
  
  if($select->rowCount() > 0){

    $fullname = $row['fullname'];
    
  }

//Audit Trail
        
date_default_timezone_set("Asia/Manila"); 
                   
$time = date("H:i:s");
$date = date("Y-m-d");
$act = "Deleted The Student:  ".$fullname;

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
    
    $query = "DELETE FROM student WHERE id=:id";
    $statement = $conn->prepare($query);
    $data = [

     ':id' => $student_id

    ];

    $query_execute = $statement->execute($data);

  
    if($query_execute)
  {

    $_SESSION['status'] = "Student : $fullname has been Deleted Succesfully";
    $_SESSION['status_desc'] = "";
    $_SESSION['status_code'] = "success";
    header('Location: ../student.php');
    exit(0);

  }
  else
  {

    $_SESSION['delete'] = "Deleting Error";
    $_SESSION['delete_code'] = "success";
    header('Location: ../student.php');
    exit(0);
     
  }

  } catch (PDOException $e) {
    echo $e->getMessage();
  }



}




//Edit Position

if(isset($_POST['student_edit']))
{
  $id = $_POST['id'];
  $fullname = $_POST['fullname'];
  $stud_id = $_POST['stud_id'];
  $rfid = $_POST['rfid'];

//Audit Trail           
date_default_timezone_set("Asia/Manila"); 
                   
$time = date("H:i:s");
$date = date("Y-m-d");
$act = "Edited Student Info of:  ".$fullname;

$DATEE = $date;
$TIMEE = $time;
$email = $_SESSION['email'];
$access_level = $_SESSION['access_level'];
$action = $act;

//Executing Command for Audit Trail 
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

  $query = "UPDATE student SET fullname=:fullname, stud_id=:stud_id, rfid=:rfid  WHERE id=:id LIMIT 1";
  $statement = $conn->prepare($query);

  $data = [

    ':fullname' => $fullname,
    ':stud_id' => $stud_id,
    ':rfid' => $rfid,
    ':id' => $id,

  ];

  $query_execute = $statement->execute($data);

  

  if($query_execute)
  {
  
    $_SESSION['status'] = "Student: $fullname Info has been Updated Succesfully";
    $_SESSION['status_desc'] = "";
    $_SESSION['status_code'] = "success";
    header('Location: ../student.php');
    exit(0);
  
  }
  else
  {
  
    $_SESSION['delete'] = "Updating Error";
    $_SESSION['delete_code'] = "success";
    header('Location: ../student.php');
    exit(0);
     
  }
  

 } catch (PDOException $e) {
  echo $e->getMessage();
 }

}




//Add Student

if(isset($_POST['student_add']))

{

  $fullname = $_POST['fullname'];
  $stud_id = $_POST['stud_id'];
  $rfid = $_POST['rfid'];

  //Users database
  $select = $conn->prepare("SELECT * FROM student WHERE stud_id = ?");
  $select->execute([$stud_id]);

  if($select->rowCount() > 0){
    $_SESSION['error'] = "Adding Error";
    $_SESSION['error_desc'] = "This Student already exist!";
    $_SESSION['error_code'] = "warning";
    header('Location: ../student.php');
    exit(0);
  
    }else{

try {

  $query = "INSERT INTO student (fullname, stud_id, rfid) VALUES (:fullname, :stud_id, :rfid)";
  $query_run = $conn->prepare($query);
  
  $data = [
  
      ':fullname' => $fullname,
      ':stud_id' => $stud_id,
      ':rfid' => $rfid,
  
          ];
  
  $query_execute = $query_run->execute($data);
  

  //Audit Trail   
  date_default_timezone_set("Asia/Manila"); 
                   
  $time = date("H:i:s");
  $date = date("Y-m-d");
  $act = "Added New Student:  ".$fullname;
  
  $DATEE = $date;
  $TIMEE = $time;
  $email = $_SESSION['email'];
  $action = $act;
  $access_level = $_SESSION['access_level'];
  
  /*          name Of table                  Rows                               target names */
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

  
if($query_execute)
{

  $_SESSION['status'] = "Student: $fullname has been Added Succesfully";
  $_SESSION['status_desc'] = "";
  $_SESSION['status_code'] = "success";
  header('Location: ../student.php');
  exit(0);

}
else
{

  $_SESSION['delete'] = "Adding Error";
  $_SESSION['delete_code'] = "success";
  header('Location: ../student.php');
  exit(0);
   
}


 } catch (PDOException $e) {
  echo $e->getMessage();
 }
    }
}

?>