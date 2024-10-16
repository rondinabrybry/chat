<?php

include_once "../classes/user.class.php";
session_start();

if(isset($_POST['room_id'])){
    $_SESSION['room_id'] = $_POST['room_id'];

    echo "setRoom";
    exit();
}
