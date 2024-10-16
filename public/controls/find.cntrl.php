<?php
include_once "../classes/user.class.php";

session_start();

$user_handler = new UserHandler();

$user = $_SESSION['user'];
$_SESSION['preferred'] = "";

if(isset($_POST['gender'])){
    $gender = $_POST['gender'];
    $_SESSION['preferred'] = $_POST['gender'];

    header("Location: ../views/find.view.php");
    exit();
}

if(isset($_POST['room_id'])){
    $room_id = $_POST['room_id'];
    
    $user2 = $user_handler->getUser2($user['id'], $room_id);
        

    if($user2['id'] != $user['id']){
        $_SESSION['room_id'] = $room_id;
        $_SESSION['user2'] = $user2['id'];
    }

    echo "found";
    exit();
}

header("Location: ../views/home.view.php");