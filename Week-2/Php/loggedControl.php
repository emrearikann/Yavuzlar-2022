<?php
session_start();
if ($_SESSION["logged"] == FALSE) {  // checks session status if user logged in
   header("Location: ./Php/login.php");  // redirects to login page if status is false 
   exit();
}
