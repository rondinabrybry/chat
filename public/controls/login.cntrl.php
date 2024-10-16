<?php

include_once "../classes/user.class.php";
include_once "../projects.all.php";

$user_handler = new UserHandler();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = $user_handler->getUserByEmail($email);

    if ($user) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user'] = $user;


            if ($user['user_type'] === 'admin') {
                header("Location: ../../admin/views/admin.view.php");
            } else {

                $user = $user_handler->getUserWithProfile($user['id']);
                if($user['status'] === "Online"){
                    unset($_SESSION['user']);
                    
                    header("Location: ../login.php?loginError=User is currently online.");
                    exit();
                }else{
                    header("Location: ../views/home.view.php");
                }
            }
            exit();
        } else {
            header("Location: ../login.php?loginError=Incorrect Email or Password.");
            exit();
        }
    } else {
        header("Location: ../login.php?loginError=Email not found.");
        exit();
    }
}
