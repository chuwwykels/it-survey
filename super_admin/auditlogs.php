<?php
 session_start();

 if(!isset($_SESSION['email']) || $_SESSION['email'] === null){
    header('location: index.php');
}

$page_title = "Audit Trail's";
include('../connection/dbconfig.php');
include('includes/header.php');
include('includes/navbar.php');

?>


<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper" style="overflow-y: scroll; height: 82vh;">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Audit Trails</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dash.php" style="color:<?=$result->site_color; ?>">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Audit Trail</li>
        </ol>
    </div>

    <!-- DataTable with Hover -->
    <div class="col-lg-12">
        <div class="card mb-4">
            <div class="table-responsive p-3">
                <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                    <thead class="thead-light">
                        <tr>
                            <th>Name</th>
                            <th>Date and Time</th>
                            <th>Email</th>
                            <th>Access Level</th>
                            <th>Action</th>
                        </tr>

                    </thead>
                    <tbody>
                        <?php

$query = "SELECT * FROM auditlogs INNER JOIN superadmin ON auditlogs.email = superadmin.email";
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
                            <td><?= $row->fullname; ?></td>
                            <td><?= $row->date; ?> <?= $row->time; ?></td>
                            <td><?= $row->email; ?></td>
                            <td><?= $row->access_level; ?></td>
                            <td><?= $row->action; ?></td>
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