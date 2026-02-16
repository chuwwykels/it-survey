<?php
session_start();

if (isset($_SESSION['email'])) {
header("Location: dash.php");
}

require_once '../connection/dbconfig.php';

 try  
 {  
        
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  
    if(isset($_POST["login"]))  
    {  
         if(empty($_POST["email"]) || empty($_POST["password"]))  
         {  
              $message = 'Fill up The following details';  
            
         }  
         else  
         {  

          

              $pdoQuery = "SELECT * FROM superadmin WHERE email = :email AND password = :password";  
              $pdoResult = $conn->prepare($pdoQuery);  
             
              $pdoResult->execute(  
                   array(  
                        'email'     =>     $_POST["email"],  
                        'password'     =>     $_POST["password"],
                   )  
              );  

              $row = $pdoResult->fetch(PDO::FETCH_ASSOC);
              if($pdoResult->rowCount() > 0){

                  //Super Admin Section

                if($row['access_level'] == 'Super Admin'){

                  $_SESSION['access_level'] = $row['access_level'];
                  $_SESSION["email"] = $row["email"];
                  $email = $row["email"];


                  try  
                  {  
                       
                   if(isset($_POST['login']))
                 {  

             

                      
                 date_default_timezone_set("Asia/Manila"); 
                 
                 $time = date("G:i:s");
                 $date = date("Y-m-d");
                 $act = "Logged in the system";
                 
                 
                 
                 $DATEE = $date;
                 $TIMEE = $time;
                 $email = $_POST['email'];
                 $access_level = $row['access_level'];
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

                 }
  
                  }  

                  
                  catch(PDOException $error)  
                  {  
                       $message = $error->getMessage();  
                  }
                 



                   header('location:dash.php');


                  }elseif($row['access_level'] == 'Super Admin'){

          
                }else{
                   $message = 'no user found!';
                }
                
             }else{
                $message = 'incorrect email or password!';
             }
         }  
    }  
}  
catch(PDOException $error)  
{  
    $message = $error->getMessage();  
}  

//For Site Setting
$query = "SELECT * FROM system";
$statement = $conn->prepare($query);
$statement->execute();
$result1 = $statement->fetch(PDO::FETCH_OBJ);
$site_color = $result1->site_color;
$site_text = $result1->site_text;

$hexColor = $site_color;
$opacity = 0.85; // Set your desired opacity value

list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");
$rgbaColor = "rgba($r, $g, $b, $opacity)";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="../images/ssalogo.png" rel="icon">
    <title>Super Admin Login Page</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link href="../css/loader1.php" rel="stylesheet">

    <style>
    body {
        font-family: 'Varela Round', sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background-color: #f0f0f0;
        /* Add a background color for visualization */
    }

    .modal-login {
        width: 300%;
        /* Add a black border */
    }

    .modal-login .modal-content {
        padding: 20px;
        border-radius: 1px;
        border: 1px solid gray;
    }

    .modal-login .modal-header {
        border-bottom: none;
        position: relative;
        justify-content: center;
    }

    .modal-login h4 {
        text-align: center;
        font-size: 26px;
    }

    .modal-login .form-control,
    .modal-login .btn {
        min-height: 40px;
        border-radius: 1px;
    }

    .modal-login .hint-text {
        text-align: center;
        padding-top: 10px;
    }

    .modal-login .close {
        position: absolute;
        top: -5px;
        right: -5px;
    }

    .modal-login .btn {
        color: <?php echo $site_text;
        ?>;
        background: <?php echo $site_color;
        ?>;
        border: none;
        line-height: normal;
    }

    .modal-login .btn:hover,
    .modal-login .btn:focus {
        background:<?php echo $rgbaColor; ?>;
    }

    .modal-login .hint-text a {
        color: #999;
    }

    .trigger-btn {
        display: inline-block;
        margin: 100px auto;
    }
    </style>

</head>

<body>

    <div class="loader-container">
        <div class="loader"></div>
    </div>


    <div class="modal-dialog modal-login">

        <center>
            <h4 style="font-weight: bolder;"><img src="../images/ssalogo.png"
                    style="width: 50px; height: 50px; margin-right: 3%; vertical-align: middle;">SSATrack</h4>
        </center>

        <br>

        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Super Admin Login</h4>
                <a href="../index.php" class="close" data-dismiss="modal" aria-hidden="true">&times;</a>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="form-group">

                        <?php  
                if(isset($message))  
                {  
                   
                    echo  '<h6 class="alert alert-success">'.$message.'</h6>';
               
                } 
          
            ?>

                        <input type="email" class="form-control" name="email" autocomplete="off" placeholder="Email" style="width: 100%"
                            required="required">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" placeholder="Password"
                            style="width: 100%" required="required">
                    </div>
                    <br>
                    <div class="form-group">
                        <input type="submit" name="login" class="btn btn-block btn-lg" value="Login">
                    </div>
                </form>

            </div>
        </div>
    </div>



    <!--For Loader-->


    <script>
    window.addEventListener("load", () => {
        const loader = document.querySelector(".loader");

        loader.classList.add("loader--hidden");

        loader.addEventListener("transitionend", () => {
            document.body.removeChild(loader);
        });
    });
    </script>


</body>

</html>