<?php
 session_start();

 if(!isset($_SESSION['email']) || $_SESSION['email'] === null){
    header('location: index.php');
}

$page_title = "List of Responses";
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
        <h1 class="h3 mb-0 text-gray-800">Response's List</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dash.php" style="color:<?=$result->site_color; ?>">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">List of Responses</li>
        </ol>
    </div>

    <br>

    <!-- Button trigger modal -->

    <a href="printings/response_print.php" class="btn btn-warning float-right mr-2" role="button">Print
        Reports&nbsp;&nbsp;<i class="fa fa-download"></i> </a>
    <a href="https://docs.google.com/spreadsheets/d/1E5bihaja0OfHkj5L3opXmJagcGIAFGwm5-Ngfox2XV4/edit?gid=0#gid=0"
        class="btn btn-success float-right mr-2" role="button" target="_blank" rel="noopener noreferrer">
        Go to Sheets&nbsp;&nbsp;<i class="fa fa-file"></i>
    </a>


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
                            <th>Fullname</th>
                            <th>Stud / Emp ID</th>
                            <th>User Type</th>
                            <th>Assistance Type</th>
                            <th>Rating</th>
                            <th>Timestamp</th>
                            <th>Actions</th>
                        </tr>

                    </thead>
                    <tbody>
                        <?php

$query = "SELECT * FROM survey_result";
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
                            <td><?= $row->fullname; ?></td>
                            <td><?= $row->primary_id; ?></td>
                            <td><?= $row->user_type; ?></td>
                            <td><?= $row->assist_type; ?></td>
                            <td><?= $row->ratings; ?></td>
                            <td><?= $row->timestamp; ?></td>


                            <td>
                                <a class="btn btn-info" href="viewresponses.php?id=<?=  $row->id; ?>" role="button"><i
                                        class="fa fa-eye"></i></a>
                                <button type="button" class="btn btn-danger "><i
                                        class="far fa-trash-alt responsedelete_btn"></i></button>


                                <!--Delete Modal-->

                                <div class="modal fade" id="responsedelete" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">

                                        <form action="functions/response_function.php" method="POST">

                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel" style="color:black">
                                                        Delete Information :</h5>
                                                    <button class="close" type="button" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">×</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body" style="color:black">Are You Sure to Delete
                                                    This
                                                    Response?</div>
                                                <input type="hidden" name="responsedelete_id" id="responsedelete_id">
                                                <div class="modal-footer">
                                                    <button type="submit" name="response_delete"
                                                        class="btn btn-danger">Delete</button>
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