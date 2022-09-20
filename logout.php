
<?php session_start(); ?>
<?php include "functions.php"; ?>
<?php 
   unset($_SESSION['user_name']);
   
    redirect("index.php");

?>