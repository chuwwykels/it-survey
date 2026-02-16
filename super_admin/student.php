<?php
 session_start();

 if(!isset($_SESSION['email']) || $_SESSION['email'] === null){
    header('location: index.php');
}

$page_title = "Manage Student";
include('../connection/dbconfig.php');
include('includes/header.php');
include('includes/navbar.php');

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
        <h1 class="h3 mb-0 text-gray-800">Student's List</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dash.php" style="color:<?=$result->site_color; ?>">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">List of Student</li>
        </ol>
    </div>

    <br>

    <!-- Button trigger modal -->

    <a href="printings/adminprint.php" class="btn btn-warning float-right mr-2" role="button">Print
        Reports&nbsp;&nbsp;<i class="fa fa-download"></i> </a>

    <button type="button" class="btn btn-secondary float-right mr-2" data-toggle="modal" data-target="#studbulk">
        Bulk Data Upload <i class="fa fa-upload"> </i>
    </button>

    <button type="button" class="btn btn-primary float-right mr-2" data-toggle="modal" data-target="#studentadd">Add
        Student &nbsp;&nbsp;<i class="fa fa-plus-circle" aria-hidden="true"></i></button>


    <!-- Bulk Modal -->
    <div class="modal fade" id="studbulk" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle" style="color: black;">Upload CSV File Here
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="functions/studbulk.php" method="POST" enctype="multipart/form-data">

                        <div class="custom-file">
                            <input type="file" name="file" required />
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="importSubmit" class="btn"
                        style="color: <?=$result->site_text; ?>; background: <?=$result->site_color; ?>;">Upload
                        Data</button>
                </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Add Modal -->

    <div class="modal fade" id="studentadd" style="margin-top: 1%;" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog" role="document" style="max-width: 35%;">

            <form action="functions/student_function.php" method="POST">

                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle" style="color: black;">Add Student</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">


                        <div class="row">
                            <div class="col">
                                <label>Name <span class="required">*</span></label>
                                <input type="text" name="fullname" value="" autocomplete="off" class="form-control"
                                    placeholder="Enter Student Name" required>
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col">
                                <label>Student ID <span class="required">*</span></label>
                                <input type="number" name="stud_id" value="" autocomplete="off" class="form-control"
                                    placeholder="Enter Student ID" required>
                            </div>
                        </div>

                        <br>

                        <div class="row">
                            <div class="col">
                                <label>Tag RFID <span class="required">*</span></label>
                                <input type="number" name="rfid" value="" autocomplete="off" class="form-control"
                                    placeholder="Please Tap your ID" required>
                            </div>
                        </div>

                        <br>

                        <div class="modal-footer">
                            <button type="submit" name="student_add" class="btn btn-primary">Add
                                Student</button>
                        </div>
                    </div>
                </div>
        </div>

    </div> <!-- Divider -->

    </form>

    <br>

    <br>

    <br>

    <br>

    <!-- DataTable with Hover -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                        <tr>
                            <th hidden>ID</th>
                            <th>Student ID</th>
                            <th>Name</th>
                            <th>RFID</th>
                            <th>Actions</th>
                        </tr>

                    </thead>
                    <tbody>
                        <?php 

$query = "SELECT * FROM student";
$statement = $conn->prepare($query);
$statement->execute();

$statement->setFetchMode(PDO::FETCH_OBJ); //PDO::FETCH_ASSOC
$result = $statement->fetchAll();

if($result)
{

  foreach($result as $row)
  {
  ?>

                        <tr>
                            <td hidden><?= $row->id; ?></td>
                            <td><?= $row->stud_id; ?></td>
                            <td><?= $row->fullname; ?></td>
                            <td><?= $row->rfid; ?></td>

                            <td>
                                <button type="button" class="btn btn-success" data-toggle="modal"
                                    data-target="#studentedit<?=$row->id; ?>"><i class="fas fa-edit"></i></button>
                                <button type="button" class="btn btn-danger "><i
                                        class="far fa-trash-alt studentdelete_btn"></i></button>

                                <!-- Edit Modal -->

                                <div class="modal fade" id="studentedit<?=$row->id; ?>" style="margin-top: 1%;"
                                    tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
                                    aria-hidden="true">
                                    <div class="modal-dialog" role="document" style="max-width: 35%;">

                                        <form action="functions/student_function.php" method="POST">

                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle"
                                                        style="color: black;">Edit Student Info</h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">


                                                    <input type="hidden" name="id" value="<?=  $row->id; ?>"
                                                        class="form-control">


                                    <?php

                                    $student_pic = "../images/user/" . $row->stud_id . ".jpg";

                                    // Check kung may file talaga
                                    if (!file_exists($student_pic)) {
                                        $student_pic = "../images/No_Pic 2.png";

                                    }
                                    ?>

                                                    <div class="row">
                                                        <div class="col">
                                                            <center>
                                                                <img class="img-profile" src="<?= $student_pic; ?>"
                                                                    id="imagePreview" alt="Image Preview"
                                                                    style="position: relative; width: 30%; height: 30%; overflow: hidden;">
                                                            </center>
                                                        </div>
                                                    </div>

                                                    <br>

                                                    <div class="row">
                                                        <div class="col">
                                                            <label>Name <span class="required">*</span></label>
                                                            <input type="text" name="fullname"
                                                                value="<?=  $row->fullname; ?>" autocomplete="off"
                                                                class="form-control" placeholder="Enter Student Name"
                                                                required>
                                                        </div>
                                                    </div>

                                                    <br>

                                                    <div class="row">
                                                        <div class="col">
                                                            <label>Student ID <span class="required">*</span></label>
                                                            <input type="number" name="stud_id"
                                                                value="<?=  $row->stud_id; ?>" autocomplete="off"
                                                                class="form-control" placeholder="Enter Student ID"
                                                                required>
                                                        </div>
                                                    </div>

                                                    <br>

                                                    <div class="row">
                                                        <div class="col">
                                                            <label>Tag RFID <span class="required">*</span></label>
                                                            <input type="number" autocomplete="off" name="rfid"
                                                                value="<?=  $row->rfid; ?>" class="form-control"
                                                                placeholder="Please Tap your ID" required>
                                                        </div>
                                                    </div>

                                                </div>

                                                <br>

                                                <div class="modal-footer">
                                                    <button type="submit" name="student_edit"
                                                        class="btn btn-success">Save
                                                        Changes</button>
                                                </div>
                                            </div>

                                        </form>
                                    </div>
                                </div>

            </div> <!-- Divider -->

            <!--Delete Modal-->

            <div class="modal fade" id="studentdelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">

                    <form action="functions/student_function.php" method="POST">

                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel" style="color:black">
                                    Delete Information :</h5>
                                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                            <div class="modal-body" style="color:black">Are You Sure to Delete
                                This
                                Student?</div>
                            <input type="hidden" name="studentdelete_id" id="studentdelete_id">
                            <div class="modal-footer">
                                <button type="submit" name="student_delete" class="btn btn-danger">Delete</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


            </td>
            </tr>



            <?php
  }

}
else
{
 
  ?>
            <tr>
                <td colspan="6">No record found!</td>
            </tr>
            <?php

}

?>


            </tbody>
            </table>
        </div>
    </div>
</div>
</div>

<!--Row-->

<!-- Scroll to top -->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>








<?php

include('includes/scripts.php');
include('includes/footer.php');

?>