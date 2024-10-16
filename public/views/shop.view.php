<?php
include_once "../projects.all.php";

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
}

$currentUser = $_SESSION['user'];
$userWithCoins = $user_handler->getUserWithCoins($currentUser['id']);

$coins = isset($userWithCoins['coins']) ? $userWithCoins['coins'] : 0;

$products = $user_handler->getAllProducts();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
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

        .coins-box {
            background-color: yellow;
            padding: 5px 10px;
            border-radius: 5px;
        }

        .coins-box a {
            text-decoration: none;
            color: black;
            font-weight: bold;
        }

        .shop-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: flex-start;
            padding: 20px;
            max-height: 84vh;
            overflow-y: auto;
            border: 1px solid #ddd;
            border-radius: 10px;
        }

        .product-box {
            background-color: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 120px;
            margin: 10px;
        }

        .product-box img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 5px;
        }

        .product-box h1 {
            margin: 0;
            font-size: 13px;
        }

        .product-box p {
            margin: 0;
            font-size: 12px;
            color: #555;
            margin-bottom: 5px;
        }

        .product-box button {
            padding: 8px 13px;
            background-color: #007bff;
            width: 100%;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 13px;
        }

        .product-box button i {
            margin-right: 5px;
        }

        .product-box button:hover {
            background-color: #0056b3;
        }

        .no-products {
            text-align: center;
            color: #aaa;
            font-size: 18px;
            margin: auto;
            padding: 20px;
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
                <?= htmlspecialchars($currentUser['username']); ?>
            </div>

            <a href='../logout.php'>
                <div class="box h panel-negative m">Logout</div>
            </a>
        </div>
    </div>
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">Purchase completed successfully!</div>
    <?php elseif (isset($_GET['error'])): ?>
        <?php if ($_GET['error'] == 'insufficient_coins'): ?>
            <div class="alert alert-danger">You don't have enough coins to buy this product.</div>
        <?php elseif ($_GET['error'] == 'product_not_found'): ?>
            <div class="alert alert-danger">Product not found.</div>
        <?php elseif ($_GET['error'] == 'invalid_product'): ?>
            <div class="alert alert-danger">Invalid product.</div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="shop-container">
        <?php if (empty($products)): ?>
            <div class="no-products">No products available.</div>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <div class="product-box">
                    <img src="../storage/<?= htmlspecialchars($product['product_image']) ?>" alt="<?= htmlspecialchars($product['product_name']) ?>">
                    <h1><?= htmlspecialchars($product['product_name']) ?></h1>
                    <p><?= htmlspecialchars($product['price']) ?> Coins</p>

                    <form action="../controls/buy_product.cntrl.php" method="POST">
                        <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                        <button type="submit">
                            <i class="fas fa-shopping-cart"></i> Buy Now
                        </button>
                    </form>
                </div>
            <?php endforeach; ?>

        <?php endif; ?>
    </div>


    <?php include_once "../components/navigation.cmp.php"; ?>
</body>

</html>