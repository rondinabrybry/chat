<?php
include_once "../classes/room.class.php";
$room_handler = new RoomHandler;

if(isset($_POST['reason'])){
    $chat_id = htmlspecialchars($_POST['chat_id']);
    $reason = htmlspecialchars($_POST['reason']);

    $room_handler->reportMessage($chat_id, $reason);

    echo "Reported Succesfully!";
}