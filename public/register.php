<?php
session_start();
include_once "classes/user.class.php";

$userHandler = new UserHandler();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $gender = $_POST['gender'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $existingUser = $userHandler->getUserByEmail($email);

        if ($existingUser) {
            $error = "An account with this email already exists.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $user = $userHandler->registerUser($username, $email, $hashedPassword, $gender);
            

            if ($user) {
                $_SESSION['user'] = $user;

                header("Location: controls/register.cntrl.php");
                exit();
            } else {
                $error = "There was an error registering your account. Please try again.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

    <div class="margin">
        <div class="register-container box v panel-shadow l gap-l">
            <h2 class="text-big-header center">Come and Join Us!</h2>
            <?php if (isset($error)): ?>
                <p style="color:red;"><?= $error ?></p>
            <?php endif; ?>

            <?php if (isset($_GET['regSuccess'])): ?>
                <div class="box v panel-positive m">
                    <?= htmlspecialchars($_GET['regSuccess']); ?>
                </div>
            <?php endif; ?>

        <form action="register.php" method="POST">
            <div>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div>
                <label for="username">Username:</label>
                <input type="username" name="username" id="username" required>
            </div>
            <div>
                <input type="radio" name="gender" id="male" value="Male" required>
                <label for="male">Male</label>
                <input type="radio" name="gender" id="female" value="Female">
                <label for="female">Female</label>
                <input type="radio" name="gender" id="LGBTQ+" value="LGBTQ+">
                <label for="LGBTQ+">LGBTQ+</label>
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div>
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" name="confirm_password" id="confirm_password" required>
            </div>
            <button type="submit">Register</button>
            <p>Login here <a href="logout.php">Login here</a></p>

            </form>
        </div>
    </div>

</body>

</html>