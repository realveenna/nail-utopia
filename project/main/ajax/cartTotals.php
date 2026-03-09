<?php
    session_start();
    require_once '../../connect.php';

    $subtotal = $_POST['subtotal'] ?? 0;
    $shippingFee = $_POST['shippingFee'] ?? 0;
    $voucherTotal = $_POST['voucherTotal'] ?? 0;
    $total = $_POST['total'] ?? 0;
    $quantity = $_POST['quantity'] ?? 0;

    // Save into session
    $_SESSION['subtotal'] = (float)$subtotal;
    $_SESSION['shippingFee'] = (float)$shippingFee;
    $_SESSION['voucherTotal'] = (float)$voucherTotal;
    $_SESSION['total'] = (float)$total;
    $_SESSION['totalItems'] = (int)$quantity;

?>