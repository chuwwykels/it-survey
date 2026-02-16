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



if (isset($_POST['submit_btn'])) { //Submitting the Value to Database

    //Session

$primary_id = $_SESSION['primary_id'];

$queryid = "
    (SELECT stud_id AS id, fullname, 'Student' AS user_type
     FROM student 
     WHERE stud_id = :primary_id)
    UNION
    (SELECT emp_id AS id, fullname, 'Employee' AS user_type
     FROM employee 
     WHERE emp_id = :primary_id)
    LIMIT 1
";

$statementinfo = $conn->prepare($queryid);
$dataid = [
    ':primary_id' => $primary_id
];
$statementinfo->execute($dataid);

$id_info = $statementinfo->fetch(PDO::FETCH_OBJ);

$fullname    = $id_info->fullname;
$assist_type = $_SESSION['assist_type'] ?? null;
$user_type   = $id_info->user_type; // "student" or "employee"

    //Post
    $ratings = $_POST['ratings'];
    $comments = !empty($_POST['comments']) ? $_POST['comments'] : "N/A";
    $method_type  = "Manual";

    date_default_timezone_set("Asia/Manila"); //Philippine Time

    $timestamp = date("Y-m-d H:i:s");


//Executing Audit Trail Command
$query1 = "INSERT INTO survey_result (fullname, primary_id, assist_type, user_type, ratings, comment, method, timestamp) VALUES (:fullname, :primary_id, :assist_type, :user_type, :ratings, :comments, :method_type, :timestamp)";
$query_run = $conn->prepare($query1);


/* Getting The Values */

$data1 = [
    ':fullname' => $fullname,
    ':primary_id' => $primary_id,
    ':assist_type' => $assist_type,
    ':user_type' => $user_type,
    ':ratings' => $ratings,
    ':comments' => $comments,
    ':method_type' => $method_type,
    ':timestamp' => $timestamp,
         ];

  /* Executing the command */
$query_execute = $query_run->execute($data1);

    $id = $conn->lastInsertId(); //Last ID

   if ($query_execute) {
        // ✅ Send to Google Sheets
        $data = [
            'action'     => 'add', // 👈 para malinaw na add
            'id'   => $id,
            'fullname'   => $fullname,
            'primary_id' => $primary_id,
            'assist_type'=> $assist_type,
            'user_type'  => $user_type,
            'ratings'    => $ratings,
            'comments'   => $comments,
            'method_type'   => $method_type
        ];

        $jsonData = json_encode($data);

        $url = "https://script.google.com/macros/s/AKfycbyZtUXUzN-KpP3U93x9n8mDH-I0JW2H9FdKaq5JdQdxoRhkzsoDwMAytAvzNMfjbaAcCw/exec"; // ilagay mo yung Web App URL

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

    $_SESSION['picture_status'] = "$fullname";
    $_SESSION['picture_desc']   = "Thank you for your Response 😊";

   // Check kung may existing picture
    $extensions = ['jpg', 'jpeg', 'png'];
    $pic = "images/No_Pic 2.png"; // default

    foreach ($extensions as $ext) {
        $file = "images/user/" . $primary_id . "." . $ext;
        if (file_exists($file)) {
            $pic = $file;
            break;
        }
    }

    $_SESSION['picture_code'] = $pic; // path sa image

    // Clear Session
    unset($_SESSION['fullname']);
    unset($_SESSION['primary_id']);
    unset($_SESSION['assist_type']);

    header("Location: index.php"); // reload clean
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



    .rating-group {
        display: flex;
        justify-content: space-around;
        align-items: center;
        margin-top: 10px;
    }

    .rating {
        text-align: center;
    }

    .rating input {
        display: none;
    }

    .rating label {
        font-size: 2rem;
        cursor: pointer;
        transition: 0.3s;
    }

    .rating input:checked+label {
        transform: scale(1.3);
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
            <form id="main_form" action="" method="POST" class="col-12 col-md-7 needs-validation" novalidate>
                <div class="card shadow mb-3" style="border-radius: 12px; background: <?=$rgbaColor;?>;">
                    <div class="card-body">
                        <label class="form-label fw-bold" style="font-size: 1.2rem;">
                            How was your experience with the IT support provided? <span class="text-danger">*</span>
                        </label>

                        <div class="rating-group">
                            <div class="rating">
                                <input type="radio" name="ratings" id="exp1" value="Very Dissatisfied" required>
                                <label for="exp1">😡</label><br>
                                <small>Very Dissatisfied</small>
                            </div>
                            <div class="rating">
                                <input type="radio" name="ratings" id="exp2" value="Dissatisfied">
                                <label for="exp2">☹️</label><br>
                                <small>&nbsp;</small>
                            </div>
                            <div class="rating">
                                <input type="radio" name="ratings" id="exp3" value="Neutral">
                                <label for="exp3">😐</label><br>
                                <small>&nbsp;</small>
                            </div>
                            <div class="rating">
                                <input type="radio" name="ratings" id="exp4" value="Satisfied">
                                <label for="exp4">😊</label><br>
                                <small>&nbsp;</small>
                            </div>
                            <div class="rating">
                                <input type="radio" name="ratings" id="exp5" value="Very Satisfied">
                                <label for="exp5">🤩</label><br>
                                <small>Very Satisfied</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Suggestions -->
                <div class="card shadow mb-3" style="border-radius: 12px; background: <?=$rgbaColor;?>;">
                    <div class="card-body">
                        <label for="comments" class="form-label fw-bold" style="font-size: 1.2rem;">
                            Any comments or suggestions?
                        </label>
                        <textarea class="form-control" id="comments" autocomplete="off" name="comments" rows="1"
                            style="width:95%; margin-top:1%;"></textarea>
                    </div>
                </div>

                <!-- Submit -->

                <div class="text-end">
                    <a href="go_back.php" class="btn px-4 btn-no-border"
                        style="background-color: <?=$rgbaColor;?>; color: <?=$result->site_color;?>; float:left;">
                        Go Back
                    </a>

                    <button type="submit" class="btn px-4" name="submit_btn"
                        style="background-color: <?=$color;?>; color: <?=$result->site_text; ?>;">Submit</button>
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
    <?php if(isset($_SESSION['status']) && $_SESSION['status'] !=''){ ?>
    <script>
    swal({
        content: {
            element: "span",
            attributes: {
                innerHTML: "<?php echo 'Thank you for your Response! <b>' . addslashes($fullname) . '</b>'; ?>"
            }
        },
        text: "<?php echo $_SESSION['status_desc'] ?>",
        icon: "<?php echo $_SESSION['status_code']; ?>",
        button: "Okay!",
    });
    </script>
    <?php unset($_SESSION['status']); } ?>


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