 <?php

include('../connection/dbconfig.php');

//For Site Setting
$query = "SELECT * FROM system LIMIT 1";
$statement = $conn->prepare($query);
$statement->execute();

$result = $statement->fetch(PDO::FETCH_OBJ);

$id = 1;

//For Super Admin
$query = "SELECT * FROM superadmin WHERE id=:id LIMIT 1";
$statement = $conn->prepare($query);
$data = [

    ':id' => $id

 ];

$statement->execute($data);

$result1 = $statement->fetch(PDO::FETCH_OBJ);

?>

 <!-- Sidebar -->
 <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
     <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dash.php"
         style="background: <?= $result->site_color2; ?>">
         <div class="sidebar-brand-icon">
             <img src="../images/<?= $result->site_logo; ?>">
         </div>
         <div class="sidebar-brand-text mx-3" style="color: <?= $result->site_text; ?>"><?= $result->site_name; ?></div>
     </a>
     <hr class="sidebar-divider my-0">
     <li class="nav-item active">
         <a class="nav-link" href="dash.php" style="color: black;">
             <i class="fas fa-fw fa-tachometer-alt" style="color: black;"></i>
             <span>Dashboard</span></a>
     </li>
     <hr class="sidebar-divider" style="border-color: black; margin-left: 10px; margin-right: 10px;">
     <div class="sidebar-heading" style="color: black;">
         Services
     </div>
     <li class="nav-item">
         <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap"
             aria-expanded="true" aria-controls="collapseBootstrap">
             <i class="far fa-fw fa-edit" style="color: black;"></i>
             <span style="color: black;">Manage User's</span>
         </a>
         <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap"
             data-parent="#accordionSidebar">
             <div class="bg-white py-2 collapse-inner rounded">
                 <h6 class="collapse-header">Account</h6>
                 <a class="collapse-item" href="employee.php">Employee's</a>
                 <a class="collapse-item" href="student.php">Student's</a>
             </div>
         </div>
     </li>
     <li class="nav-item">
         <a class="nav-link" href="responses.php">
             <i class="fas fa-fw fa-chart-bar" style="color: black;"></i>
             <span style="color: black;">View Responses</span>
         </a>
     </li>
     <li class="nav-item">
         <a class="nav-link" href="site_setting.php">
             <i class="fas fa-fw fa-wrench" style="color: black;"></i>
             <span style="color: black;">Site Settings</span>
         </a>
     </li>


 </ul>

 <!-- Sidebar -->
 <div id="content-wrapper" class="d-flex flex-column">

     <!-- Modal Logout -->
     <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
         aria-hidden="true">
         <div class="modal-dialog" role="document">
             <div class="modal-content">
                 <div class="modal-header">
                     <h5 class="modal-title" id="exampleModalLabelLogout" style="color: black;"><i
                             class="fas fa-fw fa-sign-out-alt"></i> Logout</h5>
                     <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                         <span aria-hidden="true">&times;</span>
                     </button>
                 </div>
                 <div class="modal-body">
                     <p style="color: black;">Are you sure you want to logout?</p>
                 </div>
                 <div class="modal-footer">
                     <button type="button" class="btn btn-outline-dark" data-dismiss="modal">Cancel</button>
                     <a href="logout.php" class="btn btn-dark">Logout</a>
                 </div>
             </div>
         </div>
     </div>


     <div id="content">
         <!-- TopBar -->
         <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top"
             style="background: <?= $result->site_color; ?>;">
             <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3"
                 style="color:<?= $result->site_text; ?>">
                 <i class="fa fa-bars"></i>
             </button>

     <ul class="navbar-nav ml-auto">

         <div class="topbar-divider d-none d-sm-block" style="border-color: <?= $result->site_text; ?>"></div>
         <li class="nav-item dropdown no-arrow">
             <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                 aria-haspopup="true" aria-expanded="false">
                 <img class="img-profile rounded-circle" src="../images/<?= $result1->image ?>" style="max-width: 60px">
                 <span class="ml-2 d-none d-lg-inline small"
                     style="color: <?= $result->site_text; ?>"><?= $result1->fullname ?></span>
             </a>
             <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                 <a class="dropdown-item" href="profile.php">
                     <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                     Profile
                 </a>

                 <a class="dropdown-item" href="auditlogs.php">
                     <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                     Audit Trails
                 </a>
                 <div class="dropdown-divider"></div>
                 <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal">
                     <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                     Logout
                 </a>
             </div>
         </li>
     </ul>
     </nav>
     
     <!-- Topbar -->