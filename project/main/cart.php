<?php 
    session_start();
    include '../connect.php';
        
    // If ever user is a guest
    $userId = $_SESSION['userId'] ?? null; 
    $sessionId = session_id();

    // Get cart id
    if($userId !== null){
        $statement = $DB->prepare("SELECT cart_id FROM cart WHERE cart_status = 'active' AND id = :userId");
        $statement->bindValue(':userId', $userId,PDO::PARAM_INT);
    }else{
        $statement = $DB->prepare("SELECT cart_id FROM cart WHERE cart_status = 'active' AND user_session = :sessionId");
        $statement->bindValue(':sessionId', $sessionId, PDO::PARAM_STR);
    }
    $statement->execute();
    $cart = $statement->fetch(PDO::FETCH_ASSOC);

    
    if(!$cart){
        $_SESSION['errors'] = 'Oops! Your cart is empty. Browse our collection and add your favourite nails before checking out.';
        header('Location: shop.php');
        exit(); 
    }

    // Set cart id
    $cartId = $cart['cart_id'];
    $_SESSION['cart_id'] = $cartId;

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
        JOIN press_on p ON ci.prod_id = p.prod_id WHERE c.cart_id = :cart_id"); 
    $statement->bindValue(':cart_id', $cartId , PDO::PARAM_INT);

    //Executes a prepared statement
    $statement->execute();

    //Returns an array containing all of the remaining rows in the result set
    $cartItems = $statement->fetchAll(PDO::FETCH_ASSOC); 

    if(!$cartItems){
        $_SESSION['errors'] = 'Oops! Your cart is empty. Browse our collection and add your favourite nails before checking out.';
        header('Location: shop.php');
        exit(); 
    }

    $shippingFee = 4.99;
    $voucher = 0;
    $subtotal = 0;
    $quantity = 0;
    $total = 0;
    $discountTotal = 0;
    $totalDiscounted =  0;
    $totalItems = $total ?? 0;

    $voucherErr = "";
    $voucherSuccess = "";
    $appliedVoucher = "";
    $voucherId = $_SESSION['voucherId'] ?? null; 


  
?>

<!DOCTYPE html>
<html lang="en">
<?php include './php/head.php';?>    
<body>
    <?php include './php/nav.php';?>   
   <main>
        <!-- Cart -->
        <div class="container-lg">
            <div class="row g-3 g-md-4">
                <!-- Cart Items -->
                <div class="col-12 col-xl-8">
                    <div class="form-box small-gap mb-3 py-4">
                        <h2>Your Shopping Cart:</h2>
                        <div class="row row-cols-4">
                            <?php if($cartItems):?>
                                <h6 class="col-12 text-start">Product Details</h6>
                            <?php else: ?>
                                <p class="text-center text-danger"> Your cart is empty.</p>
                            <?php endif; ?>
                        </div>
                        <?php foreach ($cartItems as $c): ?>
                            <div class="row row-cols-4 item-container" data-cart-item-id="<?= (int)$c['cart_item_id'] ?>">
                                <div class="col-12 col-sm-6 cart-image">
                                    <?php
                                        $image = json_decode($c['prod_default_image']);
                                        if($image){
                                            echo '<img src="' . $image . '" alt="' .$c['prod_name']. '" class="single">';
                                        }
                                    ?>
                                </div>
                                <div class="col-12 col-sm-6 text-start d-flex flex-column justify-content-end align-items-start gap-3 gap-sm-5">
                                    <div class="d-flex flex-column justify-content-end align-items-start gap-3">
                                        <div>
                                            <!-- Product size length shape -->
                                            <h5 class="fw-bold"><?= $c['prod_name'] ?></h5>
                                            <strong class="item-price" data-unit-price="<?=(float)$c['price']?>">
                                                £<?=number_format((float)$c['price'] * $c['quantity'],2)?></strong>
                                            <!-- Ajax Remove Item -->
                                            <p>
                                                <a href="#"
                                                class="text-muted cartRemoveItem"
                                                data-cart-item-id="<?= (int)$c['cart_item_id'] ?>">
                                                Remove
                                                </a>
                                            </p>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <p><?= $c['nail_shape'] ?></p> | 
                                            <p>Length: <?= $c['nail_length'] ?></p> |
                                            <p>Size: <?= $c['nail_size'] ?></p>
                                        </div>
                                        <?php if($c['nail_size'] == "Custom"): ?>
                                            <div>
                                            <div class="d-flex gap-1">
                                                <p>Left:</p>
                                                <?= $c['l_thumb'] ?>,
                                                <?= $c['l_index'] ?>,
                                                <?= $c['l_middle'] ?>,
                                                <?= $c['l_ring'] ?>,
                                                <?= $c['l_pinky'] ?>
                                            </div>
                                            <div class="d-flex gap-1">
                                                <p>Right:</p>
                                                <?= $c['r_thumb'] ?>,
                                                <?= $c['r_index'] ?>,
                                                <?= $c['r_middle'] ?>,
                                                <?= $c['r_ring'] ?>,
                                                <?= $c['r_pinky'] ?>
                                            </div>
                                        </div>
                                        <?php endif;?>
                                    </div>
                                
                                    <!-- quantity counter -->
                                    <div class="quantity">
                                        <button class="minus" aria-label="Decrease"  data-cart-item-id="<?= (int)$c['cart_item_id'] ?>">&minus;</button>
                                        <input type="number" class="input-counter" value="<?= $c['quantity'] ?>" min="1" max="10">
                                        <button class="plus" aria-label="Increase"  data-cart-item-id="<?= (int)$c['cart_item_id'] ?>">&plus;</button>
                                    </div>
                                </div>
                            </div>
                            <?php 
                                $quantity += $c['quantity'];
                                $subtotal += ($c['price'] * $c['quantity']);
                                $totalItems += $quantity;
                            ?>
                            <hr>
                        <?php endforeach; ?>
                        <!-- Calculate Total -->
                        <?php
                            if ($subtotal > 60 ){
                                $shippingFee = 0;
                            }   
                            if(isset($_SESSION['appliedVoucherDiscount'])){
                                $voucher = (float)$_SESSION['appliedVoucherDiscount'];
                                $voucherTotal = $subtotal * ($voucher / 100);
                            }
                            
                            $totalDiscounted =  $voucherTotal + $discountTotal;
                            $total =  $subtotal + $shippingFee - $totalDiscounted;
                        ?>
                    </div>
                </div>
                <!-- Cart Summary -->
                <?php if($quantity >= 1):?>
                <div class="col-12 col-xl">
                    <div class="secondary p-4 sticky px-4 py-3">
                        <div class="d-flex flex-column justify-content-between gap-5 w-auto">
                            <div>
                                <h2 class="text-center">Summary: </h2>
                                <hr>
                                    <div class="row gy-2 px-2 text-center">
                                        <div class="col-6 text-start">Total Items</div>
                                        <div class="col-6 text-end fw-bold" id="quantityID"><?= $quantity ?></div>

                                          <!-- Subtotal -->
                                        <div class="col-6 text-start">Subtotal</div>
                                        <div class="col-6 text-end fw-bold" id="subtotalID">£<?= number_format($subtotal, 2, '.', ',')?></div>

                                        <!-- Voucher text -->
                                        <div class="row px-0 d-none" id="voucherTextCon">
                                            <div class="col-6 text-start" id="voucherCodeText"><?= $_SESSION['appliedVoucher'] ?? ''?> </div>
                                            <div class="col-6 text-end fw-bold text-success" id="voucherID" 
                                                data-voucher="<?= $_SESSION['appliedVoucherDiscount'] ?? 0?>">
                                                -
                                                <?= $_SESSION['appliedVoucherDiscount'] ?? 0 ?>%
                                            </div>
                                        </div>

                                         <!-- Total Discounted -->
                                          <div class="row px-0 d-none" id="totalDiscountedRow">
                                            <div class="col-6 text-start">Total Discounted</div>
                                            <div class="col-6 text-end fw-bold text-danger" id="totalDiscountedID">-£<?= number_format($totalDiscounted, 2, '.', ',')?></div>
                                          </div>

                                        <!-- Shipping Fee -->
                                        <?php if($total > 1):?>
                                            <hr class="mb-0">
                                            <div class="col-6 text-start">Shipping Fee</div>
                                            <div class="col-6 text-end fw-bold" id="shippingFeeID">£<?= number_format($shippingFee, 2, '.')?></div>
                                        <?php endif ;?>
                                        
                                        <!-- Total -->
                                        <hr class="mb-0">
                                        <div class="col-6 text-start"><h4 class="fw-bold">Total</h4></div>
                                        <div class="col-6 text-end"><h4 class="fw-bold" id="totalID">£<?=  number_format($total, 2, '.', ',')?></h4></div>
                                        
                                        <!-- Voucher Form -->
                                        <hr class="mb-0">
                                        <form method="post" class="p-0 m-0 mt-2">
                                            <div class="row gx-2 p-0 m-0">
                                                <div class="col">
                                                    <input type="voucher" class="form-control"  name="voucher" id="voucherInput" placeholder="Add Voucher">
                                                </div>
                                                <div class="col-auto">
                                                    <button type="button"  id="addVoucherButton" class="btn btn-secondary mb-3" name="addVoucher"
                                                        value="addVoucher">Apply</button>
                                                </div>
                                                <div class="col-12">
                                                    <h6 class="error text-success text-start" id="voucherSuccess"><?php echo $voucherSuccess;?></h6>
                                                    <h6 class="error text-start" id="voucherErr"><?php echo $voucherErr;?></h6>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                            </div>
                            <form method="post" action="order.php" class="p-0 m-0 mt-2">
                                <button type="submit" class="btn btn-primary w-100" name="nextOrder">Next</button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endif;?>
            </div>
        </div>
        <?php     
            if($cart){
                $_SESSION['shippingFee'] = $shippingFee;
                $_SESSION['subtotal'] = $subtotal;
                $_SESSION['total'] = $total;
                $_SESSION['totalDiscounted'] = $totalDiscounted;
                $_SESSION['totalItems'] = $totalItems;
            }
        ?>
   </main>
    <?php include './php/footer.php';?>
    <?php include './php/script.php';?>
    <script>
        document.addEventListener("DOMContentLoaded", () => {

            window.onload = function() {
                updateSummary();
            };

            // Quantity Change
            document.addEventListener("click", function (event) {
            const qty = event.target.closest(".quantity .minus, .quantity .plus");
            if (!qty) return;
            const cartItemId = qty.dataset.cartItemId;

            const quantityContainer = qty.closest(".quantity");
            const minusBtn = quantityContainer.querySelector(".minus");
            const plusBtn = quantityContainer.querySelector(".plus");
            const quantityBox = quantityContainer.querySelector(".input-counter");

            const container = qty.closest(".item-container");
            const priceCon = container.querySelector(".item-price");

            const min = 1;
            const max = 10;

            //Set value
            let value = parseInt(quantityBox.value);

            // If not a valid int
            if (isNaN(value)) {
                value = min;
            }

            // Plus or minus
            if(qty.classList.contains("minus")){
                value = Math.max(value - 1, min);
            }
            if(qty.classList.contains("plus")){
                value = Math.min(value + 1, max);
            }
            // Update input box
            quantityBox.value = value;
            
            // Disabled the button
            if (value >= max){
                plusBtn.disabled;
            }
            if(value <= min){
                minusBtn.disabled;
            }
            const unitPrice = parseFloat(priceCon.dataset.unitPrice);
            const total = unitPrice * value;

            cartAction(
                "changeQty",
                { cart_item_id: cartItemId, quantity: value},
                () => {
                    priceCon.textContent = `£${total.toFixed(2)}`;
                    updateSummary();
                });

            });

            // Remove Item 
            document.querySelectorAll('.cartRemoveItem').forEach(item => {
                item.addEventListener('click', function () {
                    const cartItemId = this.dataset.cartItemId;
                    const container = this.closest('.item-container')
                    cartAction(
                        "remove",
                        { cart_item_id: cartItemId },
                        () => {
                            container.remove();
                            console.log("Item removed");
                            updateSummary();
                        }
                    )
                });    
            });

            // Set Cart Variables
            let quantity = 0;
            let shippingFee = 4.99;
            
             // Voucher
            let voucherDiscount = 0;
            let voucherTotal = 0;

            // Total
            let discountTotal = 0;
            let subtotal = 0;
            let total = 0;
            let totalDiscountAmount = 0;

            // Add voucher
            document.getElementById('addVoucherButton').addEventListener('click', function () {
                const voucherCode = document.getElementById('voucherInput').value.trim();
                const voucherDiscount = document.getElementById('voucherID');
                const voucherCodeText = document.getElementById('voucherCodeText');

                const voucherErr = document.getElementById('voucherErr');
                const voucherSuccess = document.getElementById('voucherSuccess');
                voucherSuccess.textContent = "";
                voucherErr.textContent = "";

                calculateCart();
                
                cartAction(
                    "voucher",
                    { voucher_code: voucherCode, subtotal: subtotal.toFixed(2) },
                    (data) => {
                        if (!data.success) {
                            console.log("error branch");
                            voucherErr.textContent = data.message;
                            voucherSuccess.textContent = "";

                            // reset voucher display
                            voucherDiscount.dataset.voucher = "";
                            voucherDiscount.textContent = "";
                            voucherCodeText.textContent = "";
                            updateSummary();
                            return;
                        }
                        else{
                        // Message Voucher
                        voucherSuccess.textContent = data.message;
                        voucherDiscount.dataset.voucher = data.voucher_discount;
                        voucherDiscount.textContent = `-${parseFloat(data.voucher_discount).toFixed(0)}%`;
                        voucherCodeText.textContent = data.voucher_code;
                        }
                        updateSummary();
                    }
                )
            });

            function calculateCart(){
                // Reset Cart Variables
                quantity = 0;
                shippingFee = 4.99;
                
                // Voucher
                voucherDiscount = 0;
                voucherTotal = 0;

                // Total
                discountTotal = 0;
                subtotal = 0;
                total = 0;
                totalDiscountAmount = 0;
                
                document.querySelectorAll('.item-container').forEach(container => {
                    const priceCon = container.querySelector('.item-price');
                    const quantityBox = container.querySelector('.input-counter');

                    const price = parseFloat(priceCon.dataset.unitPrice) || 0;
                    const qty = parseInt(quantityBox.value, 10) || 0;

                    quantity += qty;
                    subtotal += price * qty;
                });
                // Shipping 
                if(subtotal > 60){
                    shippingFee = 0;
                }

                // Voucher
                voucherDiscount = parseFloat(document.getElementById('voucherID')?.dataset.voucher || "0") || 0;
                voucherTotal = subtotal * (voucherDiscount / 100);

                // Total
                total = subtotal + shippingFee - voucherTotal;
                
                // Total Discounted
                totalDiscountAmount = voucherTotal + discountTotal;
            }

           function updateSummary() {
                calculateCart();

                // Update text
                document.getElementById('subtotalID').textContent = `£${subtotal.toFixed(2)}`;
                document.getElementById('quantityID').textContent = quantity;
                document.getElementById('shippingFeeID').textContent = `£${shippingFee.toFixed(2)}`;
                document.getElementById('totalID').textContent = `£${total.toFixed(2)}`;

                // if there are any discount
                const totalDiscountedRow = document.getElementById('totalDiscountedRow');
                const totalDiscounted = document.getElementById('totalDiscountedID');
                const voucherTextCon = document.getElementById('voucherTextCon');

                
                if(totalDiscountAmount > 0){
                    totalDiscountedRow.classList.remove("d-none");
                    voucherTextCon.classList.remove("d-none");
                    totalDiscounted.textContent = `-£${voucherTotal.toFixed(2)}`;
                }
                else{
                    totalDiscountedRow.classList.add("d-none");
                    voucherTextCon.classList.add("d-none");
                }

                if (quantity === 0) {
                    location.reload();
                }

                
                // update session variables with ajax
                fetch('./ajax/cartTotals.php', { 
                method: 'POST', 
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' }, 
                body: new URLSearchParams({ 
                    subtotal: subtotal.toFixed(2),
                    shippingFee: shippingFee.toFixed(2),
                    voucherTotal: voucherTotal.toFixed(2),
                    total: total.toFixed(2),
                    quantity: quantity
                    }) 
                }) 
            }
        });
    </script>
</body>
</html>

