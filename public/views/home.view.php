<?php
include_once "../projects.all.php";

if (isset($_SESSION['room_id'])) {
    unset($_SESSION['room_id']);
}

if (isset($_SESSION['followed_id'])) {
    unset($_SESSION['followed_id']);
}

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
}

    $user = $_SESSION['user'];

    $userWithCoins = $user_handler->getUserWithCoins($user['id']); 
    
    $coins = isset($userWithCoins['coins']) ? $userWithCoins['coins'] : 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <script src="https://kit.fontawesome.com/2e71550de4.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            /* justify-content: space-between; */
            min-height: 100vh;
            background-color: #f0f0f0;
        }

        .header {
            padding: 10px;
            background-color: #f8f8f8;
            display: flex;
            /* justify-content: space-between; */
            align-items: center;
        }

        .header h2 {
            margin: 0;
            font-size: 18px;
        }

        .coins-box {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: yellow;
            padding: 5px 10px;
            border-radius: 5px;
            margin-right: 20px;
        }

        .coins-box a {
            text-decoration: none;
            color: black;
            font-weight: bold;
        }

        .form-container {
            flex-grow: 1;
            display: flex;
            justify-content: center;
            margin-bottom: 100px;
            align-items: center;
            padding: 20px;
        }

        .form-box {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .username {
            margin-bottom: 30px;
            text-align: center;
            font-weight: bold;
            font-size: 20px;
            color: #333;
        }

        h5 {
            margin-bottom: 20px;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="radio"] {
            margin-right: 5px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
    </style>
</head>

<body>
<div class="header box h gap-l space-between">
        <div class="box h gap-s align-center">
            <div class="box v panel-primary">
                <h2 class="text-big-header light">Chat</h2>
            </div>
            <span class="text-secondary">The Alliance of Coders</span>
        </div>
        <div class="box h gap-s">

            <div class="box h gap-m s panel-accent-2 align-center">
                <i class="fa-solid fa-coins fa-lg" style="color: #fafafa;"></i>
                <span class="text-secondary light"></span>
                <?= htmlspecialchars($coins); ?></span>
            </div>

            <div class="box v panel-secondary m gap-m">
                <?= htmlspecialchars($user['username']); ?>
            </div>

            <a href='../logout.php'>
                <div class="box h panel-negative m">Logout</div>
            </a>
        </div>
    </div>

    <div class="margin main">

        <div class="box v panel-shadow xl gap-l">
            <div class="box v">
                <div class="span text-hero center">Welcome <?= htmlspecialchars($user['username']); ?>!</div>
            </div>
            <span class="text center">Select preferred match type</span>

    <form action="../controls/find.cntrl.php" method="POST" class="box v gap-xs">
        <div class="box v gap-xs">
        <label class="avatar-select" for="male">
            <input type="radio" name="gender" id="male" value="Male">
            <div class="box h panel-secondary card">Male</div>
        </label>
        
        <label class="avatar-select" for="female">
            <input type="radio" name="gender" id="female" value="Female">
            <div class="box h panel-secondary card">Female</div>
        </label>
        
        <label class="avatar-select" for="lgbtq+">
            <input type="radio" name="gender" id="lgbtq+" value="LGBTQ+">
            <div class="box h panel-secondary card">LGBTQ+</div>
        </label>
        </div>

        <button class="start-btn accent">Start Chat!</button>
        <br>
        <div class="update">
            <hr class="line">
            <span>OR</span>
            <hr class="line">
        </div>
        <br>
        <input type="button" class="start-btn outline" id="random_chat" value="Start Random Chat!">
    </form>
    </div>
    </div>
    <br><br><br><br><br>
    
    <input type="hidden" id="user_id" data-val="<?= $user['id'] ?>" value="<?= $user['id'] ?>">
    <input type="hidden" id="username" data-val="<?= $user['username'] ?>">

    <script src="../js/client.js"></script>
    <script src="../js/local.js"></script>

    <?php include_once "../components/navigation.cmp.php"; ?>
    
</body>

</html>