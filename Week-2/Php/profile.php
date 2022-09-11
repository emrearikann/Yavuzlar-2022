<!-- where person = $name -->
<?php
include("./loggedControl.php");
//include("./Php/database.php");
$name = $_SESSION["username"];
$time = date("Y-m-d h:i:sa");
$status = "incomplete";
$db = new PDO("sqlite:./database.db");


// ADDING TODO
try {
   if (isset($_POST["text"]) && isset($_POST["addTodo"])) {
      $todoText = $_POST["text"];

      $q = $db->prepare("INSERT INTO todos (task, person, status, time) VALUES ('$todoText', '$name', '$status', '$time');");
      $q->execute();
      $results = $q->fetch();
      header("Location: profile.php");
      exit();
   }
} catch (PDOException $e) {
   print $e;
}

// Todo Completed Check
if (isset($_GET["completed"])) {
   $completed = $_GET["completed"];
   $completedTodo = $db->prepare("UPDATE todos SET status = 'completed' WHERE id='$completed';");
   $completedTodo->execute();
   $results = $completedTodo->fetch();
   header("Location: index.php");
   exit();
}

if (isset($_GET["incomplete"])) {
   $completed = $_GET["incomplete"];
   $completedTodo = $db->prepare("UPDATE todos SET status = 'incomplete' WHERE id='$completed';");
   $completedTodo->execute();
   $results = $completedTodo->fetch();
   header("Location: index.php");
   exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Document</title>

   <link rel="stylesheet" href="../Css Files/profile.css">
   <link rel="stylesheet" href="../Css Files/main.css">
</head>

<body>
   <?php
   $name = $_SESSION["username"];
   ?>

   <header class="container">
      <div class="headerdiv">
         <?php
         echo '<h1><b>Welcome ' . $name . '</b></h1>'
         ?>
         <ul>
            <li><a href="./index.php">Home Page</a></li>
            <li><a href="./logout.php">Log Out</a></li>
         </ul>
      </div>

      <form id="task-form" action="#" method="POST">
         <input type="text" name="text" id="task-input" autocomplete="off" placeholder="Type something to do.." />
         <input type="submit" id="task-submit" value="ADD" name="addTodo" />
      </form>
   </header>

   <main class="container">
      <section class="task-list">
         <h2>Tasks</h2>
         <label> <input type="checkbox" id="hide-completed" style="margin-right: 0.5rem" />Hide Completed </label>

         <?php
         include("database.php");

         $q = $db->prepare("SELECT * FROM todos WHERE person='$name'");
         $q->execute(array());
         $results = $q->fetchAll();

         // DELETE TODO
         foreach ($results as $result) {
            if (isset($_POST["removeButton"])) {
               $delTodo = $_POST["removeButton"];
               $del = $result["id"];
               if ($delTodo == $del) {
                  $delete = $db->prepare("DELETE FROM todos WHERE id='$delTodo'");
                  $delete->execute();
                  $results = $delete->fetch();
                  header("Location: profile.php");
                  exit();
               }
            }
         }

         // Rendering and showing todos 
         echo
         '<div id="tasks">
            <div class="task">
               <div class="content">';
         foreach ($results as $result) {
            $result["status"] == 'completed' ? $completeCheck = 'checked' : $completeCheck = '';
            echo '<label class="todoListItem">
            <div class="containerTodoListItem">
                        <form action="#" method="POST">
                           <input type="hidden" value="' . $result["id"] . '" name="id" style="cursor: pointer">
                           <input id="checkss" ' . $completeCheck . ' type="checkbox" style="cursor: pointer" name="todoComp" value="' . $result["id"] . '">
                           <span class="todoSpan">' . $result["task"] . '</span>
                        </form>
                     </div>
                     <div>
                     <form action="#" method="POST">
                        <!-- <button class="removeButton" name="editButton">EDIT</button> -->
                        <button class="removeButton" name="removeButton" value="' . $result["id"] . '">REMOVE</button>
                     </form>
                     </div>
                     </label>
                     <span style="text-decoration: underline;">date of issue: ' . $result["time"] . '</span>';
         }
         echo '
               </div>
            </div>
         </div>';
         ?>

      </section>

      <form id="task-form">
         <input type="text" id="search" autocomplete="off" placeholder="Search.." />
      </form>
   </main>
   <!-- 
   <script src="../Scripts/functions.js"></script>
   <script src="../Scripts/main.js"></script> -->
   <script src="../Scripts/checkTodo.js"></script>
</body>

</html>