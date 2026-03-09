<?php
    session_start();
    require_once '../connect.php';

    include '../main/section/cartOrderHeader.php';                              

    //Update order status
    if(isset($_POST['updateStatus'])){
        $orderId = $_POST['orderId'];
        $newStatus = $_POST['newStatus'];

        $statement = $DB->prepare(" UPDATE orders SET order_status = :newStatus 
            WHERE order_id = :orderId ");

        $statement->bindValue(':newStatus', $newStatus, PDO::PARAM_STR);
        $statement->bindValue(':orderId', $orderId, PDO::PARAM_INT);
        $statement->execute();

        header('Location: orders.php'); 
        exit();
    }
?>


<!DOCTYPE html>
<html lang="en">
<?php include '../main/php/head.php';?>   
    <body>
    <?php if(isset($_GET['order_id'])) :?>
        <?php
            $orderId = (int)$_GET['order_id'];
            foreach ($cartOrder as $co) {
                if ($co['order']['order_id'] == $orderId) {
                    $selectedOrder = $co;
                    break;
                }
            }
            
            if ($orderId <= 0){ 
                $_SESSION['errors'] .= "Order Id is not found";
                header('Location: ' .$_SERVER('PHP_SELF')); 
                exit();
            }
        ?>
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const getModal = document.getElementById('orderModal');
            const modal = new bootstrap.Modal(getModal);
            modal.show();
        });
        </script>
        <!-- Modal -->
        <div class="modal fade" id="orderModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="orderModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-1" id="orderModalLabel">Order Details</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Order Items Content -->
                    <div class="modal-body">
                        <?php if($selectedOrder): ?>
                            <?php
                                $order = $selectedOrder['order'];
                                $items = $selectedOrder['items'];
                            ?>
                            <?php include '../main/section/cartOrder.php';?>                               
                        <?php else: ?>
                                <p class="text-danger"> No items found</p>
                        <?php endif; ?>
                    </div>
                    <!-- Modal Footer Buttons -->
                    <div class="modal-footer">
                        <!-- Add Admin Button -->
                        <form method="post" class="row g-2 needs-validation" novalidate>
                            <input type="hidden" name="orderId" value="<?= $orderId ?>">
                            <button type="button" class="w-100 btn btn-primary" data-bs-dismiss="modal">Back</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
        <?php include 'admin-nav.php';?>
        <main>
            <!-- Order Dashboard -->
            <div class="container-lg">
               <div class="row gap-3">
                    <div class="col-12">
                        <!-- Order List -->
                        <div id="orderListCon">
                            <div class="d-flex justify-content-between">
                                <h2><?= $orderTitle ?></h2>
                                 <!-- Filter By Dropdown -->
                                <div class="dropdown">
                                    <button class="dropdown-toggle no-bg" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Filter
                                    </button>
                                    <ul class="dropdown-menu">
                                        <?php foreach($statusOrder as $status):?>
                                                <li>
                                                    <a href="?order_status=<?= urlencode($status); ?>" class="dropdown-item">
                                                        <?= ucfirst($status); ?>
                                                    </a>
                                                </li>
                                        <?php endforeach; ?>
                                        <li>
                                            <a href="orders.php" class="dropdown-item">
                                                All
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <small>Result Found: <?= $countOrder ?></small>
                    </div>
                    <div class="col-12">
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
                                    echo '<tbody>';
                                foreach($cartOrder as $o){
                                    $order = $o['order'];
                                    $items = $o['items'];
                                        echo '<tr>';
                                        echo '<td> '.$order['order_number'] .'</td>';
                                        echo '<td> '.$order['order_date'] .'</td>';
                                        echo '<td> '.$order['fname'] .' '.$order['lname'] .'</td>';
                                        echo '<td> '.$order['total_items'] .'</td>';
                                        echo '<td> '.$order['total'] .'</td>';
                                        echo '<td class="text-capitalize">
                                                <h4 class="badge bg-'.$statusBadgeColors[$order['order_status']].'">
                                                        '.$order['order_status'].'
                                                </h4>
                                                </td>';
                                        echo '<td class="no-underline"> 
                                                <form method="get">
                                                    <input type="hidden" name="order_id" value="'.(int)$order['order_id'].'">
                                                    <button type="submit" class="no-bg">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </td>';
                                    echo '</tr>';
                                }
                                echo '</tbody>';
                            }else{
                                echo '<h5 class="text-center text-danger"> No result Found!</h5>';
                            }
                            echo '</table
                                </div>
                            ';
                        ?>
                    </div>
                </div>
                
            </div>
        </main>
    </body>
    <?php include '../main/php/script.php';?>
</body>
</html>
