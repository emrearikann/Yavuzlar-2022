<?php
session_start();
//include("./database.php");
$status = "incomplete";
$time = date("Y-m-d h:i:sa");
$db = new PDO("sqlite:./database.db");
// redirects to login.php if not logged in.
if (!isset($_SESSION['logged']) == TRUE) {
   header("Location:./login.php");
   exit();
}




?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <meta name="viewport" content="width=device-width, initial-scale=1.0" />
   <title>Yavuzlar To-Do App</title>

   <!-- CSS -->
   <link rel="stylesheet" href="../Css Files/main.css" />


</head>

<body>

   <header class="container">
      <div class="headerdiv">
         <h1><b>Home Page</b></h1>
         <ul>
            <li><a href="./profile.php">My Profile</a></li>
            <li><a href="./logout.php">Log Out</a></li>
         </ul>
      </div>

      <form id="task-form" action="#" method="POST">
         <input type="text" name="text" id="task-input" autocomplete="off" placeholder="Type something to do.." />
         <select name="selectUser" value="personToDo" id="selectUser" style="background-color: #262626; color: #ffc812; padding: 0 1rem; border: none; outline: none; margin-right: 1rem;">
            <?php
            $data = $db->prepare("SELECT username FROM users GROUP BY username");
            $data->execute(array());
            $results = $data->fetchAll();

            foreach ($results as $result) {
               $userN = $result["username"];
               echo '<option value="' . $userN . '">' . $userN . '</option>';
            }
            ?>
         </select>
         <input type="submit" id="task-submit" value="ADD" name="addTodo" />
      </form>
   </header>

   <main class="container">
      <section class="task-list">
         <h2>Tasks</h2>
         <label> <input type="checkbox" id="hide-completed" style="margin-right: 0.5rem" />Hide Completed </label>

         <?php
         // ADDING TODOS TO DB
         try {
            if (isset($_POST["text"]) && isset($_POST["addTodo"]) && isset($_POST["selectUser"])) {
               $todoText = $_POST["text"];
               $userN = $_POST["selectUser"];

               $q = $db->prepare("INSERT INTO todos (task, person, time, status) VALUES ('$todoText', '$userN', '$time', '$status');");
               $q->execute();
               $results = $q->fetch();
               header("Location: index.php");
               exit();
            }
         } catch (PDOException $e) {
            print $e;
         }
         ?>

         <?php
         include("database.php");

         $q = $db->prepare("SELECT * FROM todos");
         $q->execute(array());
         $results = $q->fetchAll();

         // BUTTON ACTIONS

         // DELETE TODO
         if (isset($_POST["removeButton"])) {
            foreach ($results as $result) {
               $delTodo = $_POST["removeButton"];
               $del = $result["id"];
               if ($delTodo == $del) {
                  $delete = $db->prepare("DELETE FROM todos WHERE id='$delTodo'");
                  $delete->execute();
                  $results = $delete->fetch();
                  header("Location: index.php");
                  exit();
               }
            }
         }

         // TODO COMPLETED CHECK
         // it tooks a parameter from 'checkTodos.js' as completed for check the todo status.
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

         // rendering and filtering todos on screen
         $completeCheck = '';
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
            </label>';
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
   <!-- <script src="../Scripts/functions.js"></script>
   <script src="../Scripts/main.js"></script> -->
   <script src="../Scripts/checkTodo.js"></script>

</body>

</html>