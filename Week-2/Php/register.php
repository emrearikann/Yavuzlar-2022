<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>

   <!-- CSS -->
   <link rel="stylesheet" href="../Css Files/register.css">
</head>

<body>
   <?php
   // it defined as global for use below (in HTML form)
   global $user;
   try {
      session_start();
      include("./database.php");

      if (isset($_POST["username"]) && isset($_POST["password"])) {
         $username = $_POST["username"];
         $password = $_POST["password"];


         $s = $db->prepare("SELECT * FROM users WHERE username=?");
         $s->execute([$username]);
         $user = $s->fetch();
         // user already exist
         if ($user) {
            // echo "user already exist!";
         }
         // inserting new user on table 
         else {
            $q = $db->prepare("INSERT INTO users (username, password) VALUES ('$username', '$password');");
            $q->execute();
            $results = $q->fetch();
         }
      }
   }
   // catching db errors
   catch (PDOException $e) {
      print "Exception: " . $e->getMessage();
   }
   ?>

   <section id="login">
      <div class="container">
         <div class="login-form">
            <form action="#" method="POST">
               <?php
               if ($user) {
                  echo "User already exist!";
               }
               ?>
               <h1>Register</h1>
               <input name="username" type="text" class="form-control" placeholder="Username" autocomplete="off" required />
               <br />
               <input name="password" type="password" class="form-control" placeholder="Password" required />
               <br />
               <input type="submit" class="form-control submit" value="Register" style="color: rgb(14, 15, 18)" />
               <br />
            </form>
            <p>Already a member? <a href="./login.php">Log In</a></p>
         </div>
      </div>
   </section>


</body>

</html>