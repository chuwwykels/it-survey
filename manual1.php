<?php
session_start();


  if(!isset($_SESSION['primary_id']) || $_SESSION['primary_id'] === null){
    header('location: index.php');
}

$page_title = "Manual Method Survey Step 2 ";
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

$_SESSION['assist_type'] = $_POST['others']; //Getting the Value into Session

header("Location: manual2.php");
exit();

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

                        <hr class="mb-3">
                        <p class="text-danger mb-0"><b>* indicates required questions</b></p>
                    </div>
                </div>
            </div>

            <!-- Main Form -->
            <form id="main_form" action="" method="POST"
                class="col-12 col-md-7 needs-validation" novalidate>
                <!-- Full Name -->
                <div class="card shadow mb-3" style="border-radius: 12px; background: <?=$rgbaColor;?>;">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="others" class="form-label fw-bold" style="font-size: 1.2rem;">
                                If Others, please specify: <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control"  autocomplete="off" id="others" name="others"
                                style="width: 95%; margin-top: 1%;" required>
                            <div class="invalid-feedback">This is a required question</div>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="text-end">
                    <a href="manual.php" class="btn px-4 btn-no-border"
                        style="background-color: <?=$rgbaColor;?>; color: <?=$result->site_color;?>; float:left;">
                        Go Back
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
        text: "<?php echo $_SESSION['status_desc'] ?>",
        icon: "<?php echo $_SESSION['status_code']; ?>",
        button: "Okay!",
    });
    </script>
    <?php
          unset($_SESSION['status']);
      }
      
    ?>


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