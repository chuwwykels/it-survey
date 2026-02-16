<?php
session_start();
include('../../connection/dbconfig.php');

//Super Admin Profile Edit

if(isset($_POST['editprofile_btn']))
{

  $fullname = $_POST['fullname'];
  $password = $_POST['password'];

//Going to Audit Trail             
 date_default_timezone_set("Asia/Manila"); 
                   
 $time = date("H:i:s");
 $date = date("Y-m-d");
 $act = "Updated his Profile";

$DATEE = $date;
$TIMEE = $time;
$sa_email = $_SESSION['email'];
$access_level = $_SESSION['access_level'];
$action = $act;


//Table Execution
$query1 = "INSERT INTO auditlogs (date,time,email,access_level,action) VALUES (:date, :time, :email, :access_level, :action)";
$query_run = $conn->prepare($query1);

//Getting value from post
$data1 = [
    ':date' => $DATEE,
    ':time' => $TIMEE,
    ':email' => $sa_email,
    ':access_level' => $access_level,
    ':action' => $act,
];

  /* Executing the command */
$query_execute = $query_run->execute($data1);



//After the other conditions the main program will executes!
 try {

  $query = "UPDATE superadmin SET  fullname=:fullname, email=:email, password=:password WHERE email=:email LIMIT 1";
  $statement = $conn->prepare($query);

  $data = [
    
    ':fullname' => $fullname,
    ':email' => $sa_email,
    ':password' => $password,

  ];


  $image = $_FILES['image']['name'];
  $image_tmp_name = $_FILES['image']['tmp_name'];
  $image_size = $_FILES['image']['size'];
  $image_folder = '../../images/'.$image;

  if(!empty($image)){

    if($image_size > 5000000){
    $_SESSION['error'] = "Uploading Error";
    $_SESSION['error_desc'] = "This image is too large!";
    $_SESSION['error_code'] = "warning";
    header('Location: ../profile.php');
    exit(0);


     }else{
        $update_image = $conn->prepare("UPDATE `superadmin` SET image = ? WHERE email = ?");
        $update_image->execute([$image, $sa_email]);

        if($update_image){
           move_uploaded_file($image_tmp_name, $image_folder);
        
           $message[] = 'image has been updated!';
        }
     }

  }

  $query_execute = $statement->execute($data);


               
                   



  if($query_execute)
  {

    $_SESSION['status'] = "Information Update Succesfully";
    $_SESSION['status_desc'] = "";
    $_SESSION['status_code'] = "success";
    

    header('Location: ../profile.php');
    exit(0);
 

  }
  else
  {

    $_SESSION['status'] = "Updating Error";
    $_SESSION['status_code'] = "error";
    header('Location: ../profile.php');
    exit(0);
     
  }

 } catch (PDOException $e) {
  echo $e->getMessage();
 }

}



?>