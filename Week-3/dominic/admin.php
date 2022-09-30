<?php
include("./loggedControl.php");
include("./database.php");

try {
   if (isset($_POST["blog-data"]) && isset($_POST["coverImage"]) && isset($_POST["selectCat"])) {
      if (!isset($_POST["blog-data"]) || $_POST["blog-data"] == "") {
         $message = "Provide blog content!";
         echo "<script type='text/javascript'>
                  alert('$message');
               </script>";
      } else if (!isset($_POST["coverImage"]) || $_POST["coverImage"] == "") {
         $message = "Provide a cover image!";
         echo "<script type='text/javascript'>
                  alert('$message');
               </script>";
      } else if (!isset($_POST["selectCat"]) || $_POST["selectCat"] == "") {
         $message = "Provide a category";
         echo "<script type='text/javascript'>
                  alert('$message');
               </script>";
      } else {
         $blogData = $_POST["blog-data"];
         $coverImage = $_POST["coverImage"];
         $blogCategory = $_POST["selectCat"];
         $blogOwner = $_SESSION["username"];

         $B = $db->prepare("INSERT INTO content (blogText, blogCover, blogCat, blogOwner) VALUES ('$blogData', '$coverImage', '$blogCategory', '$blogOwner');");
         $B->execute(array());
         $results = $B->fetchAll();

         header("Location: admin.php");
         exit();
      }
   }
} catch (PDOException $e) {
   echo $e;
}

// if (isset($_POST["submitAll"])  && isset($_FILES["coverImage"])) {
//    $uploaddir = './images/';
//    $uploadfile = $uploaddir . basename($_FILES['coverImage']['name']);

//    if (move_uploaded_file($_FILES['coverImage']['tmp_name'], $uploadfile)) {
//       header("Location: admin.php");
//       exit();
//    } else {
//       echo "<script type='text/javascript'>
//                alert('An error has occured!');
//             </script>";
//    }
// }




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
               <h1 class="mt-4">Admin Dashboard</h1>
               <ol class="breadcrumb mb-4">
                  <li class="breadcrumb-item active">Dashboard</li>
               </ol>
               <form method="POST" action="#">
                  <textarea id="summernote" name="blog-data" rows="10"></textarea>

                  <div class="row" style="display: flex;">
                     <div class="col-xl-3 col-md-6">
                        <div class="card bg-warning text-white mb-4" style="display: flex;">
                           <div class="card-body" style="height: 10rem;">
                              <h4>Upload a cover image</h4>
                              <input type="file" name="coverImage" id="coverImage" />
                           </div>
                        </div>
                     </div>
                     <div class="col-xl-3 col-md-6">
                        <div class="card bg-warning text-white mb-4" style="display: flex;">
                           <div class="card-body" style="height: 10rem;">
                              <h4>Select Category</h4>
                              <select name="selectCat" id="selectCat" style="padding: 0 1rem; border: none; outline: none; color: black;">
                                 <?php
                                 $data = $db->prepare("SELECT category FROM categories GROUP BY category");
                                 $data->execute(array());
                                 $results = $data->fetchAll();

                                 foreach ($results as $result) {
                                    $category = $result["category"];
                                    echo '<option style="color: black;" value="' . $category . '">' . $category . '</option>';
                                 }
                                 ?>
                              </select>
                           </div>
                        </div>
                     </div>
                     <input type="submit" name="submitAll" value="Submit Content" style="margin: 0 auto; max-width: 600px; padding: 1rem; color: black; background-color: #FFC107; border: 0.25rem solid black; outline: none;">
                  </div>
               </form>
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