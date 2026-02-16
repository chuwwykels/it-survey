<?php
 session_start();

 if(!isset($_SESSION['email']) || $_SESSION['email'] === null){
    header('location: index.php');
}

 $page_title = "Site Settings";
 include('../connection/dbconfig.php');
 include('includes/header.php');
 include('includes/navbar.php');

  ?>


<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper" style="overflow-y: scroll; height: 82vh;">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Site Settings</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dash.php" style="color:<?=$result->site_color; ?>">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Site Setting</li>
        </ol>
    </div>




    <?php

    $purpose = 'inventory';


    $query = "SELECT * FROM system LIMIT 1";
    $statement = $conn->prepare($query);
    $statement->execute();

    $result = $statement->fetch(PDO::FETCH_OBJ);


 ?>
    <form action="functions/setting.php" method="POST" enctype="multipart/form-data">


        <input type="text" name="id" value="<?= $result->system_id; ?>" id="address" hidden>

        <br>

        <div class="row">
            <div class="col">
                <center><img class="img-profile" src="../images/<?= $result->site_logo; ?>" id="imagePreview"
                        alt="Image Preview" style="position: relative; width: 180px; height: 180px; overflow: hidden;">
                </center>
                <input type="hidden" name="old_logo" value="<?= $result->site_logo; ?>">
            </div>
        </div>

        <br>

        <br>

        <div class="row">
            <div class="col">
                <label style="color:black;">Change Site Logo</label>
                <input type="file" value="<?= $result->site_logo; ?>" onchange="previewImage(event)" name="site_logo"
                    id="address" class="form-control" accept="jpg,png,jpeg" placeholder="Enter Site Logo">
            </div>
        </div>


        <br>

        <div class="row">
            <div class="col-md-6 sm-3">
                <label style="color:black;">Change Site Primary Color</label>
                <select name="site_color" value="<?= $result->site_color; ?>" id="site_color" class="form-control"
                    required>
                    <option value="<?= $result->site_color2; ?>">-Select Color-</option>
                    <option style="color: #d49b7c" value="#d49b7c">Default</option>
                    <option style="color: #203354" value="#0f0856">Default Blue</option>
                    <option style="color: #203354" value="#203354">Navy Blue</option>
                    <option style="color: #023e8a" value="#023e8a">Royal Blue</option>
                    <option style="color: #2F539B" value="#2F539B">Estoril Blue</option>
                    <option style="color: #368BC1" value="#368BC1">Ice</option>
                    <option style="color: #3B9C9C" value="#3B9C9C">Deep Sea</option>
                    <option style="color: #ffa5d6" value="#ffa5d6">Pinkish Balings</option>
                    <option style="color: #ffd6ee" value="#ffd6ee">Light Pink</option>
                    <option style="color: #ced1f8" value="#ced1f8">Light Purple</option>
                </select>
            </div>

            <div class="col-md-6 sm-3">
                <label style="color:black;">Change Site Secondary Color</label>
                <select name="site_color2" value="<?= $result->site_color2; ?>" id="site_color2" class="form-control"
                    required>
                    <option value="<?= $result->site_color2; ?>">-Select Color-</option>
                    <option style="color: #d49b7c" value="#d49b7c">Default</option>
                    <option style="color: #203354" value="#0f0856">Default Blue</option>
                    <option style="color: #203354" value="#203354">Navy Blue</option>
                    <option style="color: #023e8a" value="#023e8a">Royal Blue</option>
                    <option style="color: #2F539B" value="#2F539B">Estoril Blue</option>
                    <option style="color: #368BC1" value="#368BC1">Ice</option>
                    <option style="color: #3B9C9C" value="#3B9C9C">Deep Sea</option>
                    <option style="color: #ffa5d6" value="#ffa5d6">Pinkish Balings</option>
                    <option style="color: #ffd6ee" value="#ffd6ee">Light Pink</option>
                    <option style="color: #ced1f8" value="#ced1f8">Light Purple</option>
                </select>
            </div>

        </div>

        <br>

        <div class="row">
            <div class="col-md-6 sm-3">
                <label style="color:black;"> Change Site Name </label>
                <input type="text" name="site_name" id="site_name" value="<?= $result->site_name; ?>"
                    class="form-control" placeholder="Enter Site Name">
            </div>

            <div class="col-md-6 sm-3">
                <label style="color:black;">Change Site Text Color</label>
                <select name="site_text" value="<?= $result->site_text ?>" id="site_text" class="form-control"
                    required>
                    <option value="<?= $result->site_text; ?>">-Select Color-</option>
                    <option style="color: black" value="black">Dark</option>
                    <option style="color: grey" value="White">Light</option>
                </select>
            </div>
        </div>


        <br>
        <br>

        <div class="modal-footer">
            <button type="submit" name="siteedit_btn" class="font-weight-bold btn"
                style="background-color:<?=$result->site_color; ?>; color:<?=$result->site_text; ?>;">Save Settings</button>
        </div>

    </form>
</div>




<!-- Scroll to top -->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>


<?php

 include('includes/scripts.php');
 include('includes/footer.php');

  ?>