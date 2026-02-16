<?php
 session_start();


if(!isset($_SESSION['email']) || $_SESSION['email'] === null){
    header('location: index.php');
}

$page_title = "Super Admin Profile";
include('../connection/dbconfig.php');
include('includes/header.php');
include('includes/navbar.php');

//Getting The Super_Admin Info
$sa_email = $_SESSION['email'];
 
$queryinfo = "SELECT * FROM superadmin WHERE email=:sa_email LIMIT 1";
$statementinfo = $conn->prepare($queryinfo);
$datainfo = [
 
 ':sa_email'=> $sa_email
 
 ];
 
$statementinfo->execute($datainfo);
 
$sa_info = $statementinfo->fetch(PDO::FETCH_OBJ);

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
        <h1 class="h3 mb-0 text-gray-800">Profile</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dash.php" style="color:<?=$result->site_color; ?>">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit Profile</li>
        </ol>
    </div>

    <br>

    <div class="row mb-4">
        <!-- Picture -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-40">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col ml-4">

                            <form action="functions/profile.php" method="POST" enctype="multipart/form-data">

                                <center><img class="img-profile rounded-circle" id="imagePreview" alt="Image Preview"
                                        src="../images/<?=$sa_info->image; ?>"
                                        style=" margin-bottom: 3%; position: relative; width: 160px; height: 160px; overflow: hidden; border-radius: 50%; border: 1px gray solid;">
                                </center>
                        </div>
                        <div class="col-auto">
                        </div>
                    </div>

                    <h6 class="m-2 text-center font-weight-bolder" style="color:<?=$result->site_color; ?>">
                        <?=$sa_info->access_level ?></h6>

                    <hr>
                    <center><input type="file" name="image" class="box" accept="jpg,png,jpeg"
                            onchange="previewImage(event)" style="margin-left: 20%;"></center>
                </div>
            </div>
        </div>

        <!-- Earnings (Annual) Card Example -->
        <div class="col-xl-9 col-md-6 mb-4">
            <div class="card h-100">

                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bolder" style="color:<?=$result->site_color; ?>">Personal Information
                    </h6>
                    <div class="dropdown no-arrow">

                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">

                        </div>
                    </div>
                </div>

                <div class="card-body">

                    <div class="row">
                        <div class="col-md-4 sm-3">
                            <label>Name <span class="required">*</span></label>
                            <input type="text" name="fullname" id="fullname" value="<?=$sa_info->fullname; ?>"
                                class="form-control" placeholder="Enter Name" required>
                        </div>

                        <div class="col-md-5 sm-3">
                            <label>Email <span class="required">*</span></label>
                            <input type="text" name="email" id="email" class="form-control"
                                value="<?=$sa_info->email; ?>" placeholder="Enter Age" readonly>
                        </div>
                        <div class="col-md-3 sm-3">
                            <label>Password <span class="required">*</span></label>
                            <div class="password-container">
                                <input type="password" name="password" id="password" value="<?=$sa_info->password; ?>"
                                    class="form-control" placeholder="Enter Password" required>
                                <span class="eye-toggle">
                                    <i class="fas fa-eye" id="togglePassword"></i>
                                </span>
                            </div>
                        </div>
                    </div>

                    <br>

                    <br>

                    <button type="submit" name="editprofile_btn" class="font-weight-bold text-light btn"
                        style="float: right; margin-top: 1%; background-color:<?=$result->site_color; ?>">
                        Save
                    </button>

                    </form>

                    <br>

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