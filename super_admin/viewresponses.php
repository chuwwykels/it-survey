<?php
 session_start();


if(!isset($_SESSION['email']) || $_SESSION['email'] === null){
    header('location: index.php');
}

$page_title = "View Responses";
include('../connection/dbconfig.php');
include('includes/header.php');
include('includes/navbar.php');

//Getting The Staff Info
$response_id = $_GET['id'];
 
$queryinfo = "SELECT * FROM survey_result WHERE id=:response_id LIMIT 1";
$statementinfo = $conn->prepare($queryinfo);
$datainfo = [
 
 ':response_id'=> $response_id
 
 ];
 
$statementinfo->execute($datainfo);
 
$survey_info = $statementinfo->fetch(PDO::FETCH_OBJ);


?>

<!-- For asterisk and eye toggler -->
<style>
.password-container {
    position: relative;
}

.eye-toggle {
    position: absolute;
    right: 10px;
    top: 60%;
    transform: translateY(-50%);
    cursor: pointer;
    z-index: 1;
}

.eye-toggle i {
    font-size: 18px;
    color: #999;
}

#password {
    padding-right: 30px;
    /* Adjust as needed based on icon size */
}

.required {
    color: red;
}
</style>


<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper" style="overflow-y: scroll; height: 82vh;">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">View Responses</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dash.php" style="color:<?=$result->site_color; ?>">Dashboard</a></li>
            <li class="breadcrumb-item"><a href="responses.php" style="color:<?=$result->site_color; ?>">List of
                    Responses</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">View Responses</li>
        </ol>
    </div>

    <br>
    <br>

    <div class="row mb-4">
        <!-- Picture -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-40">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col ml-4">

                                <center><img class="img-profile" id="imagePreview" alt="Image Preview"
                                        src="../images/user/<?=$survey_info->primary_id; ?>.jpg"
                                        style=" margin-bottom: 3%; position: relative; width: 160px; height: 160px; overflow: hidden;">
                                </center>
                        </div>
                        <div class="col-auto">
                        </div>
                    </div>

                                     <hr>
                                     
                    <h6 class="m-2 text-center font-weight-bolder" style="color:<?=$result->site_color; ?>">
                        <?=$survey_info->user_type; ?></h6>
          
                </div>
            </div>
        </div>

        <!-- Earnings (Annual) Card Example -->
        <div class="col-xl-9 col-md-6 mb-4">
            <div class="card h-100">

                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bolder" style="color:<?=$result->site_color; ?>">Response Information
                    </h6>
                    <div class="dropdown no-arrow">

                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">

                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-6 sm-3">
                            <label>Respondent Name <span class="required">*</span></label>
                            <input type="text" name="fullname" id="fullname" value="<?=$survey_info->fullname; ?>"
                                class="form-control" placeholder="N/A" readonly>
                        </div>
                        <div class="col-md-6 sm-3">
                            <label>Student / Employee ID <span class="required">*</span></label>
                            <input type="text" name="primary_id" id="primary_id" value="<?=$survey_info->primary_id; ?>"
                                class="form-control" placeholder="N/A" readonly>
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-md-4 sm-3">
                            <label>Assistance Type <span class="required">*</span></label>
                            <input type="text" name="assist_type" id="assist_type"
                                value="<?=$survey_info->assist_type; ?>" class="form-control" placeholder="N/A"
                                readonly>
                        </div>

                        <div class="col-md-4 sm-3">
                            <label>Ratings <span class="required">*</span></label>
                            <input type="text" name="ratings" id="ratings" value="<?=$survey_info->ratings; ?>"
                                class="form-control" placeholder="N/A" readonly>
                        </div>
                    </div>

                    <br>

                    <div class="row">
                        <div class="col-md-12 sm-3">
                            <label>
                                Any comments or suggestions?
                            </label>
                            <textarea class="form-control" id="comments" name="comments" rows="5"
                                readonly><?=$survey_info->comment;?></textarea>
                        </div>


                    </div>


                </div>
            </div>

            <!-- Footer -->

        </div>
    </div>



    <!-- Scroll to top -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>








    <?php

include('includes/scripts.php');
include('includes/footer.php');

?>