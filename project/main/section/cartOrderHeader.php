<?php
    $statusBadgeColors = [
        'confirmed'  => 'warning',
        'pending'  => 'danger',
        'delivered'  => 'success',
        'canceled'   => 'secondary'
    ];
    $statusOrder = ['pending', 'confirmed', 'delivered', 'canceled'];

    $statusFilter = $_GET['order_status'] ?? null;

    $sql = " SELECT c.cart_id, c.created_at, c.cart_status,
            o.*, a.*, 
            u.id,
            u.fname,
            u.lname,
            u.email
            FROM cart c
            INNER JOIN orders o ON c.cart_id = o.cart_id
            INNER JOIN addresses a ON a.address_id = o.address_id
            INNER JOIN userLogin u ON c.id = u.id 
            WHERE c.cart_status = 'ordered'";

    if(isset($_SESSION['userType']) &&  $_SESSION['userType'] !== 'admin' && $_SESSION['userType'] !== 'staff'){
        $sql .= " AND u.id = :userId";
    }
    if($statusFilter){
        $sql .= " AND o.order_status = :statusFilter";
    }

    $statement = $DB->prepare($sql);

    if(isset($_SESSION['userType']) &&  $_SESSION['userType'] !== 'admin' && $_SESSION['userType'] !== 'staff'){
        $statement->bindValue(':userId', $userId, PDO::PARAM_INT);
    }
    if ($statusFilter) {
        $statement->bindValue(':statusFilter', $statusFilter, PDO::PARAM_STR);
    }
    $statement->execute();
    $orders = $statement->fetchALL(PDO::FETCH_ASSOC);
    $countOrder = count($orders);

    $cartOrder = [];

    if(!empty($orders)){
        $itemsStmt = $DB->prepare("SELECT ci.cart_item_id, ci.prod_id, ci.quantity,
            ci.nail_size, ci.nail_length, ci.nail_shape, ci.price, ci.custom_size_id,
            cz.*,
            p.prod_name, p.prod_default_image, p.prod_image, p.prod_discount
            FROM cart_items ci
            LEFT JOIN user_custom_sizes cz ON ci.custom_size_id = cz.custom_size_id
            LEFT JOIN press_on p ON ci.prod_id = p.prod_id
            WHERE ci.cart_id = :cart_id");


        foreach($orders as $o){
            $cartId = $o['cart_id'];

            $itemsStmt->bindValue(':cart_id', $cartId, PDO::PARAM_INT);
            $itemsStmt->execute();
            $items = $itemsStmt->fetchAll(PDO::FETCH_ASSOC);

            $cartOrder[] = [
                'order'   => $o,
                'items'   => $items
            ];
        }
    }
    $orderTitle = $_GET['order_status'] ?? 'all';
    switch($orderTitle){
        case 'pending':
            $orderTitle = "Pending Orders";
            break;

        case 'confirmed':
            $orderTitle = "Confirmed Orders";
            break;

        case 'delivered':
            $orderTitle = "Delivered Orders";
            break;

        case 'canceled':
            $orderTitle = "Canceled Orders";
            break;

        default:
            $orderTitle = "View All Orders";
    }
?>
