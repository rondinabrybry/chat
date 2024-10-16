<?php 

include_once "handler.class.php";

class RoomHandler extends Handler{


    function getMessages($user_id, $friend_id){
        $result = $this->query("SELECT * FROM followed INNER JOIN chatroom ON chatroom.id = chatroom_id 
        WHERE (userid_1 = $user_id AND userid_2 = $friend_id) OR (userid_1 = $friend_id AND userid_2 = $user_id) ORDER BY timestamp");

        return $result;
    }

    function getLastMessage($user_id, $friend_id){
        $result = $this->queryOne("SELECT * FROM followed INNER JOIN chatroom ON chatroom.id = chatroom_id 
        WHERE (userid_1 = $user_id AND userid_2 = $friend_id) OR (userid_1 = $friend_id AND userid_2 = $user_id) ORDER BY timestamp DESC");

        return $result;
    }


    function reportMessage($message_id, $reason){
        $this->exec(["INSERT INTO reports (message_id, reason) VALUES (?,?)", [$message_id, $reason]]);
    }

}