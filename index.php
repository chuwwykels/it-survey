<?php
session_start();

if (isset($_SESSION['primary_id'])) {
header("Location: rfidtrial.php");
}

if (isset($_SESSION['primary_id_success'])) {
    echo '<div class="alert alert-success">'.$_SESSION['primary_id_success'].'</div>';
    unset($_SESSION['primary_id_success']); // ✅ clear dito
}

if (isset($_SESSION['primary_id_error'])) {
    echo '<div class="alert alert-danger">'.$_SESSION['primary_id_error'].'</div>';
    unset($_SESSION['primary_id_error']); // ✅ clear dito
}

require_once 'connection/dbconfig.php';

$page_title = "IT Office Systems";
include('connection/dbconfig.php');
include('super_admin/includes/header.php');


$color = $result->site_color;
$color2 = $result->site_color2;
$opacity = 0.02; // Set your desired opacity value
$opacity2 = 0.15; // Set your desired opacity value

// Convert hex to rgba
list($r, $g, $b) = sscanf($color, "#%02x%02x%02x");
$rgbaColor = "rgba($r, $g, $b, $opacity)";

// Convert hex to rgba
list($r, $g, $b) = sscanf($color2, "#%02x%02x%02x");
$rgbaBackGround = "rgba($r, $g, $b, $opacity2)";
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body style="background: <?=$rgbaBackGround;?>;">

    <div class="loader"></div>

    <style>
    /* Hover effect for cards */
    .card-hover {
        transition: transform 0.8s ease, box-shadow 0.8s ease;
        cursor: pointer;
    }

    .card-hover:hover {
        transform: scale(1.05);
        /* lumalaki ng kaunti */
        box-shadow: 0 18px 20px rgba(0, 0, 0, 0.2);
        /* dagdag shadow */
    }
    </style>


    <div class="container py-5">
        <div class="row g-3 justify-content-center">

            <!-- Full Image Card -->
            <div class="col-12 col-md-12">
                <div class="card shadow" style="border-radius: 12px; overflow:hidden; background: <?=$rgbaColor;?>;">
                    <img src="images/header4.jpg" alt="IT Support" style="width: 100%; height:20%; object-fit:cover;">
                </div>
            </div>

            <br>

            <br>

            <br>

            <br>

            <br>

            <br>

            <br>

            <div class="container py-5">
                <div class="row g-4 align-items-stretch justify-content-center">

                    <!-- Card 1 -->
                    <div class="col-12 col-md-3">
                        <a href="survey.php" class="text-decoration-none text-dark">
                            <div class="card h-100 shadow text-center card-hover" style="background: #fcfcfc52;">
                                <div class="d-flex justify-content-center align-items-center" style="height:240px;">
                                    <img src="images/survey.png" alt="..."
                                        style="max-height:95%; max-width:95%; object-fit:contain;">
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title" style="color: #24167b;"><b>Submit a Log</b></h4>
                                    <p class="card-text">Tap this to submit your log response.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    
                    <!-- Card 2 -->
                    <div class="col-12 col-md-3">
                        <a href="https://sites.google.com/view/ssapitapplication/it-borrowers-log?fbclid=IwY2xjawM174RleHRuA2FlbQIxMQABHjTEKm63pDZrKCN8A2323OmQxR7BLcyeOkxGkJPQoi5lRYrH_hLRdIpTRRcV_aem_Eenk8ejeDgjA9lDeRvYKJQ"
                            target="_blank" class="text-decoration-none text-dark">
                            <div class="card h-100 shadow text-center card-hover" style="background: #fcfcfc52;">
                                <div class="d-flex justify-content-center align-items-center" style="height:240px;">
                                    <img src="images/borrow2.png" alt="..."
                                        style="max-height:120%; max-width:120%; object-fit:contain;">
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title" style="color: #24167b;"><b>Borrow an Item</b></h4>
                                    <p class="card-text">Tap this to proceed in Borrowing Item(s).</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Card 3 -->
                    <div class="col-12 col-md-3">
                        <a href="https://sites.google.com/view/ssapitapplication/led-wall-scheduler?fbclid=IwY2xjawM18nZleHRuA2FlbQIxMQABHgVbBMxEDQN1B6O8pnwxco2kc9UWs_Qh8oh7PIFgVbVn_lFF2iLjbY4Nihuc_aem_RdRRlHD1ITmPhF-JFbKz-A"
                            target="_blank" class="text-decoration-none text-dark">
                            <div class="card h-100 shadow text-center card-hover" style="background: #fcfcfc52;">
                                <div class="d-flex justify-content-center align-items-center" style="height:240px;">
                                    <img src="images/led.png" alt="..."
                                        style="max-height:100%; max-width:100%; margin-top: 1%; object-fit:contain;">
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title" style="color: #24167b;"><b>LED Wall Scheduler</b></h4>
                                    <p class="card-text">Tap this to proceed in LED Wall Scheduler.</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Card 4 -->
                    <div class="col-12 col-md-3">
                        <a href="https://sites.google.com/view/ssapitapplication/laboratory-scheduler" class="text-decoration-none text-dark">
                            <div class="card h-100 shadow text-center card-hover" style="background: #fcfcfc52;">
                                <div class="d-flex justify-content-center align-items-center" style="height:240px;">
                                    <img src="images/labscheduler.png" alt="..."
                                        style="max-height:100%; max-width:100%; object-fit:contain;">
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title" style="color: #24167b;"><b>Laboratory Scheduler</b></h4>
                                    <p class="card-text">Tap this to proceed in Computer Lab Scheduler.</p>
                                </div>
                            </div>
                        </a>
                    </div>


                    <script>
                    function showCardAlert() {
                        swal({
                            title: "Function Not Available",
                            text: "Sorry, this feature is not yet available. Please wait a little while.",
                            icon: "https://twemoji.maxcdn.com/v/latest/72x72/2639.png", // Sad face image
                            button: "OK"
                        });
                    }
                    </script>

                </div>
            </div>

            <!-- Right 2-col margin (hidden on xs) -->
            <div class="d-none d-md-block col-md-2"></div>
        </div>
    </div>

    <!-- Sweet Alert -->
    <script src="assets/js/sweetalert.min.js"></script>
    <?php
      if(isset($_SESSION['status']) && $_SESSION['status'] !='')
      {
        ?>
    <script>
    swal({
        title: "<?php echo $_SESSION['status']; ?>",
        text: "<?php echo $_SESSION['status_desc']; ?>",
        icon: "<?php echo $_SESSION['status_code']; ?>",
        button: "Okay!",
    });
    </script>
    <?php
          unset($_SESSION['status']);
      }
      
    ?>



    <!-- Sweet Alert with student image-->
    <script src="assets/js/sweetalert.min.js"></script>
    <?php if(isset($_SESSION['picture_status']) && $_SESSION['picture_status'] !=''){ ?>
    <script>
    swal({
        title: "<?php echo $_SESSION['picture_status']; ?>",
        text: "<?php echo $_SESSION['picture_desc']; ?>",
        icon: "<?php echo $_SESSION['picture_code']; ?>",
        button: "Okay!"
    });
    </script>

    <style>
    /* baguhin yung lalagyan ng icon */
    .swal-icon {
        width: 200px !important;
        /* lakihan container */
        height: 200px !important;
        /* gawing square */
        margin: 20px auto !important;
        /* center */
    }

    /* resize actual image sa loob */
    .swal-icon img {
        width: 100% !important;
        height: 100% !important;
        object-fit: cover;
        /* sakto square, walang sobra */
        border-radius: 10px;
        /* optional: gawing rounded corner */
    }
    </style>
    <?php
  unset($_SESSION['picture_status']);
  unset($_SESSION['picture_desc']);
  unset($_SESSION['picture_code']);
} ?>






    <!-- Sweet Alert with student image-->
    <script src="assets/js/sweetalert.min.js"></script>
    <?php if(isset($_SESSION['picture_status']) && $_SESSION['picture_status'] !=''){ ?>
    <script>
    swal({
        title: "<?php echo $_SESSION['picture_status']; ?>",
        text: "<?php echo $_SESSION['picture_desc']; ?>",
        icon: "<?php echo $_SESSION['picture_code']; ?>",
        button: "Okay!"
    });
    </script>

    <?php
  unset($_SESSION['picture_status']);
  unset($_SESSION['picture_desc']);
  unset($_SESSION['picture_code']);
} ?>



    <!-- Sweet Alert Error-->
    <script src="assets/js/sweetalert.min.js"></script>
    <?php
      if(isset($_SESSION['error']) && $_SESSION['error'] !='')
      {
        ?>
    <script>
    swal({
        title: "<?php echo $_SESSION['error']; ?>",
        text: "<?php echo $_SESSION['error_desc'] ?>",
        icon: "<?php echo $_SESSION['error_code']; ?>",
        button: true,
        dangerMode: true,
        type: "warning",
    });
    </script>
    <?php
          unset($_SESSION['error']);
      }
      
    ?>

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

    <script>
    window.addEventListener("load", () => {
        const loader = document.querySelector(".loader1");

        loader.classList.add("loader--hidden");

        loader.addEventListener("transitionend", () => {
            document.body.removeChild(loader);
        });
    });
    </script>

    <!-- AutoClick the Input Type -->
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        var scanModal = document.getElementById('scanrfid');
        var rfidInput = document.getElementById('rfidInput');

        scanModal.addEventListener('shown.bs.modal', function() {
            rfidInput.focus(); // auto-focus input kapag lumabas yung modal
        });
    });
    </script>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>