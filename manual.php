<?php
session_start();

$page_title = "Manual Method Survey ";
include('connection/dbconfig.php');
include('super_admin/includes/header.php');

// clear error kapag unang load (hindi POST)
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    unset($_SESSION['primary_id_error']);
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



if(isset($_POST['next_btn'])) { //For Next Page
    $primary_id = $_POST['primary_id'];

    // Check kung existing sa student or employee
    $query = "SELECT * FROM student WHERE stud_id = :id 
              UNION 
              SELECT * FROM employee WHERE emp_id = :id";
    $stmt = $conn->prepare($query);
    $stmt->execute([':id' => $primary_id]);

    if ($stmt->rowCount() == 0) {
        // walang match → set session error
        $_SESSION['primary_id_error'] = "ID not found in Student or Employee records.";
    } else {
        unset($_SESSION['primary_id_error']);
        $_SESSION['fullname'] = $_POST['fullname'];
        $_SESSION['primary_id'] = $_POST['primary_id']; 
        $_SESSION['assist_type'] = $_POST['assist_type']; 

        if($_SESSION['assist_type'] == "Others") {
            header("Location: manual1.php");
            exit();
        } else {
            header("Location: manual2.php");
            exit();
        }
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
                            <input type="text" class="form-control" id="fullname" autocomplete="off" name="fullname"
                                style="width: 95%; margin-top: 1%;"
                                value="<?= isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : '' ?>"
                                required>
                            <div class="invalid-feedback">This is a required question</div>
                        </div>
                    </div>
                </div>

                <!-- Student ID / Employee ID -->
                <div class="card shadow mb-3 <?= isset($_SESSION['primary_id_error']) ? 'invalid-card' : '' ?>"
                    style="border-radius: 12px; background: <?=$rgbaColor;?>;">
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="primary_id" class="form-label fw-bold" style="font-size: 1.2rem;">
                                Student ID / Employee ID: <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                class="form-control <?= isset($_SESSION['primary_id_error']) ? 'is-invalid' : '' ?>"
                                id="primary_id" name="primary_id" autocomplete="off" style="width: 95%; margin-top: 1%;"
                                value="<?= isset($_POST['primary_id']) ? htmlspecialchars($_POST['primary_id']) : '' ?>"
                                required>

                            <?php if(isset($_SESSION['primary_id_error'])): ?>
                            <div class="invalid-feedback d-block">
                                <?= $_SESSION['primary_id_error']; ?>
                            </div>
                            <?php else: ?>
                            <div class="invalid-feedback">This is a required question</div>
                            <?php endif; ?>
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
                                <option value="Hardware Issue ( PC, Laptop, Printer, etc )"
                                    <?= (isset($_POST['assist_type']) && $_POST['assist_type'] == "Hardware Issue ( PC, Laptop, Printer, etc )") ? 'selected' : '' ?>>
                                    Hardware Issue ( PC, Laptop, Printer, etc )
                                </option>
                                <option value="Software / Application Issue"
                                    <?= (isset($_POST['assist_type']) && $_POST['assist_type'] == "Software / Application Issue") ? 'selected' : '' ?>>
                                    Software / Application Issue
                                </option>
                                <option value="Network / Internet Connectivity"
                                    <?= (isset($_POST['assist_type']) && $_POST['assist_type'] == "Network / Internet Connectivity") ? 'selected' : '' ?>>
                                    Network / Internet Connectivity
                                </option>
                                <option value="Account / Login Assistance"
                                    <?= (isset($_POST['assist_type']) && $_POST['assist_type'] == "Account / Login Assistance") ? 'selected' : '' ?>>
                                    Account / Login Assistance
                                </option>
                                <option value="Others"
                                    <?= (isset($_POST['assist_type']) && $_POST['assist_type'] == "Others") ? 'selected' : '' ?>>
                                    Others
                                </option>
                            </select>
                            <div class="invalid-feedback">This is a required question</div>
                        </div>
                    </div>
                </div>

                <!-- Submit -->
                <div class="text-end">
                    <a href="index.php" class="btn px-4 btn-no-border"
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