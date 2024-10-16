<?php
include_once "../projects.all.php";

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
}

$currentUser = $_SESSION['user'];
$userWithCoins = $user_handler->getUserWithCoins($currentUser['id']);

$coins = isset($userWithCoins['coins']) ? $userWithCoins['coins'] : 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Settings</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 100vh;
            background-color: #f0f0f0;
        }

        .header {
            padding: 10px;
            background-color: #f8f8f8;
            display: flex;
            justify-content: space-between;
            align-items: center;
            overflow: visible;
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
            align-items: center;
            padding: 20px;
            flex-direction: column;
            overflow: visible;
        }

        .form-box {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            margin-bottom: 20px;
        }

        h5 {
            margin-bottom: 20px;
            text-align: center;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
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
    <div class="header">
        <h2>AOC</h2>
        <div style="background-color: yellow; padding: 5px; display: flex; align-items: center;">
            Coins: <?= htmlspecialchars($coins); ?>
        </div>
        <a href='../logout.php'>Logout</a>
    </div>
    <div class="form-container">
        <a href="profile.view.php">Back</a>
        <br>
        <div class="form-box">
            <form action="../controls/changeNickname.cntrl.php" method="POST">
                <h5>Change Nickname</h5>
                <?php if (isset($_GET['success'])): ?>
                    <p style="color: green;"><?= htmlspecialchars($_GET['success']); ?></p>
                <?php elseif (isset($error)): ?>
                    <p style="color: red;"><?= htmlspecialchars($error); ?></p>
                <?php endif; ?>

                <input type="text" name="nickname" id="nickname" placeholder="Enter new nickname" required>
                <button type="submit">Change Nickname</button>
            </form>
        </div>

        <div class="form-box">
            <form action="../controls/changePassword.cntrl.php" method="POST">
                <h5>Change Password</h5>

                <input type="password" name="current_password" id="current_password" autocomplete="current_password"
                    placeholder="Enter current password" required>

                <input type="password" name="password" id="password" placeholder="Enter new password" autocomplete="password" required>

                <input type="password" name="confirm_password" id="confirm_password" placeholder="Confirm new password" autocomplete="password"
                    required>

                <button type="submit">Change Password</button>
                <?php if (isset($_GET['passwordSuccess'])): ?>
                    <p style="color: green;"><?= htmlspecialchars($_GET['passwordSuccess']); ?></p>
                <?php elseif (isset($_GET['passwordError'])): ?>
                    <p style="color: red;"><?= htmlspecialchars($_GET['passwordError']); ?></p>
                <?php endif; ?>
            </form>
        </div>

        <div class="form-box">
            <form action="../controls/redeemCoins.cntrl.php" method="POST">
                <h5>Redeem Voucher</h5>

                <input type="text" name="voucher" id="voucher" placeholder="Enter voucher code" required>

                <button type="submit">Redeem Coins!</button>
                <?php if (isset($_GET['voucherSuccess'])): ?>
                    <p style="color: green;"><?= htmlspecialchars($_GET['voucherSuccess']); ?></p>
                <?php elseif (isset($_GET['voucherError'])): ?>
                    <p style="color: red;"><?= htmlspecialchars($_GET['voucherError']); ?></p>
                <?php endif; ?>
            </form>
        </div>

    </div>

</body>

</html>