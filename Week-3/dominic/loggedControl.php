<?php
session_start();
if ($_SESSION["logged"] == FALSE) {
   header("Location: ./login.php");
   exit();
}
