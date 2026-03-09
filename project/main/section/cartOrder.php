<!-- Modal view Cart Order -->
<?php
    $statusOrder = ['pending', 'confirmed', 'delivered', 'canceled'];
?>
<?php if(isset($_SESSION['userType']) && ($_SESSION['userType'] === 'admin' || $_SESSION['userType'] === 'staff')): ?>
    <div class="d-flex gap-3 align-items-center justify-content-start mb-2">
        <p>Status: </p>
        <div class="btn-group">
            <button type="button" class="btn btn-<?=$statusBadgeColors[$order['order_status']]?> dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                <?=ucfirst($order['order_status'])?>
            </button>
            <ul class="dropdown-menu">
            <?php foreach($statusOrder as $status):?>
                    <?php if($status !== $order['order_status']): ?>
                        <li>
                            <form method="post">
                                <input type="hidden" name="orderId" value="<?= $order['order_id']; ?>">
                                <input type="hidden" name="newStatus" value="<?= $status; ?>">
                                <button type="submit" name="updateStatus" class="dropdown-item">
                                    <?= ucfirst($status); ?>
                                </button>
                            </form>
                        </li>
                    <?php endif; ?>
            <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>
<?php
    echo '                       
        <div class="col-12">
            <div class="d-flex align-items-center justify-content-between">
                <div>';
                if(isset($_SESSION['userType']) && $_SESSION['userType'] !== 'admin' && $_SESSION['userType'] !== 'staff'){
                    echo'
                        <h5 class="text-capitalize"> 
                            <span class="badge bg-'.$statusBadgeColors[$order['order_status']].'">
                                '.$order['order_status'].'
                            </span>
                        </h5>';
                }
                echo'
                    <h6 class="text-muted"> Order Number: '.$order['order_number'].'</h6>
                </div>
                <h6> Total Items: '.$order['total_items'].'</h6>
            </div>
        </div>
        '; 
?>



<!-- Order details -->
<?php foreach ($items as $i): ?>
    <div class="row item-container g-3 position-relative">
        <div class="col-12 col-sm-6 cart-image p-0">
            <?php
                $image = json_decode($i['prod_default_image']);
                if($image){
                    echo '<img src="' . $image . '" alt="' .$i['prod_name']. '" class="single">';
                }
            ?>
        </div>
        <div class="col-12 col-sm-6 text-start d-flex flex-column justify-content-end align-items-start gap-3 gap-sm-5">
            <div class="d-flex flex-column justify-content-end align-items-start gap-3">
                <div>
                    <!-- Product size length shape -->
                    <h5 class="fw-bold"><?= $i['prod_name'] ?></h5>
                    <strong class="item-price" data-unit-price="<?=(float)$i['price']?>">
                        £<?=number_format((float)$i['price'] * $i['quantity'],2)?></strong>
                    </div>
                <div class="d-flex gap-2">
                    <p><?= $i['nail_shape'] ?></p> | 
                    <p>Length: <?= $i['nail_length'] ?></p> |
                    <p>Size: <?= $i['nail_size'] ?></p>
                </div>
                <?php if($i['nail_size'] == "Custom"): ?>
                    <div>
                    <div class="d-flex gap-1">
                        <p>Left:</p>
                        <?= $i['l_thumb'] ?>,
                        <?= $i['l_index'] ?>,
                        <?= $i['l_middle'] ?>,
                        <?= $i['l_ring'] ?>,
                        <?= $i['l_pinky'] ?>
                    </div>
                    <div class="d-flex gap-1">
                        <p>Right:</p>
                        <?= $i['r_thumb'] ?>,
                        <?= $i['r_index'] ?>,
                        <?= $i['r_middle'] ?>,
                        <?= $i['r_ring'] ?>,
                        <?= $i['r_pinky'] ?>
                    </div>
                </div>
                <?php endif;?>
            </div>
        </div>
    </div>
<?php endforeach; ?>


<?php
    echo'
        <div class="d-flex flex-wrap gap-5 pt-4">
            <div>
                <h6>Contact Details: </h6>
                <p class="text-muted d-block">'. $order['fname'] .' '. $order['lname'] .'</p>
                <p class="text-muted d-block">'. $order['email'] .'</p>
            </div>
            <div>
                <h6>Delivery Details: </h6>
                <p class="text-muted d-block">'. $order['line_1'] .'</p>
                <p class="text-muted d-block">'. $order['line_2'] .'</p>
                <p class="text-muted d-block">'. $order['city'] .'</p>
                <p class="text-muted d-block">'. $order['country'] .'</p>
                <p class="text-muted d-block">'. $order['postcode'] .'</p>
            </div>
            <div>
                <h6>Order Breakdown:</h6>
                <p class="text-muted d-block">Subtotal: £ '. number_format((float)$order['subtotal'], 2) .'</p>
                <p class="text-muted d-block">Shipping Fee: £ '. number_format((float)$order['shipping_fee'], 2) .'</p>
                <p class="text-muted d-block">Total Discounted £ '. number_format((float)$order['discount'], 2) .'</p>
                <strong> Total '.$order['total'].'</strong>
            </div>
        </div>
    ';
?>
