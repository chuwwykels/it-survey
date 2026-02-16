<?php
session_start();
include('../../connection/dbconfig.php');


//Edit Site


if(isset($_POST['siteedit_btn']))
{

  $system_id = $_POST['id'];
  $site_name = $_POST['site_name'];
  $site_color = $_POST['site_color'];
  $site_color2 = $_POST['site_color2'];
  $site_text = $_POST['site_text'];

//Going to Audit Trail             
 date_default_timezone_set("Asia/Manila"); 
                   
 $time = date("H:i:s");
 $date = date("Y-m-d");
 $act = "Customize The Site";

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


 try {

  $query = "UPDATE system SET site_name=:site_name, site_color=:site_color, site_color2=:site_color2, site_text=:site_text WHERE system_id=:system_id LIMIT 1";
  $statement = $conn->prepare($query);

  $data = [
    
    ':system_id' => $system_id,
    ':site_name' => $site_name,
    ':site_color' => $site_color,
    ':site_color2' => $site_color2,
    ':site_text' => $site_text,
    

  ];

  $old_image = $_POST['old_logo'];
  $site_logo = $_FILES['site_logo']['name'];
  $image_tmp_name = $_FILES['site_logo']['tmp_name'];
  $image_size = $_FILES['site_logo']['size'];
  $image_folder = '../../image/'.$site_logo;

  if(!empty($site_logo)){

     if($image_size > 5000000){
        $_SESSION['error'] = "Uploading Error";
        $_SESSION['error_desc'] = "This image is too large!";
        $_SESSION['error_code'] = "warning";
        header('Location: ../profile.php');
        exit(0);

     }else{
        $update_image = $conn->prepare("UPDATE `system` SET site_logo = ? WHERE system_id = ?");
        $update_image->execute([$site_logo, $system_id]);

        if($update_image){
           move_uploaded_file($image_tmp_name, $image_folder);
           if($old_image != "default.svg"){
            unlink('../../image/'.$old_image);
           }
           $message[] = 'image has been updated!';
        }
     }

  }

  $query_execute = $statement->execute($data);
  


               
  if($query_execute)
  {

    $_SESSION['status'] = "Site Has Customized Successfully!";
    $_SESSION['status_desc'] = "";
    $_SESSION['status_code'] = "success";
    

    header('Location: ../site_setting.php');
    exit(0);
 

  }
  else
  {

    $_SESSION['status'] = "Updating Error";
    $_SESSION['status_code'] = "error";
    header('Location: ../site_setting.php');
    exit(0);
     
  }

 } catch (PDOException $e) {
  echo $e->getMessage();
 }

}



?>