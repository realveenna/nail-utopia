<?php
    session_start();
    require_once '../connect.php';

    $statusBadgeColors = [
        'confirmed'  => 'info',
        'pending'  => 'warning',
        'delivered'  => 'success',
        'canceled'   => 'danger'
    ];

    $statement = $DB->prepare(" SELECT c.cart_id, c.created_at, c.cart_status,
        o.*, a.*, 
        u.id AS user_id,
        u.fname,
        u.lname,
        u.email
        FROM cart c
        INNER JOIN orders o ON c.cart_id = o.cart_id
        INNER JOIN addresses a ON a.address_id = o.address_id
        INNER JOIN userLogin u ON c.id = u.id
    ");

    $statement->execute();
    $orders = $statement->fetchALL(PDO::FETCH_ASSOC);

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
?>


<!DOCTYPE html>
<html lang="en">
<?php include '../main/php/head.php';?>   
    <body>
        <?php include 'admin-nav.php';?>
        <main>
            <!-- View Single Order -->
            <div class="container-lg">
               <div class="row g-3 g-md-4 ">
                    <div class="col-12 col-lg">
                        <!-- Order List -->
                        <div id="orderListCon">
                            <div class="text-left">
                                <h2>All Orders</h2>
                            </div>
                                <?php
                                    if($cartOrder){
                                        echo' 
                                        <div class="table-responsive">
                                            <table class="table text-center table-hover">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="text-main">Order #</th>
                                                        <th scope="col" class="text-main">Date</th>
                                                        <th scope="col" class="text-main">Customer</th>
                                                        <th scope="col" class="text-main">Total Items</th>
                                                        <th scope="col" class="text-main">Total</th>
                                                        <th scope="col" class="text-main">Status</th>
                                                        <th scope="col" class="text-main">Action</th>
                                                    </tr>
                                                </thead>';
                                        foreach($cartOrder as $o){
                                            $order = $o['order'];
                                            $items = $o['items'];
                                            echo '<tbody>';
                                                echo '<tr>';
                                                    echo '<td> '.$order['order_number'] .'</td>';
                                                    echo '<td> '.$order['order_date'] .'</td>';
                                                    echo '<td> '.$order['fname'] .' '.$order['lname'] .'</td>';
                                                    echo '<td> '.$order['total_items'] .'</td>';
                                                    echo '<td> '.$order['total'] .'</td>';
                                                    echo '<td class="text-capitalize"><h5> <span class="badge bg-'.$statusBadgeColors[$order['order_status']].'">
                                                                    '.$order['order_status'].'</h5>
                                                                </span>
                                                            </td>';
                                                    
                                                    echo '<td class="no-underline"> <a href="viewOrder.php?order_id=' . $order['order_id']. '">View Details</a></td>';
                                                echo '</tr>';
                                            echo '</tbody>';
                                        }
                                    }else{
                                        echo "No result Found";
                                    }
                                    echo '</table>
                                        </div>
                                    ';
                                ?>
                        </div>
                    </div>
                </div>
                
            </div>
        </main>
    </body>
    <?php include '../main/php/script.php';?>
</body>
</html>
