<?php
include("./loggedControl.php");
include("./database.php");

$data = $db->prepare("SELECT * FROM categories");
$data->execute(array());
$results = $data->fetchAll();

// remove category
if (isset($_POST["removeButton"])) {
   foreach ($results as $result) {
      $delTodo = $_POST["removeButton"];
      $del = $result["id"];
      if ($delTodo == $del) {
         $delete = $db->prepare("DELETE FROM categories WHERE id='$delTodo'");
         $delete->execute(array());
         $results = $delete->fetchAll();
         header("Location: settings.php");
         exit();
      }
   }
}

// add new category
try {
   if (isset($_POST["new-cat"]) && isset($_POST["add-button"])) {
      $newCategory = $_POST["new-cat"];
      $addButton = $_POST["add-button"];

      $q = $db->prepare("INSERT INTO categories (category) VALUES ('$newCategory');");
      $q->execute(array());
      $results = $q->fetchAll();
      header("Location: settings.php");
      exit();
   }
} catch (PDOException $e) {
   print $e;
}

// update aboutme section
try {
   if (isset($_POST["aboutme"]) && isset($_POST["editAbout"])) {
      $aboutData = $_POST["aboutme"];
      $about = $db->prepare("UPDATE aboutme SET about='$aboutData' WHERE id=1");
      $about->execute(array());
      $results = $about->fetchAll();
      header("Location: settings.php");
      exit();
   }
} catch (PDOException $e) {
   echo $e;
}

// update aboutme
try {
   if (isset($_POST["aboutImage"]) && isset($_POST["aboutImageChange"])) {
      $image = $_POST["aboutImage"];

      $chImg = $db->prepare("UPDATE aboutme SET image='$image' WHERE id=1");
      $chImg->execute(array());
      $results = $chImg->fetchAll();
      header("Location: settings.php");
      exit();
   }
} catch (PDOException $e) {
   echo $e;
}


$data2 = $db->prepare("SELECT * FROM content");
$data2->execute(array());
$results2 = $data2->fetchAll();

//remove blog 
if (isset($_POST["removeBlog"])) {
   foreach ($results2 as $result) {
      $delBlog = $_POST["removeBlog"];
      $del = $result["id"];
      if ($delBlog == $del) {
         $delete = $db->prepare("DELETE FROM content WHERE id='$delBlog'");
         $delete->execute(array());
         $results2 = $delete->fetchAll();
         header("Location: settings.php");
         exit();
      }
   }
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
               <h1 class="mt-4">Blog Settings</h1>
               <ol class="breadcrumb mb-4">
                  <li class="breadcrumb-item active">Blog Moderation</li>
               </ol>
               <div class="categories">
                  <form method="POST">
                     <div class="row" style="display: flex;">
                        <div class="col-xl-3 col-md-6">
                           <div class="card bg-warning text-white mb-4" style="display: flex;">
                              <div class="card-body">
                                 <h4 style="color: black;"><b>All Categories</b></h4>
                                 <div class="addCat" style="display: flex; border-bottom: 2px dotted black; margin: 1rem 1rem 3rem 1rem;">
                                    <input type="text" name="new-cat" style="width: 100%; border: none; outline: none; background: transparent; color: black;" placeholder="Add new category.." autocomplete="off">
                                    <input type="submit" name="add-button" style="height: 100%; border: none; outline: none; background: transparent; color: black;" value="ADD">
                                 </div>

                                 <?php
                                 $data = $db->prepare("SELECT * FROM categories");
                                 $data->execute(array());
                                 $results = $data->fetchAll();

                                 foreach ($results as $result) {
                                    echo  '<div style="display: flex; align-items: center; color: black; margin: 1rem; border-bottom: 1px solid black;">
                                             <p style="width: 100%"><b>Category Name:</b> ' . strtoupper($result[1]) . ' </p>
                                             <button class="removeButton" style="height: 4rem; background: transparent; border: none; outline: none;" name="removeButton" value="' . $result["id"] . '">REMOVE</button>
                                          </div>';
                                 }
                                 ?>
                              </div>
                           </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                           <div class="card bg-warning text-white mb-4" style="display: flex;">
                              <div class="card-body">
                                 <h4 style="color: black;"><b>About Me Section</b></h4>
                                 <?php
                                 $data = $db->prepare("SELECT * FROM aboutme");
                                 $data->execute(array());
                                 $results = $data->fetchAll();

                                 foreach ($results as $result) {
                                 }
                                 ?>
                                 <div class="changeAbout" style="display: flex; border-bottom: 2px dotted black; margin: 1rem 1rem 3rem 1rem;">
                                    <input id="about-me" type="text" name="aboutme" style="width: 100%; border: none; outline: none; background: transparent; color: black;" placeholder="<?= $result["about"]; ?>" autocomplete="off">
                                    <input id="edit-about" type="submit" name="editAbout" style="height: 100%; border: none; outline: none; background: transparent; color: black;" value="UPDATE">
                                 </div>
                                 <div class="changeAboutImage" style="border-bottom: 2px dotted black; margin: 1rem 1rem 3rem 1rem;">
                                    <label style="display: flex; font-weight: lighter; padding: 0;">
                                       <input type="file" name="aboutImage" style="width: 100%; border: none; outline: none; background: transparent; color: black;" autocomplete="off" accept="image/png, image/gif, image/jpeg">
                                       <input type="submit" name="aboutImageChange" style="height: 100%; border: none; outline: none; background: transparent; color: black;" value="UPDATE">
                                    </label>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-xl-3 col-md-6">
                           <div class="card bg-warning text-white mb-4" style="display: flex;">
                              <div class="card-body">
                                 <h4 style="color: black;"><b>All Blogs</b></h4>
                                 <div class="allBlogs" style="display: flex; border-bottom: 2px dotted black; margin: 1rem 1rem 3rem 1rem;">
                                 </div>

                                 <?php
                                 $data = $db->prepare("SELECT * FROM content");
                                 $data->execute(array());
                                 $results = $data->fetchAll();

                                 foreach ($results as $result2) {
                                    echo  '<div style="display: flex; align-items: center; color: black; margin: 1rem; border-bottom: 1px solid black;">
                                             <p style="width: 100%"><b>Blog Content:</b> ' . substr(strip_tags($result2["blogText"]), 0, 40) . ' </p>
                                             <button class="removeButton" style="height: 4rem; background: transparent; border: none; outline: none;" name="removeBlog" value="' . $result2["id"] . '">REMOVE</button>
                                          </div>';
                                 }
                                 ?>
                              </div>
                           </div>
                        </div>

                        <!-- <div class="col-xl-3 col-md-6">
                              <div class="card bg-warning text-white mb-4" style="display: flex;">
                                 <div class="card-body">
                                    <h4>Select Category</h4>
                                    yazılan blogları silme ve düzenleme işlemi bu kısımda yapılacak
                                 </div>
                              </div>
                           </div> -->
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

      let inputVal = '<?= $result["about"]; ?>';
      let inputEl = document.querySelector("#about-me").addEventListener("click", (e) => {
         e.target.value = inputVal;
      })
   </script>
</body>

</html>