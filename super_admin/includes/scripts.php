<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="../js/ruang-admin.min.js"></script>
<script src="../vendor/chart.js/Chart.min.js"></script>
<script src="../js/demo/chart-area-demo.js"></script>


<!-- Delete Employee scripts -->

<script>
$(document).ready(function() {
    $('.employeedelete_btn').on('click', function() {

        $('#employeedelete').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();

        console.log(data);

        $('#employeedelete_id').val(data[0]);

    });
});
</script>


<!-- Delete Student scripts -->

<script>
$(document).ready(function() {
    $('.studentdelete_btn').on('click', function() {

        $('#studentdelete').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();

        console.log(data);

        $('#studentdelete_id').val(data[0]);

    });
});
</script>



<!-- Delete Response scripts -->

<script>
$(document).ready(function() {
    $('.responsedelete_btn').on('click', function() {

        $('#responsedelete').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();

        console.log(data);

        $('#responsedelete_id').val(data[0]);

    });
});
</script>






<!-- Delete Position scripts -->

<script>
$(document).ready(function() {
    $('.positiondelete_btn').on('click', function() {

        $('#positiondelete').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();

        console.log(data);

        $('#positiondelete_id').val(data[0]);

    });
});
</script>

<!-- Delete Owner scripts -->

<script>
$(document).ready(function() {
    $('.staffdelete_btn').on('click', function() {

        $('#staffdelete').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();

        console.log(data);

        $('#staffdelete_email').val(data[1]);

    });
});
</script>

<!-- Delete Stall scripts -->

<script>
$(document).ready(function() {
    $('.stalldelete_btn').on('click', function() {

        $('#stalldelete').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();

        console.log(data);

        $('#stalldelete_id').val(data[0]);

    });
});
</script>

<!-- Delete Message scripts -->

<script>
$(document).ready(function() {
    $('.messagedelete_btn').on('click', function() {

        $('#messagedelete').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();

        console.log(data);

        $('#messagedelete_id').val(data[0]);

    });
});
</script>

<!-- Delete Supplier scripts -->

<script>
$(document).ready(function() {
    $('.supplierdelete_btn').on('click', function() {

        $('#supplierdelete').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();

        console.log(data);

        $('#supplierdelete_email').val(data[1]);

    });
});
</script>

<!-- Delete Category scripts -->

<script>
$(document).ready(function() {
    $('.categorydelete_btn').on('click', function() {

        $('#categorydelete').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();

        console.log(data);

        $('#categorydelete_id').val(data[0]);

    });
});
</script>


<!-- Delete Products scripts -->

<script>
$(document).ready(function() {
    $('.productdelete_btn').on('click', function() {

        $('#productdelete').modal('show');

        $tr = $(this).closest('tr');

        var data = $tr.children("td").map(function() {
            return $(this).text();
        }).get();

        console.log(data);

        $('#productdelete_id').val(data[0]);

    });
});
</script>



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








<!-- Changing Image -->
<script>
function previewImage(event) {
    var input = event.target;
    var preview = document.getElementById('imagePreview');

    var reader = new FileReader();
    reader.onload = function() {
        preview.src = reader.result;
    };
    reader.readAsDataURL(input.files[0]);
}
</script>







<!-- Sweet Alert -->
<script src="../assets//js/sweetalert.min.js"></script>
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
<script src="../assets//js/sweetalert.min.js"></script>
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






<!-- Page level plugins -->
<script src="../vendor/datatables/jquery.dataTables.min.js"></script>
<script src="../vendor/datatables/dataTables.bootstrap4.min.js"></script>

<!-- Page level custom scripts -->
<script>
$(document).ready(function() {
    $('#dataTableHover').DataTable(); // ID From dataTable with Hover
});
</script>




<!-- Changing Image -->
<script>
function previewImage(event) {
    var input = event.target;
    var preview = document.getElementById('imagePreview');

    var reader = new FileReader();
    reader.onload = function() {
        preview.src = reader.result;
    };
    reader.readAsDataURL(input.files[0]);
}
</script>




<!-- Eye Toggler -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const eyeIcon = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    eyeIcon.addEventListener('click', function() {
        const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passwordInput.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });
});
</script>






<!-- MY DOUGHNUT Chart -->

<?php
$query1 = "SELECT COUNT(*) as count FROM employee";
$result = $conn->query($query1);
$row1 = $result->fetch(PDO::FETCH_ASSOC);
$count = $row1['count'];
?>

<?php
$query1 = "SELECT COUNT(*) as count FROM student";
$result = $conn->query($query1);
$row2 = $result->fetch(PDO::FETCH_ASSOC);
$count2 = $row2['count'];
?>

<!-- Site Settings -->
<?php
$query = "SELECT * FROM system LIMIT 1";
$statement = $conn->prepare($query);
$statement->execute();
$site = $statement->fetch(PDO::FETCH_OBJ);

$hexColor = $site->site_color;
$hexColor2 = $site->site_color2;
$opacity = 0.85; // Set your desired opacity value

// Convert hex to rgba
list($r, $g, $b) = sscanf($hexColor, "#%02x%02x%02x");
$rgbaColor = "rgba($r, $g, $b, $opacity)";

list($r, $g, $b) = sscanf($hexColor2, "#%02x%02x%02x");
$rgbaColor2 = "rgba($r, $g, $b, $opacity)";
?>

<script>
var ctx = document.getElementById("myPieChart");


var myPieChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: [ "Student's", "Employee's"],
        datasets: [{

            data: [ <?php echo $count2; ?>, <?php echo $count; ?>],
            backgroundColor: ['<?php echo $site->site_color; ?>', '<?php echo $site->site_color2; ?>'],
            hoverBackgroundColor: ['<?php echo $rgbaColor; ?>', '<?php echo $rgbaColor2; ?>'],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
        }],
    },
    options: {
        maintainAspectRatio: false,
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
        },
        legend: {
            display: false
        },
        cutoutPercentage: 75,
    },
});
</script>