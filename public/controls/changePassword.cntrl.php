<?php

include_once "../classes/user.class.php";
include_once "../projects.all.php";

$user_handler = new UserHandler();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user']['id'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    $user = $user_handler->getUser($user_id);

    if (password_verify($current_password, $user['password'])) {
        if ($new_password === $confirm_password) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            $user_handler->setPassword($user_id, $hashed_password);

            header("Location: ../views/profile.view.php?passwordSuccess=Password updated successfully");
            exit();
        } else {
            header("Location: ../views/profile.view.php?passwordError=New password does not matched.");
            exit();
        }
    } else {
        header("Location: ../views/profile.view.php?passwordError=Current password is incorrect.");
            exit();
    }
}
?>
