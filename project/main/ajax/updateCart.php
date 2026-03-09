<?php
    // Backend: PHP + MySQL code
    session_start();
    require_once '../../connect.php';

    header('Content-Type: application/json');

    // If ever user is a guest
    $userId = $_SESSION['userId'] ?? null; 
    $user_session = session_id();
    

    // c = cart
    // ci = cart_items
    // p = press_on
    // cz = user_custom_sizes
    //Prepares an SQL statement to be executed by the execute() method
    $statement = $DB->prepare("SELECT ci.cart_item_id, ci.prod_id, ci.quantity,
        ci.nail_size, ci.nail_length, ci.nail_shape, ci.price, ci.custom_size_id, 
        c.cart_id, c.user_session, c.cart_status,  cz.*,
        p.prod_name, p.prod_default_image, p.prod_image, p.prod_discount 
        FROM cart c JOIN cart_items ci ON c.cart_id = ci.cart_id 
        LEFT JOIN user_custom_sizes cz ON ci.custom_size_id = cz.custom_size_id 
        JOIN press_on p ON ci.prod_id = p.prod_id WHERE c.cart_status = 'active'
        AND ((c.id = :userId AND :userId IS NOT NULL) OR (c.user_session = :user_session AND :userId IS NULL)
      )"); 

    $statement->bindValue(':userId', $userId, $userId ? PDO::PARAM_INT : PDO::PARAM_NULL);
    $statement->bindValue(':user_session', $user_session, PDO::PARAM_STR);

    //Executes a prepared statement
    $statement->execute();

    //Returns an array containing all of the remaining rows in the result set
    $cart = $statement->fetchAll(); 

    $shippingFee = 4.99;
    $voucher = $subtotal ?? 0;
    $subtotal = $subtotal ?? 0;
    $quantity = $quantity ?? 0;
    $total = $quantity ?? 0;
    $totalDiscounted = $totalDiscounted ?? 0;
    

    $action = $_POST['action'] ?? '';
    $cart_item_id = $_POST['cart_item_id'] ?? 0 ;
    $quantity = $_POST['quantity'] ?? 1;

    if(isset($_POST['cart_item_id'])){
        switch ($action) {
            case 'remove' :
                $statement = $DB->prepare(" DELETE FROM cart_items WHERE cart_item_id = :cart_item_id");

                $statement->bindValue(':cart_item_id', $cart_item_id, PDO::PARAM_INT);
                $statement->execute();
                break;

            case 'changeQty':
                $statement = $DB->prepare(" UPDATE cart_items SET quantity = :quantity WHERE cart_item_id = :cart_item_id");
                
                $statement->bindValue(':quantity', $quantity, PDO::PARAM_INT);
                $statement->bindValue(':cart_item_id', $cart_item_id, PDO::PARAM_INT);
                $statement->execute();
                break;
        }
        exit;
    }
    
if ($action === 'voucher') {
    $subtotal = (float)($_POST['subtotal'] ?? 0);
    $appliedVoucher = strtoupper(trim($_POST['voucher_code'] ?? $_POST['voucher'] ?? ''));

    unset($_SESSION['voucherId']);
    unset($_SESSION['appliedVoucher']);
    unset($_SESSION['appliedVoucherDiscount']);

    if(empty($appliedVoucher)){
        $voucherErr = "Please enter a voucher!";
    }
    else{
        $statement = $DB->prepare("SELECT * FROM voucher WHERE voucher_code = :appliedVoucher ");
        $statement->bindValue(':appliedVoucher', $appliedVoucher,   PDO::PARAM_STR);
        $statement->execute();
        $v = $statement->fetch(PDO::FETCH_ASSOC);
        $currentDateTime = date('Y-m-d H:i:s');
        

        if(!$v){
            $voucherErr = "Invalid voucher code";
        }
        else if($v['expires_at'] !== null && $v['expires_at'] < $currentDateTime){
            $voucherErr = "This voucher has already expired.";
        }
        else{
            $voucherId = $v['voucher_id'];
            $voucherType = $v['voucher_type'];
            $min_order = $v['min_order'];
            $voucherDiscount = $v['voucher_discount'];

            switch($voucherType){
                // Voucher for Registered User
                case "registered" :
                    if(!$userId){
                        $voucherErr = "You must be a registered user to claim this voucher";
                        break;
                    }
                    else{
                        $min_order = 0;
                    }
                break;

                // Voucher for Birthday User
                case "birthday" :
                    if(!$userId){
                        $voucherErr = "You must be logged in to claim this voucher";
                        break;
                    }
                    // Get birth month
                    $birthMonth = date('m', strtotime($user['birthday']));
                    $currentMonth = date('m');
                    
                    if($birthMonth !== $currentMonth){
                        $voucherErr = "This voucher is only valid during your birth month";
                    }
                break;  

                default: 
                    break;
            }
            // Must meet minimun order
            if(empty($voucherErr) && $subtotal < $min_order){
                $voucherErr = "You must meet the minimum order of £" . $min_order . " to apply this voucher";
            }
        }
    }
    if (empty($voucherErr)) {
        //  validate if voucher requires login
        if (($voucherType === 'registered' || $voucherType === 'birthday') && !$userId) {
            $voucherErr = "This voucher is for registered users only.";
        }
    }

    if(empty($voucherErr)){
        // Check voucher claim if exists
        if($userId){
            $statement = $DB->prepare("SELECT claim_id , claim_status FROM voucher_claim 
                WHERE id = :userId AND voucher_id = :voucherId LIMIT 1");

            $statement->bindValue(':userId', $userId,   PDO::PARAM_INT);
        }
        else{
            $statement = $DB->prepare("SELECT claim_id , claim_status FROM voucher_claim 
                WHERE session_id = :user_session AND voucher_id = :voucherId LIMIT 1");

            $statement->bindValue(':user_session', $user_session,   PDO::PARAM_STR);
        }

        $statement->bindValue(':voucherId', $voucherId,   PDO::PARAM_INT);
        $statement->execute();
        $c = $statement->fetch(PDO::FETCH_ASSOC);

        // Check claim status
        if($c){
            $claim_status = $c['claim_status'];
            // If claimed then unset
            if($claim_status === 'claimed'){
                $voucherErr = "You have already claimed this voucher.";
                unset($_SESSION['voucherId']);
                unset($_SESSION['appliedVoucher']);
                unset($_SESSION['appliedVoucherDiscount']);
            }
            // Else applied
            else {
                $voucherSuccess = "Voucher successfully applied!";
                $_SESSION['voucherId'] = $voucherId;
                $_SESSION['appliedVoucher'] = $appliedVoucher;
                $_SESSION['appliedVoucherDiscount'] = $voucherDiscount; 
            }
        }
        // Insert voucher to voucher claim db if not existing yet
        else{
            $statement = $DB->prepare("INSERT INTO voucher_claim (voucher_id, id, session_id, claim_status)
                VALUES (:voucherId, :userId, :user_session, :claim_status)");
            $statement->bindValue(':voucherId', $voucherId,   PDO::PARAM_INT);

            if ($userId) {
                $statement->bindValue(':userId', (int)$userId, PDO::PARAM_INT);
                $statement->bindValue(':user_session', null, PDO::PARAM_NULL);
            } else {
                $statement->bindValue(':userId', null, PDO::PARAM_NULL);
                $statement->bindValue(':user_session', $user_session, PDO::PARAM_STR);
            }

            $statement->bindValue(':claim_status', "applied",   PDO::PARAM_STR);
            $statement->execute();

            $voucherSuccess= "Voucher successfully applied!";
            $_SESSION['voucherId'] = $voucherId;
            $_SESSION['appliedVoucher'] = $appliedVoucher;
            $_SESSION['appliedVoucherDiscount'] = $voucherDiscount;
        }

    }


    if(!empty($voucherErr)){
    echo json_encode([
        "success" => false,
        "message" => $voucherErr
    ]);
     exit;
     }
    
    else{
        echo json_encode([
        "success" => true,
        "message" => $voucherSuccess ?: "Voucher successfully applied!",
        "voucher_code" => $appliedVoucher,
        "voucher_discount" => (float)$voucherDiscount
    ]);
    exit;}
}
?>