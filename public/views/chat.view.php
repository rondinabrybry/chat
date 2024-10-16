<?php 
    include_once "../projects.all.php";

    if(!isset($_SESSION['user'])){
        header("Location: ../controls/login.cntrl.php");
    }
        
    if(!isset($_SESSION['room_id'])){
        header("Location: find.view.php");
    }

    $user = $_SESSION['user'];
    $room_id = $_SESSION['room_id'];
    $user2 = $user_handler->getUser2($user['id'], $room_id);
    $room = $user_handler->getRoom($room_id);
    $messages = $user_handler->getChat($room_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
</head>
<body>
        <div class="box v gap-s chat-main">
        <div class="options box h gap-m align-center">
            <button type="button" class="primary" value="arrow_back" id="back_btn"> <- </button>
            <span class="text-hero light"><?= $user2['username'] ?></span>
            <div class="end-options">
            <?php 
                if (empty($room['followed_id'])):
            ?>
                <input type="button" value="add" class="option-btn material-symbols-outlined" id="add_btn"> 
            <?php 
                endif;
            ?>
                <!-- <input type="button" value="calendar_add_on" class="option-btn material-symbols-outlined" id="schedule_btn"> 
                <input type="button" value="refresh" class="option-btn material-symbols-outlined" id="refresh_btn">  -->
            </div>
        </div>
        <div class="chat-container" id="chatbox"></div>

        <?php if($room['isActive'] == 1): ?>
            <form action="" method="POST" class="message-container box h gap-s" id="message-box">
                <!-- <textarea class="message-box"></textarea> -->
                <input type="text" class="message-box" autofocus>
                <button type="submit" class="send-btn secondary">Send</button>
            </form>
        <?php else: ?>
            <form action="" method="POST" class="message-container box h gap-s grow" id="message-box">
                <!-- <textarea class="message-box"></textarea> -->
                <input type="text" class="message-box" disabled>
                <button type="submit" class="send-btn secondary">Send</button>
            </form>
        <?php endif; ?>
        </div>


    <input type="hidden" id="user_id" data-val="<?= $user['id'] ?>">
    <input type="hidden" id="user2_id" data-val="<?= $user2['id'] ?>">
    <input type="hidden" id="username" data-val="<?= $user['username'] ?>">
    <input type="hidden" id="room_id" data-val="<?= $room_id ?>">
    <input type="hidden" id="is_followed" data-val="<?= $user_handler->isFollowedUser($user['id'], $user2['id']) ?>">

    <div class="popup-container" style="display: none;">
        <div id="popup-bg"></div>
        <div id="hold_menu">
                <h1>Report</h1>
                <form class="report-form">
                    <span class="reported-text"></span>
                    <input type="hidden" name="chat_id" id="chat_id">
                    <textarea name="reason" id="reason" placeholder="Enter reason.." required></textarea>
                    <input type="submit" name="report" id="report_btn" value="Report">
                </form>
        </div>
    </div>
    
    <script src="../js/client.js"></script>
    <script src="../js/local.js"></script>
</body>
</html>
