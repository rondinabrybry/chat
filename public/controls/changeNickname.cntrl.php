<?php

include_once "../classes/user.class.php";
include_once "../projects.all.php";

$user_handler = new UserHandler();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $new_nickname = $_POST['nickname'];
    $user_id = $_SESSION['user']['id'];

    $updated_user = $user_handler->setNickname($user_id, $new_nickname);

    if ($updated_user) {
        $_SESSION['user']['username'] = $updated_user['nickname'];

        header("Location: ../views/settings.view.php?success=Nickname updated successfully");
        exit();
    } else {
        $error = "Failed to update nickname. Please try again.";
    }
}
?>
