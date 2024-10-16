<?php
include_once 'handler.class.php';

class UserHandler extends Handler
{


    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM user WHERE email = ?";
        $result = $this->queryEmail($sql, [$email]);

        return $result;
    }

    public function registerUser($username, $email, $password, $gender)
    {
        $sql = "INSERT INTO user (username, email, password) VALUES (?, ?, ?)";
        $params = [$username, $email, $password];
    
        $user_id = $this->executeReg($sql, $params);
    
        if ($user_id) {
            $profile_sql = "INSERT INTO profile (user_id, nickname, gender) VALUES (?, ?, ?)";
            $profile_params = [$user_id, $username, $gender];
    
            return $this->executeNick($profile_sql, $profile_params);
        }
    
        return false;
    }

    public function addVoucher($voucherCode, $voucherValue) {
        $sql = "INSERT INTO voucher (voucher_code, voucher_value) VALUES (?, ?)";
        $params = [$voucherCode, $voucherValue];
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute($params);
    }

    
    public function getAllVouchers() {
        $sql = "SELECT * FROM voucher";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllProducts() {
        $sql = "SELECT * FROM products WHERE availability = 1";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    


    function setProfile($user_id)
    {

        $user = $this->getUser($user_id);
        $params = [$user['id'], $user['name']];
        $this->exec(["INSERT IGNORE INTO `profile` (`user_id`, `nickname`) VALUES (?, ?)", $params]);

        return $user;
    }

    function setNickname($user_id, $nickname)
    {

        $params = [$nickname, $user_id];
        $this->exec(["UPDATE `profile` SET `nickname` = ? WHERE user_id = ?", $params]);

        return $this->getUserWithProfile($user_id);
    }

    public function setPassword($user_id, $new_password)
    {
        $params = [$new_password, $user_id];
        $this->exec(["UPDATE `user` SET `password` = ? WHERE id = ?", $params]);
    }

    function updateUserCoins($user_id, $coins_to_add)
    {
        $current_user = $this->getUserWithCoins($user_id); 

        $new_coins = $current_user['coins'] + $coins_to_add;

        $sql = "UPDATE profile SET coins = ? WHERE user_id = ?";
        $this->exec([$sql, [$new_coins, $user_id]]);
    }

    function deductUserCoins($user_id, $new_coins)
{
    $sql = "UPDATE profile SET coins = ? WHERE user_id = ?";
    $this->exec([$sql, [$new_coins, $user_id]]);
}

    public function expireVoucher($voucher_id)
    {
        $sql = "UPDATE voucher SET expired = 1 WHERE id = ?";
        $this->exec([$sql, [$voucher_id]]);
    }

    function getUserWithCoins($user_id)
    {
        $result = $this->queryOne("SELECT user.*, profile.coins FROM user LEFT JOIN profile ON user.id = profile.user_id WHERE user.id = $user_id");

        return $result;
    }

    function getUserInboxLimit($user_id)
    {
        $result = $this->queryOne("SELECT * FROM profile WHERE user_id = $user_id");

        return $result;
    }


    public function updateInboxLimit($userId, $newInboxLimit) {
        $sql = "UPDATE profile SET inbox_limit = ? WHERE user_id = ?";
        return $this->exec([$sql, [$newInboxLimit, $userId]]);
    }

    public function getProductById($productId) {
        $sql = "SELECT * FROM products WHERE product_id = $productId";
        $result = $this->queryOne($sql);
        return $result;
    }
    


    function getUser($id)
    {

        $result = $this->queryOne("SELECT id, username, user_type FROM USER WHERE id = $id");

        return $result;
    }


    function getUserWithProfile($user_id)
    {
        $result = $this->queryOne("SELECT user.id,`user_type`,`username`,`nickname`, `gender`,`coins`,`inbox_limit`, `status` 
                    FROM user LEFT JOIN profile ON user.id WHERE user.id = $user_id AND user_id = $user_id");

        return $result;
    }


    function getUser2($user_id, $room_id)
    {
        $result = $this->getRoom($room_id);

        if ($result['userid_1'] == $user_id) {
            return $this->getUserWithProfile($result['userid_2']);
        } else {
            return $this->getUserWithProfile($result['userid_1']);
        }
    }


    function sendChat($room_id, $message, $sender_id)
    {
        $message = htmlspecialchars($message);

        $this->exec(["INSERT INTO messages(chatroom_id, sender_id, message) VALUES (?, ? , ? )", [$room_id, $sender_id, $message]]);
    }


    function getChat($room_id)
    {
        return $this->query("SELECT * FROM messages WHERE chatroom_id = $room_id");
    }


    function getLastChat($room_id)
    {
        return $this->queryOne("SELECT * FROM messages WHERE chatroom_id = $room_id ORDER BY timestamp DESC");
    }


    function getRoom($room_id)
    {
        $result = $this->queryOne("SELECT chatroom.*, followed.id AS followed_id 
                                FROM `chatroom` LEFT JOIN `followed` ON chatroom.id = chatroom_id
                                WHERE chatroom.id = $room_id");

        return $result;
    }

    function findMatch($user_id, $gender){
        if($gender == ""){
            $this->exec(["INSERT IGNORE INTO `waitlist` (`finder_id`) VALUES (?)",[$user_id]]);
        }else{
            $this->exec(["INSERT IGNORE INTO `waitlist` (`finder_id`, `preferred`) VALUES (?,?)",[$user_id, $gender]]);
        }
    }
    

    function getFollowedUsers($user_id){
        $result = $this->query("SELECT * FROM followed INNER JOIN chatroom ON chatroom.id = chatroom_id 
                                WHERE userid_1 = $user_id OR userid_2 = $user_id");
        
        $followed_users = [];
        foreach($result as $room){
            $followed_user = $this->getUser2($user_id, $room['id']);
            $followed_user = ["user" => $followed_user, "room_id" => $room['id']];
            
            if(in_array($followed_user, $followed_users)){
                continue;
            }else{
                array_push($followed_users, $followed_user);
            }
        }
        
        return $followed_users;
    }

    function isFollowedUser($user_id, $user2_id){
        $followed_users = $this->getFollowedUsers($user_id);

        foreach($followed_users as $followed_user){
            if($followed_user['user']['id'] == $user2_id){
                return "Followed";
            }
        }
        return "Not Followed";
    }

}