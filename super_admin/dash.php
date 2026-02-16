<?php
 session_start();


if(!isset($_SESSION['email']) || $_SESSION['email'] === null){
    header('location: index.php');
}

$page_title = "Dashboard";
include('../connection/dbconfig.php');
include('includes/header.php');
include('includes/navbar.php');

?>



<div class="loader"></div>


<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper" style="overflow-y: scroll; height: 82vh;">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dash.php">&nbsp;</a></li>

        </ol>
    </div>
    

    <div class="row mb-3">
        <!-- Employee Count Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: <?=$result->site_color2; ?>">Employee's</div>
                            <div class="h4 mb-0 font-weight-bold" style="color: <?=$result->site_color2; ?>">

                                <?php 

              $con = new PDO('mysql:host=localhost;dbname=itsurveydb','root','');
              
              function rowCount2($con,$query){
                  $statement = $con->prepare($query);
                  $statement->execute();
                  return $statement->rowCount();
              }

              ?>

                                <?php echo rowCount2($con,"SELECT * FROM employee");?></div>

                            <div class="mt-2 mb-0 text-muted text-xs">

                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user-shield fa-2x" style="color: <?= $result->site_color; ?>;"></i>
                        </div>
                    </div>
                    <hr>
                    <a class="small text-blue stretched-link" href="employee.php">View Details&nbsp; ></a>
                </div>
            </div>
        </div>

        <!-- Earnings (Annual) Card Example -->
        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: <?= $result->site_color2; ?>;">Students's</div>
                            <div class="h4 mb-0 font-weight-bold" style="color: <?= $result->site_color2; ?>;">

                                <?php 

                                              $con = new PDO('mysql:host=localhost;dbname=itsurveydb','root','');
                                              
                                              function rowCount3($con,$query){
                                                  $statement = $con->prepare($query);
                                                  $statement->execute();
                                                  return $statement->rowCount();
                                              }
  
                                              ?>


                                <?php echo rowCount3($con,"SELECT * FROM student");?></div>

                            <div class="mt-2 mb-0 text-muted text-xs">

                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-user fa-2x" style="color: <?= $result->site_color; ?>;"></i>
                        </div>
                    </div>
                    <hr>
                    <a class="small text-blue stretched-link" href="student.php">View Details&nbsp; ></a>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-md-6 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1" style="color: <?= $result->site_color2; ?>;">Go To Audit Trails</div>
                            <div class="h4 mb-0 font-weight-bold" style="color: <?= $result->site_color2; ?>;">


                            🖤</div>

                            <div class="mt-2 mb-0 text-muted text-xs">

                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-list fa-2x" style="color: <?= $result->site_color; ?>;"></i>
                        </div>
                    </div>
                    <hr>
                    <a class="small text-blue stretched-link" href="auditlogs.php">View Audits&nbsp; ></a>
                </div>
            </div>
        </div>

        <!-- Area Chart -->
        <div class="col-xl-4 col-lg-7">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold" style="color:<?=$result->site_color; ?>">Number of Users</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">View Tables:</div>
                            <a class="dropdown-item" href="employee.php">Employee's</a>
                            <a class="dropdown-item" href="student.php">Student's</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="myPieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle" style="color:<?=$result->site_color2; ?>"></i> Employee's
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle" style="color:<?=$result->site_color; ?>"></i> Student's
                        </span>
                        <br>
                    </div>
                </div>
            </div>
        </div>

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold" style="color:<?=$result->site_color; ?>">Recent Activities</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <a class="dropdown-item" href="auditlogs.php">View All</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">

                        <table class="table" id="datatable" data-filter-control="true" width="100%" cellspacing="0"
                            style="margin-top: 2%; margin-bottom: 3%;">
                            <thread>

                            </thread>
                            <?php

        $user = $_SESSION["email"];
        $i = 1;

        $query = "SELECT * FROM auditlogs WHERE email=:user ORDER BY no DESC LIMIT 5";
        $statement = $conn->prepare($query);

        $data = [

            ':user' => $user

        ];





        $statement->execute($data);

        $statement->setFetchMode(PDO::FETCH_OBJ);
        $result1 = $statement->fetchAll(); //this is fetch mode option 2 --->  PDO::FETCH_ASSOC  $row['fullname];


        if($result1)
        {

        foreach($result1 as $row)
        { 

        ?>

                            <tr>
                                <td style="border: white; text-align: left; vertical-align: middle;">
                                    <?= $row->action; ?>
                                </td>
                                <td style="border: white; text-align: center; vertical-align: middle;"><button
                                        type="button"
                                        style="border: none; background:<?= $result->site_color; ?>; color:<?= $result->site_text; ?>; pointer-events: none;"
                                        class="btn btn-info btn-sm"><?= $row->date; ?> <?= $row->time; ?></button></td>

                            </tr>





                            <?php
        }

        }
        else
        {

        ?>
                            <tr>
                                <td colspan="6">No Recent Activity found!</td>
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





        <!-- For Footer -->
    </div>
</div>

<!-- Scroll to top -->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>


<?php

include('includes/scripts.php');
include('includes/footer.php');

?>