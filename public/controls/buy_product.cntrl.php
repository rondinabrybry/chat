<?php
include_once "../projects.all.php";

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
}

$currentUser = $_SESSION['user'];
$productId = isset($_POST['product_id']) ? (int)$_POST['product_id'] : null;
$user_handler = new UserHandler();
if (!$productId) {
    header("Location: ../views/shop.view.php?error=invalid_product");
    exit;
}
$product = $user_handler->getProductById($productId);

if (!$product) {
    header("Location: ../views/shop.view.php?error=product_not_found");
    exit;
}

$userWithCoins = $user_handler->getUserWithCoins($currentUser['id']);
$userInboxLimit = $user_handler->getUserInboxLimit($currentUser['id']);
$coins = $userWithCoins['coins'];
$inboxLimit = $userInboxLimit['inbox_limit'];

if ($coins >= $product['price']) {
    $newCoins = $coins - $product['price'];
    $user_handler->deductUserCoins($currentUser['id'], $newCoins);

    $newInboxLimit = $inboxLimit + 1;
    $user_handler->updateInboxLimit($currentUser['id'], $newInboxLimit);

    header("Location: ../views/shop.view.php?success=purchase_complete");
} else {
    header("Location: ../views/shop.view.php?error=insufficient_coins");
}
exit;