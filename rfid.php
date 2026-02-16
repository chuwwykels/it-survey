<?php
session_start();


 if(!isset($_SESSION['primary_id']) || $_SESSION['primary_id'] === null){
    header('location: index.php');
}

$page_title = "RFID Method Survey ";
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



if(isset($_POST['next_btn'])) { //For Next Page

$_SESSION['assist_type'] = $_POST['assist_type']; //Getting the Value into Session

if($_SESSION['assist_type'] == "Others") {
header("Location: rfid1.php");
exit();

} else {
header("Location: rfid2.php");
exit();
}

}

?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Bootstrap 5 CDN -->
    <link href="images/<?= $result->site_logo; ?>" rel="icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body style="background: <?=$rgbaBackGround;?>;">

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

    /* Default line */
    .form-control,
    .form-select {
        border: none;
        border-bottom: 2px solid #ccc;
        border-radius: 0;
        box-shadow: none;
        background: transparent;
        transition: border-color 0.3s ease;
    }

    /* Focused (blue) */
    .form-control:focus,
    .form-select:focus {
        border-bottom: 2px solid #1a73e8;
        /* Google Blue */
        box-shadow: none;
        outline: none;
        background: <?=$rgbaColor;
        ?>;
    }

    /* Invalid (red only after submit) */
    .was-validated .form-control:invalid,
    .was-validated .form-select:invalid {
        border-bottom: 2px solid #d93025;
        /* Google Red */
        box-shadow: none;
    }

    /* Error text */
    .invalid-feedback {
        color: #d93025;
        font-size: 0.9rem;
        margin-top: 4px;
    }

    .card.invalid-card {
        box-shadow: 0 0 12px 2px rgba(217, 48, 37, 0.7);
        /* Google Red Glow */
        border: 1px solid #d93025;
    }
    </style>

    <div class="container py-5">
        <div class="row g-3 justify-content-center">

            <!-- Full Image Card -->
            <div class="col-12 col-md-7">
                <div class="card shadow" style="border-radius: 12px; overflow:hidden; background: <?=$rgbaColor;?>;">
                    <img src="images/header3.jpg" alt="IT Support" style="width: 100%; height:20%; object-fit:cover;">
                </div>
            </div>

            <!-- Card 2: Feedback Form -->
            <div class="col-12 col-md-7">
                <div class="card shadow" style="border-radius: 12px; background: <?=$rgbaColor;?>;">
                    <div class="card-header p-0"
                        style="height: 10px; background: <?= $color; ?>; border-radius: 12px 12px 0 0;">
                    </div>

                    <div class="card-body px-4 py-3">
                        <h1 class="text-dark fw-bolder mb-4"
                            style="font-size: 2.3rem; text-align: justify; line-height: 1.4;">
                            IT Support Logs and Feedback Survey
                        </h1>

                        <p class="text-dark mb-4" style="text-align: justify; line-height: 1.6;">
                            This form is intended to record IT-related requests, concerns, and services, as well as
                            to gather feedback from users for monitoring and improvement purposes. Your responses
                            will help the IT Department ensure better support and reliable services.
                        </p>

                        <p class="text-dark mb-4" style="text-align: justify; line-height: 1.6;">
                            All information provided in this form will be used solely for documentation, evaluation,
                            and service improvement. Data collected will be kept confidential and will not be shared
                            with unauthorized individuals. By submitting this form, you acknowledge that the
                            information you provide is accurate to the best of your knowledge.
                        </p>

                        <hr class="mb-3">
                        <p class="text-danger mb-0"><b>* indicates required questions</b></p>
                    </div>
                </div>
            </div>

            <!-- Main Form -->
            <form id="main_form" action="" method="POST" class="col-12 col-md-7 needs-validation" novalidate>
                <!-- Full Name -->
                <div class="card shadow mb-3" style="border-radius: 12px; background: <?=$rgbaColor;?>;">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="fullname" class="form-label fw-bold" style="font-size: 1.2rem;">
                                Full Name: <span class="text-danger">*</span>
                            </label>
                            <input type="text" value="<?=  $_SESSION['fullname']; ?>" class="form-control" id="fullname"
                                name="fullname" style="width: 95%; margin-top: 1%;" disabled>
                            <div class="invalid-feedback">This is a required question</div>
                        </div>
                    </div>
                </div>

                <!-- Student ID / Employee ID -->
                <div class="card shadow mb-3" style="border-radius: 12px; background: <?=$rgbaColor;?>;">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="employee_id" class="form-label fw-bold" style="font-size: 1.2rem;">
                                Student ID / Employee ID: <span class="text-danger">*</span>
                            </label>
                            <input type="text" value="<?= $_SESSION['primary_id']; ?>" class="form-control"
                                id="employee_id" name="employee_id" style="width: 95%; margin-top: 1%;" disabled>
                            <div class="invalid-feedback">This is a required question</div>
                        </div>
                    </div>
                </div>

                <!-- Assistance Type -->
                <div class="card shadow mb-3" style="border-radius: 12px; background: <?=$rgbaColor;?>;">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="assistance" class="form-label fw-bold" style="font-size: 1.2rem;">
                                What type of assistance do you need? <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="assistance" name="assist_type" style="width: 95%;" required>
                                <option value="">-- Choose --</option>
                                <option value="Hardware Issue ( PC, Laptop, Printer, etc )">Hardware Issue ( PC, Laptop,
                                    Printer, etc )</option>
                                <option value="Software / Application Issue">Software / Application Issue</option>
                                <option value="Network / Internet Connectivity">Network / Internet Connectivity</option>
                                <option value="Account / Login Assistance">Account / Login Assistance</option>
                                <option value="Others">Others</option>
                            </select>
                            <div class="invalid-feedback">This is a required question</div>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="text-end">
                    <a href="go_home.php" class="btn px-4 btn-no-border"
                        style="background-color: <?=$rgbaColor;?>; color: <?=$result->site_color;?>; float:left;">
                        Go Home
                    </a>

                    <button type="submit" class="btn px-4" name="next_btn"
                        style="background-color: <?=$color;?>; color: <?=$result->site_text; ?>;">Next</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Right 2-col margin (hidden on xs) -->
    <div class="d-none d-md-block col-md-2"></div>
    </div>
    </div>


    <script>
    (() => {
        'use strict'
        const forms = document.querySelectorAll('.needs-validation')

        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault()
                    event.stopPropagation()
                }
                form.classList.add('was-validated')
            }, false)
        })
    })()
    </script>



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

    <script>
    (() => {
        'use strict';
        const forms = document.querySelectorAll('.needs-validation');

        Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();

                    // hanapin lahat ng invalid inputs
                    const invalidFields = form.querySelectorAll(':invalid');
                    invalidFields.forEach(field => {
                        const card = field.closest('.card'); // hanapin kung nasaang card
                        if (card) card.classList.add('invalid-card'); // lagyan ng shadow
                    });
                }

                form.classList.add('was-validated');
            }, false);
        });
    })();
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>