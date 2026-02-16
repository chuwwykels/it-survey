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

$page_title = "IT Support Logs and Feedback Survey";
include('connection/dbconfig.php');
include('super_admin/includes/header.php');


// Getting the Value of RFID Number
if(isset($_POST['rfid_submit'])) {

    $rfid = trim($_POST['rfid']); //trim nagtatanggal ng spacing

    if(empty($rfid)) {
        $_SESSION['error'] = "No RFID Submitted!";
        $_SESSION['error_code'] = "error";
        header("Location: index.php");
        exit();
    }
  
    $select = $conn->prepare("
        SELECT stud_id AS primary_id, fullname, rfid, 'Student' AS user_type 
        FROM student WHERE rfid = ?
        UNION
        SELECT emp_id AS primary_id, fullname, rfid, 'Employee' AS user_type
        FROM employee WHERE rfid = ?
    ");
    $select->execute([$rfid, $rfid]);

    $rfid_result = $select->fetch(PDO::FETCH_OBJ);

   if ($rfid_result) {
    // Save to session para accessible kahit saan
    $_SESSION['fullname']   = $rfid_result->fullname;
    $_SESSION['primary_id'] = $rfid_result->primary_id;
    $_SESSION['user_type']  = $rfid_result->user_type;

    $_SESSION['picture_status'] = $rfid_result->fullname;
    $_SESSION['picture_desc']   = "Welcome to IT Support Logs and Feedback Survey 😊";

    // Check kung may existing picture
    $extensions = ['jpg', 'jpeg', 'png'];
    $pic = "images/No_Pic 2.png"; // default

    foreach ($extensions as $ext) {
        $file = "images/user/" . $rfid_result->primary_id . "." . $ext;
        if (file_exists($file)) {
            $pic = $file;
            break;
        }
    }

    $_SESSION['picture_code'] = $pic; // path sa image

    header("Location: rfidtrial.php");
    exit();

} else {
    $_SESSION['error'] = "RFID Not Found!";
    $_SESSION['error_desc'] = "";
    $_SESSION['error_code'] = "error";
}
    // Para hindi mag-resubmit pag refresh
    header("Location: index.php");
    exit();
}




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
                    <img src="images/header_survey.jpg" alt="IT Support"
                        style="width: 100%; height:20%; object-fit:cover;">
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


                      <!-- Card Exit -->
                    <div class="col-12 col-md-3">
                        <a href="index.php" class="text-decoration-none text-dark">
                            <div class="card h-100 shadow text-center card-hover" style="background: #fcfcfc52;">
                                <div class="d-flex justify-content-center align-items-center" style="height:240px;">
                                    <img src="images/exit.png" alt="..."
                                        style="max-height:100%; max-width:100%; object-fit:contain;">
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title" style="color: #24167b;"><b>Go Back</b></h4>
                                    <p class="card-text">Tap to Return to the Homepage or Main Menu.</p>
                                </div>
                            </div>
                        </a>
                    </div>
                    
                    <!-- Card 1 -->
                    <div class="col-12 col-md-3">
                        <button type="button" class="p-0 border-0 bg-transparent w-100 text-dark text-decoration-none"
                            data-bs-toggle="modal" data-bs-target="#scanrfid">
                            <div class="card h-100 shadow text-center card-hover" style="background: #fcfcfc52;">
                                <div class="d-flex justify-content-center align-items-center" style="height:240px;">
                                    <img src="images/rfid.png" alt="..."
                                        style="max-height:100%; max-width:100%; object-fit:contain;">
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title" style="color: #24167b;"><b>RFID Tapping</b></h4>
                                    <p class="card-text">Automatically fills in your information with just a tap of your
                                        ID.</p>
                                </div>
                            </div>
                        </button>
                    </div>


                    <!-- Scan Modal -->

                    <div class="modal fade" id="scanrfid" style="margin-top: 5%;" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog" role="document" style="max-width: 40%;">

                            <form action="" method="POST">
                                <!-- Form -->

                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle" style="color: black;">Scan
                                            RFID
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                        </button>
                                    </div>
                                    <div class="modal-body">

                                        <br>

                                        <div class="row">
                                            <div class="col">
                                                <input type="number" name="rfid" id="rfidInput" value=""
                                                    class="form-control" placeholder="Please Tap your ID" required>
                                            </div>
                                        </div>

                                        <br>

                                        <div class="modal-footer">
                                            <button type="submit" name="rfid_submit" class="btn btn-primary"
                                                hidden>Submit</button>
                                        </div>
                                    </div>
                                </div>
                        </div>

                    </div> <!-- Divider -->

                    </form>

                    <!-- Card 2 -->
                    <div class="col-12 col-md-3">
                        <a href="manualtrial.php" class="text-decoration-none text-dark">
                            <div class="card h-100 shadow text-center card-hover" style="background: #fcfcfc52;">
                                <div class="d-flex justify-content-center align-items-center" style="height:240px;">
                                    <img src="images/type.png" alt="..."
                                        style="max-height:100%; max-width:100%; object-fit:contain;">
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title" style="color: #24167b;"><b>Encode Manually</b></h4>
                                    <p class="card-text">Provide your details manually if your ID is not available.</p>
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