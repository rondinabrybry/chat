<?php
include_once "../../public/projects.all.php";
if (!isset($_SESSION['user']) || $_SESSION['user']['user_type'] !== 'admin') {
    header("Location: ../../public/login.php");
    exit();
}

include_once "../../public/classes/user.class.php";
$user_handler = new UserHandler();

$users = $user_handler->getAllUsersWithProfile(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Home</title>

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
        }

        .header h2 {
            margin: 0;
            font-size: 18px;
        }

        .navigation {
            display: flex;
            justify-content: space-around;
            padding: 10px 0;
            background-color: #f8f8f8;
            border-top: 1px solid #ddd;
        }

        .navigation a {
            text-align: center;
            flex-grow: 1;
            text-decoration: none;
            color: #007bff;
            font-size: 14px;
        }

        .navigation a i {
            display: block;
            margin: 0 auto 5px;
            font-size: 24px;
        }

        .table-container {
            padding: 20px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<div class="header">
    <h2>AOC</h2>
    <div style="background-color: yellow; padding: 5px; display: flex; align-items: center;">
    <?= htmlspecialchars($_SESSION['user']['user_type']) ?>&nbsp;<?= htmlspecialchars($_SESSION['user']['username']) ?>
    </div>
    <a href='../../public/logout.php'>Logout</a>
</div>

<h3>All Users</h3>
    <div class="table-container">
        
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Gender</th>
                    <th>Coins</th>
                    <th>Nickname</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($users): ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= htmlspecialchars($user['username']) ?></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><?= htmlspecialchars($user['gender']) ?></td>
                            <td><?= htmlspecialchars($user['coins']) ?></td>
                            <td><?= htmlspecialchars($user['nickname']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">No users found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    
    <div class="navigation">
        <a href="#">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </a>
        <a href="#">
            <i class="fas fa-user"></i>
            <span>Users</span>
        </a>
        <a href="voucher_list.view.php">
            <i class="fas fa-store"></i>
            <span>Vouchers</span>
        </a>
    </div>
</body>
</html>