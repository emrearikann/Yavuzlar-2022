<?php
include("./loggedControl.php");
include("./database.php");

try {
   if (isset($_POST["ch-name"]) && trim($_POST["ch-name"]) != "") {
      $changeName = $_POST["ch-name"];

      $cn = $db->prepare("UPDATE homepage SET name='$changeName' WHERE id=1");
      $cn->execute(array());
      $results = $cn->fetchAll();
      header("Location: homepage.php");
      exit();
   }
   if (isset($_POST["ch-welcome"]) && trim($_POST["ch-welcome"]) != "") {
      $changeWelcome = $_POST["ch-welcome"];

      $cn = $db->prepare("UPDATE homepage SET welcome='$changeWelcome' WHERE id=1");
      $cn->execute(array());
      $results = $cn->fetchAll();
      header("Location: homepage.php");
      exit();
   }
   if (isset($_POST["ch-endeavors"]) && trim($_POST["ch-endeavors"]) != "") {
      $changeEndeavors = $_POST["ch-endeavors"];

      $cn = $db->prepare("UPDATE homepage SET endeavors='$changeEndeavors' WHERE id=1");
      $cn->execute(array());
      $results = $cn->fetchAll();
      header("Location: homepage.php");
      exit();
   }
   if (isset($_POST["ch-image"]) && trim($_POST["ch-image"]) != "") {
      $changeImage = $_POST["ch-image"];

      $cn = $db->prepare("UPDATE homepage SET homeCover='$changeImage' WHERE id=1");
      $cn->execute(array());
      $results = $cn->fetchAll();
      header("Location: homepage.php");
      exit();
   }
} catch (PDOException $e) {
   echo $e;
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
   <meta name="description" content="" />
   <meta name="author" content="" />
   <title>Dashboard - SB Admin</title>
   <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
   <link href="css/styles.css" rel="stylesheet" />
   <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

   <!-- include libraries(jQuery, bootstrap) -->
   <link href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">

   <!-- include summernote css/js -->
   <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

   <style>
      .custom-file-input::-webkit-file-upload-button {
         visibility: hidden;
      }

      .custom-file-input::before {
         content: 'Select some files';
         display: inline-block;
         background: linear-gradient(top, #f9f9f9, #e3e3e3);
         border: 1px solid #999;
         border-radius: 3px;
         padding: 5px 8px;
         outline: none;
         white-space: nowrap;
         -webkit-user-select: none;
         cursor: pointer;
         text-shadow: 1px 1px #fff;
         font-weight: 700;
         font-size: 10pt;
      }

      .custom-file-input:hover::before {
         border-color: black;
      }

      .custom-file-input:active::before {
         background: -webkit-linear-gradient(top, #e3e3e3, #f9f9f9);
      }
   </style>
</head>

<body class="sb-nav-fixed">
   <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
      <!-- Navbar Brand-->
      <a class="navbar-brand ps-3" href="admin.php">Moderation Area</a>
      <!-- Sidebar Toggle-->
      <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>
      <!-- Navbar Search-->
      <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
         <div style="position: relative; display: flex; flex-wrap: wrap; align-items: stretch; width: 100%;">
            <input class="form-control" type="text" placeholder="Search for..." aria-label="Search for..." aria-describedby="btnNavbarSearch" />
            <button class="btn btn-primary" id="btnNavbarSearch" type="button"><i class="fas fa-search"></i></button>
         </div>
      </form>
      <!-- Navbar-->
      <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
         <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
               <li><a class="dropdown-item" href="settings.php">Settings</a></li>
               <!-- <li><a class="dropdown-item" href="#!">Activity Log</a></li> -->
               <li>
                  <hr class="dropdown-divider" />
               </li>
               <li><a class="dropdown-item" href="./logout.php">Logout</a></li>
            </ul>
         </li>
      </ul>
   </nav>
   <div id="layoutSidenav">
      <div id="layoutSidenav_nav">
         <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
               <div class="nav">
                  <div class="sb-sidenav-menu-heading">Core</div>
                  <a class="nav-link" href="admin.php">
                     <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                     Dashboard
                  </a>
                  <a class="nav-link" href="settings.php">
                     <div class="sb-nav-link-icon"><i class="fa-solid fa-gear"></i></div>
                     Settings
                  </a>
                  <a class="nav-link" href="homepage.php">
                     <div class="sb-nav-link-icon"><i class="fa-solid fa-house-user"></i></div>
                     Homepage Preferences
                  </a>
                  <a class="nav-link" href="contact-form.php">
                     <div class="sb-nav-link-icon"><i class="fa-solid fa-message"></i></div>
                     Messages
                  </a>
               </div>
            </div>
            <div class="sb-sidenav-footer">
               <div class="small">Logged in as:</div>
               <?php
               echo $_SESSION["username"];
               ?>
            </div>
         </nav>
      </div>
      <div id="layoutSidenav_content">
         <main>
            <div class="container-fluid px-4">
               <h1 class="mt-4">Homepage Preferences</h1>
               <ol class="breadcrumb mb-4">
                  <li class="breadcrumb-item active">Homepage</li>
               </ol>
               <div class="categories">
                  <form method="POST">
                     <?php
                     $data = $db->prepare("SELECT * FROM homepage");
                     $data->execute(array());
                     $results = $data->fetchAll();
                     ?>
                     <div class="row" style="display: flex;">
                        <?php
                        foreach ($results as $result) {
                        }
                        ?>
                        <div class="col-xl-3 col-md-6">
                           <div class="card bg-warning text-white mb-4" style="display: flex;">
                              <div class="card-body" style="height: 12.5rem;">
                                 <h4 style="color: black;"><b>Change Homepage Icon</b></h4>
                                 <div class="chIcon" style="border-bottom: 1px solid black; margin: 1rem 1rem 3rem 1rem;">
                                    <label style="display: flex; font-weight: lighter; padding: 0;">
                                       <input type="file" name="ch-name" style="width: 100%; border: none; outline: none; background: transparent; color: black;" placeholder="<?= $result["name"]; ?>" autocomplete="off" accept="image/png, image/gif, image/jpeg">
                                       <input type="submit" name="ch-icon-button" style="height: 100%; border: none; outline: none; background: transparent; color: black;" value="UPDATE">
                                    </label>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                           <div class="card bg-warning text-white mb-4" style="display: flex;">
                              <div class="card-body" style="height: 12.5rem;">
                                 <h4 style="color: black;"><b>Change Welcome</b></h4>
                                 <div class="chWelcome" style="border-bottom: 1px solid black; margin: 1rem 1rem 3rem 1rem;">
                                    <label style="display: flex; font-weight: lighter; padding: 0;">
                                       <input type="text" name="ch-welcome" style="width: 100%; border: none; outline: none; background: transparent; color: black;" placeholder="<?= $result["welcome"]; ?>" autocomplete="off">
                                       <input type="submit" name="ch-welcome-button" style="height: 100%; border: none; outline: none; background: transparent; color: black;" value="UPDATE">
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                           <div class="card bg-warning text-white mb-4" style="display: flex;">
                              <div class="card-body" style="height: 12.5rem;">
                                 <h4 style="color: black;"><b>Change Endeavors</b></h4>
                                 <div class="chEndeavors" style="border-bottom: 1px solid black; margin: 1rem 1rem 3rem 1rem;">
                                    <label style="display: flex; font-weight: lighter; padding: 0;">
                                       <input type="text" name="ch-endeavors" style="width: 100%; border: none; outline: none; background: transparent; color: black;" placeholder="<?= $result["endeavors"]; ?>" autocomplete="off">
                                       <input type="submit" name="ch-endeavors-button" style="height: 100%; border: none; outline: none; background: transparent; color: black;" value="UPDATE">
                                    </label>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                           <div class="card bg-warning text-white mb-4" style="display: flex;">
                              <div class="card-body" style="height: 12.5rem;">
                                 <h4 style="color: black;"><b>Change Homepage Image</b></h4>
                                 <div class="chIcon" style="border-bottom: 1px solid black; margin: 1rem 1rem 3rem 1rem;">
                                    <label style="display: flex; font-weight: lighter; padding: 0;">
                                       <input type="file" name="ch-image" style="width: 100%; border: none; outline: none; background: transparent; color: black;" placeholder="<?= $result["homeCover"]; ?>" autocomplete="off" accept="image/png, image/gif, image/jpeg">
                                       <input type="submit" name="ch-image-button" style="height: 100%; border: none; outline: none; background: transparent; color: black;" value="UPDATE">
                                    </label>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </form>
               </div>
            </div>
         </main>
         <footer class="py-4 bg-light mt-auto">
            <div class="container-fluid px-4">
               <div class="d-flex align-items-center justify-content-between small">
                  <div class="text-muted">Copyright &copy; Your Website 2022</div>
                  <div>
                     <a href="#">Privacy Policy</a>
                     &middot;
                     <a href="#">Terms &amp; Conditions</a>
                  </div>
               </div>
            </div>
         </footer>
      </div>
   </div>
   <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
   <script src="js/scripts.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
   <!-- <script src="./js/chart-area-demo.js"></script>
   <script src="./js/chart-bar-demo.js"></script> -->
   <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
   <script src="js/datatables-simple-demo.js"></script>
   <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
   <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
   <script>
      $(document).ready(function() {
         $('#summernote').summernote();
      });
   </script>
</body>

</html>