<?php
    $today = date('Y-m-d');

    $voucherCode = $_POST['voucherCode'];
    $discount = $_POST['discount'];
    $expiresAt = $_POST['expiresAt'] ?? null; 
    $startAt = $_POST['startAt'] ?? $today; 
    $minOrder = $_POST['minOrder'];
    $voucherType = $_POST['voucherType'];

    
    if(empty($voucherCode)){
        $voucherCodeErr = "Please enter a voucher code.";
    }
    if(empty($discount)){
        $discountErr = "Please enter a discount.";
    }
    else if($discount < 0 || $discount > 100){
        $discountErr = "Please enter a valid discount! eg: 15, 10, 20";
    }
    if(empty($minOrder)){
        $minOrderErr = "Please enter a minimum order.";
    }
    elseif($minOrder < 0 ){
        $minOrderErr = "Please enter a positive number.";
    }
    if(empty($voucherType) || $voucherType === null){
        $voucherTypeErr = "Please select a voucher type.";
    }

    if(empty($startAt)){
        $startAtErr = 'Please enter start date for this voucher';
    }

    if(!empty($expiresAt)){
        if($expiresAt <= $startAt){
            $expiresAtErr = 'Expire date must be set on future date.';
        }
        else{
            $expiresAt = $expiresAt  .' 23:59:59';
        }
    }
    else{
        $expiresAt = null;
    }
?>
