<?php
session_start();
include_once "classes/user.class.php";

$userHandler = new UserHandler();

if (isset($_SESSION['user'])) {

    header("Location: views/home.view.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="margin">
        <div class="login-container box v panel-shadow l gap-m">
            <h2 class="text-big-header center">Let's Start Chatting!</h2>
            <?php if (isset($_GET['loginError'])): ?>
                <div class="box v panel-negative m">
                    <?= htmlspecialchars($_GET['loginError']); ?>
                </div>
            <?php endif; ?>



            <form action="controls/login.cntrl.php" class="box v gap-l" method="POST">
                <div class="box v gap-s">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="box v gap-s">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                </div>
                <button type="submit">Login</button>
                <p>Don't have an account? <a class="text link" href="register.php">Register here</a></p>

            </form>
        </div>
    </div>

</body>

</html>