<?php
session_start();
include('../../connection/dbconfig.php');


// Delete Employee Account


if(isset($_POST['employee_delete']))
{

  $employee_id = $_POST['employeedelete_id'];

  $select = $conn->prepare("SELECT * FROM `employee` WHERE id = ?");
  $select->execute([$employee_id]);

  $row = $select->fetch(PDO::FETCH_ASSOC);
  
  if($select->rowCount() > 0){

    $fullname = $row['fullname'];
    
  }

//Audit Trail
        
date_default_timezone_set("Asia/Manila"); 
                   
$time = date("H:i:s");
$date = date("Y-m-d");
$act = "Deleted The Employee:  ".$fullname;

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
    
    $query = "DELETE FROM employee WHERE id=:id";
    $statement = $conn->prepare($query);
    $data = [

     ':id' => $employee_id

    ];

    $query_execute = $statement->execute($data);

  
    if($query_execute)
  {

    $_SESSION['status'] = "Employee : $fullname has been Deleted Succesfully";
    $_SESSION['status_desc'] = "";
    $_SESSION['status_code'] = "success";
    header('Location: ../employee.php');
    exit(0);

  }
  else
  {

    $_SESSION['delete'] = "Deleting Error";
    $_SESSION['delete_code'] = "success";
    header('Location: ../employee.php');
    exit(0);
     
  }

  } catch (PDOException $e) {
    echo $e->getMessage();
  }



}




//Edit Position

if(isset($_POST['employee_edit']))
{
  $id = $_POST['id'];
  $fullname = $_POST['fullname'];
  $emp_id = $_POST['emp_id'];
  $rfid = $_POST['rfid'];

//Audit Trail           
date_default_timezone_set("Asia/Manila"); 
                   
$time = date("H:i:s");
$date = date("Y-m-d");
$act = "Edited Employee Info of:  ".$fullname;

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

  $query = "UPDATE employee SET fullname=:fullname, emp_id=:emp_id, rfid=:rfid  WHERE id=:id LIMIT 1";
  $statement = $conn->prepare($query);

  $data = [

    ':fullname' => $fullname,
    ':emp_id' => $emp_id,
    ':rfid' => $rfid,
    ':id' => $id,

  ];

  $query_execute = $statement->execute($data);

  

  if($query_execute)
  {
  
    $_SESSION['status'] = "Employee: $fullname Info has been Updated Succesfully";
    $_SESSION['status_desc'] = "";
    $_SESSION['status_code'] = "success";
    header('Location: ../employee.php');
    exit(0);
  
  }
  else
  {
  
    $_SESSION['delete'] = "Updating Error";
    $_SESSION['delete_code'] = "success";
    header('Location: ../employee.php');
    exit(0);
     
  }
  

 } catch (PDOException $e) {
  echo $e->getMessage();
 }

}




//Add Employee

if(isset($_POST['employee_add']))

{

  $fullname = $_POST['fullname'];
  $emp_id = $_POST['emp_id'];
  $rfid = $_POST['rfid'];

  //Users database
  $select = $conn->prepare("SELECT * FROM employee WHERE emp_id = ?");
  $select->execute([$emp_id]);

  if($select->rowCount() > 0){
    $_SESSION['error'] = "Adding Error";
    $_SESSION['error_desc'] = "This Employee already exist!";
    $_SESSION['error_code'] = "warning";
    header('Location: ../employee.php');
    exit(0);
  
    }else{

try {

  $query = "INSERT INTO employee (fullname, emp_id, rfid) VALUES (:fullname, :emp_id, :rfid)";
  $query_run = $conn->prepare($query);
  
  $data = [
  
      ':fullname' => $fullname,
      ':emp_id' => $emp_id,
      ':rfid' => $rfid,
  
          ];
  
  $query_execute = $query_run->execute($data);
  

  //Audit Trail   
  date_default_timezone_set("Asia/Manila"); 
                   
  $time = date("H:i:s");
  $date = date("Y-m-d");
  $act = "Added New Employee:  ".$fullname;
  
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

  $_SESSION['status'] = "Employee: $fullname has been Added Succesfully";
  $_SESSION['status_desc'] = "";
  $_SESSION['status_code'] = "success";
  header('Location: ../employee.php');
  exit(0);

}
else
{

  $_SESSION['delete'] = "Adding Error";
  $_SESSION['delete_code'] = "success";
  header('Location: ../employee.php');
  exit(0);
   
}


 } catch (PDOException $e) {
  echo $e->getMessage();
 }
    }
}

?>