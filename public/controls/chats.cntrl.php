<?php
session_start();
include_once '../classes/user.class.php';

$user_handler = new UserHandler();
$user = $_SESSION['user'];
$id = $user['id'];

$room_id = $_SESSION['room_id'];
$room = $user_handler->getRoom($room_id);

$user = $user_handler->getUserWithProfile($user['id']);
$user2 = $user_handler->getUser2($id, $room_id);
$user2 = $user2['username'];


if(isset($_POST['getLastChat'])){

    $message = $user_handler->getLastChat($room_id);

    if($message['sender_id'] == $id){
        echo'
        <span class="sent">
                <span class="text-secondary gray timestamp">'.date("h:i A", strtotime($message['timestamp'])).'</span>
                <p class="sent-bubble">'. strval($message['message']) .'</p>
                
        </span>';
    }else{
        echo'
        <div class="received">
                <input type="hidden" id="chat_id" value="'. $message['id'] .'"/>
                <p class="received-bubble" id="hold_trigger" onclick="menu_toggle(this)">'. strval($message['message']) . '</p>
                <span class="text-secondary gray timestamp">'.date("h:i A", strtotime($message['timestamp'])).'</span>
        </div>';
    }

    exit();
}



if(isset($_POST['message'])){
    $message = $_POST['message'];

    $user_handler->sendChat($room_id, $message, $id);
}


$messages = $user_handler->getChat($room_id);

if(count($messages) == 0){
    echo "
            <div class='no-chat'>
                <p>You have been paired with $user2, you can say hi! </p> <p class='small'>DO NOT RELOAD OR YOU WILL BE DISCONNECTED!</p>
                <br>
            </div>";
} else{
        
    foreach($messages as $message){
        if($message['sender_id'] == $id){
            echo'
            <span class="sent">
                    <span class="text-secondary gray timestamp">'.date("h:i A", strtotime($message['timestamp'])).'</span>
                    <p class="sent-bubble">'. strval($message['message']) .'</p>
            </span>';
        }else{
            echo'
            <div class="received">
                    <input type="hidden" id="chat_id" value="'. $message['id'] .'"/>
                    <p class="received-bubble" id="hold_trigger" onclick="menu_toggle(this)">'. strval($message['message']) . '</p>
                    <span class="text-secondary gray timestamp">'.date("h:i A", strtotime($message['timestamp'])).'</span>
            </div>';
        }
    }
}


if($room['isActive'] == 0){
    
    $user_left = $user_handler->getUserWithProfile($room['user_left']);

    if($user['username'] != $user_left['username']){
        echo '
                <div class="update">
                    <hr class="line">
                    <span>'. $user_left['username'] .' has left</span>
                    <hr class="line">
                </div>
            ';
    }else{
        echo '
                <div class="update">
                    <hr class="line">
                    <span>You have left this conversation</span>
                    <hr class="line">
                </div>
            ';
    }
}
?>

<script>
    popup_bg = $('#popup-bg'),
    popup_container = $(".popup-container");

    popup_bg.on("click", function(){
        popup_container.hide();
    })

    function menu_toggle(trigger) {
        chat_id = $(trigger).parent().find("#chat_id").val()
        message = $(trigger).text()

        $(".reported-text").text(message)
        $(".report-form #chat_id").val(chat_id)

        popup_container.toggle();
    }
</script>
