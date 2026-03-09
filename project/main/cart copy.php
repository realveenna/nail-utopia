<?php 
    session_start();
    include '../connect.php';
        
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
        c.cart_id, c.user_session, c.cart_status, 
        p.prod_name, p.prod_default_image, p.prod_image, p.prod_discount 
        FROM cart c JOIN cart_items ci ON c.cart_id = ci.cart_id 
        LEFT JOIN user_custom_sizes cz ON ci.custom_size_id = cz.custom_size_id 
        JOIN press_on p ON ci.prod_id = p.prod_id WHERE c.cart_status = 'active'
        AND ((c.id = :userId AND :userId IS NOT NULL) OR (c.user_session = :sessionId AND :userId IS NULL)
      )"); 

    $statement->bindValue(':userId', $userId, $userId ? PDO::PARAM_INT : PDO::PARAM_NULL);
    $statement->bindValue(':sessionId', $user_session, PDO::PARAM_STR);

    //Executes a prepared statement
    $statement->execute();

    //Returns an array containing all of the remaining rows in the result set
    $cart = $statement->fetchAll(); 


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
                <div class="col-12 col-xl">
                    <div class="form-box small-gap mb-3 py-4">
                        <h2>Your Shopping Cart:</h2>
                        <div class="row g-2 gy-4">
                           <div class="col-12">
                                <table class="table secondary w-100 text-center">
                                    <thead>
                                        <tr>
                                            <th scope="col" colspan="2" class="py-3 px-4 text-start">Product</th>
                                            <th scope="col" class="py-3 px-4">Quantity</th>
                                            <th scope="col" class="py-3 px-4">Price</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($cart as $c): ?>
                                        <tr>
                                            <td class="px-4">
                                                <div class="cart-image">
                                                <?php
                                                    $image = json_decode($c['prod_default_image']);
                                                    if($image){
                                                        echo '<img src="' . $image . '" alt="' .$c['prod_name']. '" class="single">';
                                                    }
                                                ?>
                                                </div>
                                            </td>
                                            <td class="px-4">
                                                 <div class="d-flex flex-column text-start">
                                                    <!-- Product size length shape -->
                                                     <strong><?= $c['prod_name'] ?></strong>
                                                     <ul class="list-unstyled">
                                                        <li>Length: <?= $c['nail_length'] ?></li>
                                                        <li>Shape: <?= $c['nail_shape'] ?></li>
                                                        <li>Size: <?= $c['nail_size'] ?></li>
                                                     </ul>
                                                </div>
                                            </td>
                                            <td class="px-4"><?= $c['quantity'] ?></td>
                                            <td class="px-4"><?= $c['price'] ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                           </div>
                        </div> 
                    </div>
                </div>
                 <!-- User Information -->
                <div class="col-12 col-xl-auto">
                    <div class="secondary p-4 sticky px-5 py-4">
                        <div class="d-flex flex-column justify-content-between gap-5 w-auto">
                            <div>
                                <h3 class="text-center">Summary: </h3>
                                <table class="table secondary mx-auto w-auto">
                                    <tbody>
                                       
                                    </tbody>
                                </table>
                            </div>
                            <a href="logout.php">
                                <button type="button" class="btn btn-primary w-100">Logout</button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
   </main>
    
    <?php include './php/footer.php';?>
    <?php include './php/script.php';?>
</body>
</html>

