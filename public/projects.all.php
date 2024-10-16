<?php

session_start();

// <!-- INCLUDES -->

include_once "classes/handler.class.php";
include_once "classes/user.class.php";
include_once "classes/room.class.php";

$handler = new Handler();
$user_handler = new UserHandler();
$room_handler = new RoomHandler();
?>


<!-- CSS -->

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
<link rel="stylesheet" href="../css/main.css">
<script src="https://kit.fontawesome.com/2e71550de4.js" crossorigin="anonymous"></script>
<link rel="stylesheet" href="../css/style.css">

<!-- JS SCRIPT -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.socket.io/4.0.0/socket.io.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>