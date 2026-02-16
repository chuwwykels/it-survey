<?php
session_start();

if (!isset($_SESSION['primary_id']) || $_SESSION['primary_id'] === null) {
    header('location: index.php');
    exit();
}

$page_title = "RFID Method Survey";
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



if (isset($_POST['submit_btn'])) { // Submitting the Value to Database

    // Session
    $fullname   = $_SESSION['fullname'];
    $primary_id = $_SESSION['primary_id'];
    $user_type  = $_SESSION['user_type'];

    // POST
    $assist_type = $_POST['assist_type'];
    if ($assist_type == "Others") {
        $assist_type = $_POST['other_assist'];
    }

    $method_type = "RFID";
    $ratings     = $_POST['ratings'];
    $comments    = !empty($_POST['comments']) ? $_POST['comments'] : "N/A";

    // DateStamp
    date_default_timezone_set("Asia/Manila"); // Philippine Time
    $timestamp = date("Y-m-d H:i:s");

    // Executing Audit Trail Command
    $query1 = "INSERT INTO survey_result 
        (fullname, primary_id, assist_type, user_type, ratings, comment, method, timestamp) 
        VALUES (:fullname, :primary_id, :assist_type, :user_type, :ratings, :comments, :method_type, :timestamp)";
    
    $query_run = $conn->prepare($query1);

    // Getting The Values
    $data1 = [
        ':fullname'    => $fullname,
        ':primary_id'  => $primary_id,
        ':assist_type' => $assist_type,
        ':user_type'   => $user_type,
        ':ratings'     => $ratings,
        ':comments'    => $comments,
        ':method_type' => $method_type, // ✅ Fixed missing colon
        ':timestamp'   => $timestamp,
    ];

    // Executing the command
    $query_execute = $query_run->execute($data1);
    $id = $conn->lastInsertId();  // Last ID increment in database

    if ($query_execute) {
        // ✅ Send to Google Sheets
        $data = [
            'action'      => 'add', // 👈 malinaw na add
            'id'          => $id,
            'fullname'    => $fullname,
            'primary_id'  => $primary_id,
            'assist_type' => $assist_type,
            'user_type'   => $user_type,
            'ratings'     => $ratings,
            'comments'    => $comments,
            'method_type' => $method_type
        ];

        $jsonData = json_encode($data);

        $url = "https://script.google.com/macros/s/AKfycbyZtUXUzN-KpP3U93x9n8mDH-I0JW2H9FdKaq5JdQdxoRhkzsoDwMAytAvzNMfjbaAcCw/exec"; 

        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo 'Curl error: ' . curl_error($ch);
        } else {
            echo 'Google Script Response: ' . $response;
        }

        curl_close($ch);

        // ✅ Session status
        $_SESSION['status']      = "Thank you for your Response!";
        $_SESSION['status_desc'] = "Your Response has been Submitted Successfully";
        $_SESSION['status_code'] = "success";

        // Clear Session
        unset($_SESSION['fullname']);
        unset($_SESSION['primary_id']);
        unset($_SESSION['user_type']);
        unset($_SESSION['assist_type']);

        // ✅ Redirect after success
        header("Location: index.php");
        exit();
    } else {
        // ❌ If query failed
        $_SESSION['status']      = "Error!";
        $_SESSION['status_desc'] = "Something went wrong while submitting your response.";
        $_SESSION['status_code'] = "error";

        header("Location: index.php");
        exit();
    }
}



?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link href="images/<?= $result->site_logo; ?>" rel="icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <title><?= $page_title; ?></title>

    <style>
    body {
        background: <?=$rgbaBackGround ?>;
        font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
    }

    .info-card {
        border-radius: 1rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .info-card .card-header {
        font-size: 1.1rem;
        font-weight: 600;
        padding: 0.8rem 1rem;
    }

    .form-label {
        font-size: 0.95rem;
        font-weight: 500;
        color: #212529;
        margin-bottom: 0.4rem;
    }

    .info-card .form-control,
    .info-card textarea,
    .info-card .form-select {
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 0.5rem;
    }

    .rating-group {
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        margin-top: 10px;
    }

    .rating {
        text-align: center;
        flex: 1;
    }

    .rating input[type="radio"] {
        display: none;
    }

    .rating label {
        font-size: 2.5rem;
        cursor: pointer;
        transition: transform 0.2s, filter 0.2s;
    }

    .rating label:hover {
        transform: scale(1.15);
        filter: brightness(1.1);
    }

    .rating input[type="radio"]:checked+label {
        transform: scale(1.3);
        filter: brightness(1.2);
    }

    .disclaimer-box {
        background: #f8f9fa;
        border-left: 4px solid <?=$color2 ?>;
        padding: 1rem;
        font-size: 0.9rem;
        border-radius: 0.5rem;
        color: #495057;
    }

    .required-note {
        font-size: 0.85rem;
        color: red;
    }

    /* Para ma-hide muna yung "Others" input */
    #otherInput {
        display: none;
    }

    /* kapag yung form may .was-validated at merong invalid input */
    .was-validated .card:has(:invalid) {
        border: 2px solid red !important;
    }
    </style>
</head>

<body>

    <div class="container-fluid py-5" style="width: 90%;">
        <div class="row justify-content-center g-4">

            <!-- Left Side: User Picture -->
            <div class="col-12 col-md-4 col-lg-3">
                <div class="card shadow-lg text-center rounded-3">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center">
                        <img src="images/user/<?= $_SESSION['primary_id']; ?>.jpg" alt="User Photo"
                            class="img-fluid rounded mb-3" style="height:150px; width:150px; object-fit: cover;">
                        <h5 class="m-3 text-center fw-bold text-dark"><?= $_SESSION['fullname']; ?></h5>
                        <h6 class=" text-center text-muted fw-bolder "><?= $_SESSION['primary_id']; ?></small>
                        </h6>

                        <hr class="w-100">

                        <h6 class="fw-bold" style="color: <?= $color; ?>; "><?= $_SESSION['user_type']; ?></h6>
                    </div>
                </div>
            </div>

            <!-- Right Side: Survey Information -->
            <form action="" method="POST" class="col-12 col-md-8 col-lg-9 needs-validation" novalidate>
                <div class="card info-card">
                    <div class="card-header text-light text-center"
                        style="background: <?= $color; ?>; font-size: 1.5rem; margin-bottom: 1%;">
                        IT Support Logs and Feedback Survey Form
                    </div>
                    <div class="card-body">

                        <div class="disclaimer-box text-dark" style="margin-bottom: 1%;">
                            <p>
                                This form is intended to record IT-related requests, concerns, and services, as well
                                as
                                to gather
                                feedback from users for monitoring and improvement purposes. Your responses will
                                help
                                the IT Department
                                ensure better support and reliable services.
                            </p>
                            <p>
                                All information provided in this form will be used solely for documentation,
                                evaluation,
                                and service
                                improvement. Data collected will be kept confidential and will not be shared with
                                unauthorized
                                individuals. By submitting this form, you acknowledge that the information you
                                provide
                                is accurate to
                                the best of your knowledge.
                            </p>
                        </div>

                        <p class="required-note">
                            * indicates required questions
                        </p>

                        <hr>

                        <!--    <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="<?= $_SESSION['fullname']; ?>" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Student / Employee ID <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" value="<?= $_SESSION['primary_id']; ?>"
                                    readonly>
                            </div>
                        </div>   -->

                        <!-- Assistance -->
                        <div class="row mb-4">
                            <div class="col-md-7">
                                <label for="assistance" class="form-label">
                                    What type of assistance do you need? <span class="text-danger">*</span>
                                </label>
                                <select class="form-select" id="assistance" name="assist_type" required>
                                    <option value="" hidden>-- Choose --</option>
                                    <option value="Hardware Issue ( PC, Laptop, Printer, etc )">Hardware Issue ( PC,
                                        Laptop, Printer, etc )</option>
                                    <option value="Software / Application Issue">Software / Application Issue</option>
                                    <option value="Network / Internet Connectivity">Network / Internet Connectivity
                                    </option>
                                    <option value="Account / Login Assistance">Account / Login Assistance</option>
                                    <option value="Others">Others</option>
                                </select>
                                <div class="invalid-feedback">
                                    This field is required.
                                </div>
                            </div>



                            <div class="col-md-5" id="otherInput">
                                <label class="form-label">If Others, please specify: <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" autocomplete="off" name="other_assist">
                            </div>
                        </div>


                        <!-- Ratings -->
                        <div class="col-md-12 mb-4">
                            <label class="form-label">
                                Overall, how satisfied are you with the IT support provided? <span
                                    class="text-danger">*</span>
                            </label>

                            <div class="rating-group">
                                <div class="rating">
                                    <input type="radio" name="ratings" id="exp1" value="Very Dissatisfied" required>
                                    <label for="exp1">😡</label>
                                    <div><small>Very Dissatisfied</small></div>
                                </div>
                                <div class="rating">
                                    <input type="radio" name="ratings" id="exp2" value="Dissatisfied">
                                    <label for="exp2">☹️</label>
                                    <div><small>Dissatisfied</small></div>
                                </div>
                                <div class="rating">
                                    <input type="radio" name="ratings" id="exp3" value="Neutral">
                                    <label for="exp3">😐</label>
                                    <div><small>Neutral</small></div>
                                </div>
                                <div class="rating">
                                    <input type="radio" name="ratings" id="exp4" value="Satisfied">
                                    <label for="exp4">😊</label>
                                    <div><small>Satisfied</small></div>
                                </div>
                                <div class="rating">
                                    <input type="radio" name="ratings" id="exp5" value="Very Satisfied">
                                    <label for="exp5">🤩</label>
                                    <div><small>Very Satisfied</small></div>
                                </div>
                            </div>
                            <div class="invalid-feedback">
                                Please select a rating.
                            </div>
                        </div>

                        <!-- Remarks -->
                        <div class="mb-4">
                            <label class="form-label">Any comments or suggestions?</label>
                            <textarea class="form-control" name="comments" rows="3"></textarea>
                        </div>

                    </div>
                </div>

                <br>

                <!-- Submit -->
                <div class="text-end">
                    <a href="go_home.php" class="btn px-4 btn-no-border"
                        style="background-color:<?=$rgbaColor;?>; color: <?=$result->site_color;?>; float:left;">
                        Go Home
                    </a>

                    <button type="submit" class="btn px-4" name="submit_btn"
                        style="background-color:<?=$color;?>; color: <?=$result->site_text; ?>;">Submit</button>
                </div>
            </form>

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

            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
            <script>
            const assistanceSelect = document.getElementById("assistance");
            const otherInput = document.getElementById("otherInput");

            assistanceSelect.addEventListener("change", function() {
                if (this.value === "Others") {
                    otherInput.style.display = "block";
                    otherInput.querySelector("input").setAttribute("required", "true");
                } else {
                    otherInput.style.display = "none";
                    otherInput.querySelector("input").removeAttribute("required");
                    otherInput.querySelector("input").value = "";
                }
            });
            </script>
</body>

</html>