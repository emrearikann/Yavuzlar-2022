<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>

   <!-- CSS -->
   <link rel="stylesheet" href="../Css Files/login.css">
</head>

<body>
   <?php
   session_start();
   include("./database.php");

   if (isset($_POST["username"]) && isset($_POST["password"])) {
      if (!isset($_POST["username"]) || trim($_POST["username"]) == "" || !isset($_POST["password"]) || trim($_POST["password"]) == "") {
         echo "please fill all the inputs!";
      }
      $q = $db->prepare("SELECT * FROM users WHERE username = '" . $_POST["username"] . "'");
      $q = $db->prepare("SELECT * FROM users WHERE password = '" . $_POST["password"] . "'");
      $q->execute();

      $results = $q->fetch();
      // it checks 1st and 2nd columns of "users" table and compare with the data we sent
      if (isset($results[1]) && isset($results[2])) {
         $_SESSION["username"] = $_POST["username"];
         $_SESSION["logged"] = TRUE;  // change session status
         header("Location: ./index.php");
         exit();
      }
   }
   ?>

   <section id="login">
      <div class="container">
         <div class="login-form">
            <form action="#" method="POST">
               <?php
               if (!isset($results[1]) && !isset($results[2])) {
                  echo "username or password is not correct!";
               } else {
                  echo "";
               }
               ?>
               <h1>Log In</h1>
               <input name="username" type="text" class="form-control" placeholder="Username" autocomplete="off" required />
               <br />
               <input name="password" type="password" class="form-control" placeholder="Password" required />
               <br />
               <input type="submit" class="form-control submit" value="Log In" style="color: rgb(14, 15, 18)" />
               <br />
            </form>
            <p>New to <b>Yavuzlar?</b> <a href="./register.php">Create Account</a></p>
         </div>
      </div>
   </section>
</body>

</html>