<?php
session_start();

if(isset($_SESSION['user'])){
    header("Location: ../logout.php");
}
header("Location: ../register.php?regSuccess=Register Successful, please login.");
exit();