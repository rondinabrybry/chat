<?php
include_once "../classes/user.class.php";
include_once "../projects.all.php";

session_start();
$user_handler = new UserHandler();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $voucher_code = $_POST['voucher'];
    $currentUser = $_SESSION['user'];

    $sql = "SELECT * FROM voucher WHERE voucher_code = ? AND expired = 0";
    $voucher = $user_handler->queryEmail($sql, [$voucher_code]);

    if ($voucher) {
        $voucher_value = $voucher['voucher_value'];
        $user_id = $currentUser['id'];

        $user_handler->updateUserCoins($user_id, $voucher_value);

        $user_handler->expireVoucher($voucher['id']);

        header("Location: ../views/settings.view.php?voucherSuccess=Redeem Successful");
        exit();
    } else {
        header("Location: ../views/settings.view.php?voucherError=Invalid voucher code.");
        exit();
    }
}
?>
