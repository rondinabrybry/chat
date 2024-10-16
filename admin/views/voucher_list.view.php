<?php
include_once "../../public/projects.all.php";
include_once "../../public/classes/user.class.php"; 
$user_handler = new UserHandler();

if (!isset($_SESSION['user']) || $_SESSION['user']['user_type'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $numberOfCodes = (int)$_POST['number_of_codes'];
    $voucherValue = (int)$_POST['voucher_value'];

    for ($i = 0; $i < $numberOfCodes; $i++) {
        $voucherCode = generateRandomCode(5);
        $user_handler->addVoucher($voucherCode, $voucherValue); 
    }

    $successMessage = "Successfully generated $numberOfCodes voucher codes.";
}

function generateRandomCode($length) {
    return substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, $length);
}

$vouchers = $user_handler->getAllVouchers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voucher Management</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            min-height: 100vh;
            background-color: #f0f0f0;
        }

        .header {
            padding: 10px;
            background-color: #007bff;
            color: #ffffff;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h2 {
            margin: 0;
            font-size: 20px;
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

        .content {
            padding: 20px;
            flex-grow: 1;
        }

        .form-container {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .form-container h3 {
            margin-top: 0;
        }

        .form-container label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-container input[type="number"] {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-container button {
            padding: 10px 15px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-container button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: #ffffff;
        }

        tr:hover {
            background-color: #f1f1f1;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Voucher Management</h2>
        <a href="../logout.php" style="color: #fff;">Logout</a>
    </div>

    <div class="content">
        <div class="form-container">
            <h3>Generate New Vouchers</h3>
            
            <?php if (isset($successMessage)): ?>
                <p style="color: green;"><?= $successMessage; ?></p>
            <?php endif; ?>

            <form action="voucher.view.php" method="POST">
                <label for="number_of_codes">Number of Codes to Generate:</label>
                <input type="number" name="number_of_codes" id="number_of_codes" required>

                <label for="voucher_value">Voucher Value:</label>
                <input type="number" name="voucher_value" id="voucher_value" required>

                <button type="submit">Generate Vouchers</button>
            </form>
        </div>

        <h3>All Vouchers</h3>

        <?php if (empty($vouchers)): ?>
            <p>No vouchers available.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Voucher Code</th>
                        <th>Voucher Value</th>
                        <th>Expired</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($vouchers as $voucher): ?>
                        <tr>
                            <td><?= htmlspecialchars($voucher['id']); ?></td>
                            <td><?= htmlspecialchars($voucher['voucher_code']); ?></td>
                            <td><?= htmlspecialchars($voucher['voucher_value']); ?></td>
                            <td><?= htmlspecialchars($voucher['expired'] ? 'Yes' : 'No'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <div class="navigation">
        <a href="admin.view.php">
            <i class="fas fa-home"></i>
            <span>Home</span>
        </a>
        <a href="#">
            <i class="fas fa-user"></i>
            <span>Users</span>
        </a>
        <a href="voucher.view.php">
            <i class="fas fa-store"></i>
            <span>Vouchers</span>
        </a>
    </div>
</body>
</html>
