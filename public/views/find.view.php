<?php
include_once "../projects.all.php";

if (!isset($_SESSION['user']) || !isset($_SESSION['preferred'])) {
    header("Location: home.view.php");
    exit();
}

unset($_SESSION['room_id']);
unset($_SESSION['user2']);

$user = $_SESSION['user'];
//just to be safe
$user = $user_handler->getUserWithProfile($user['id']);
$preferred = $_SESSION['preferred'];

    $user_handler->findMatch($user['id'], $preferred);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Finding</title>
</head>

<body>

    <div class="margin">
        <box class="box v panel align-center justify-center gap-l full-height">
            <span class="text-hero">Finding match..</span>
            <div class="loader"></div>
        </box>
    </div>

    <input type="hidden" id="user_id" data-val="<?= $user['id'] ?>">
    <input type="hidden" id="username" data-val="<?= $user['username']?>">
    <input type="hidden" id="room_id" data-val="<?= $room_id ?>">

    <script src="../js/client.js"></script>

</body>

</html>