<?php 
    session_start();
    include '../connect.php';

    if (isset($_GET['prod_id'], $_GET['prod_price'])) {
        $prodId = $_GET['prod_id'];
        $price = $_GET['prod_price'];
        include './displayProducts/addRecent.php';
    } else {
        $_SESSION['errors'] = "Product not found!";
        header('Location: shop.php'); 
        exit;
    }
    unset($isAddPreference);
    include './displayProducts/productOptionHeader.php';

    // Button Add to Cart
    if(isset($_POST['btnAddCart'])) {
        $pID = $prodId;
        $pShape = $_POST["pShape"] ?? '';
        $pLength = $_POST["pLength"] ?? '';
        $pSize = $_POST["pSize"] ?? '';

        // Custom Size
        $pLeft  = $_POST['left']  ?? [];
        $pRight = $_POST['right'] ?? [];
     
        // INPUT VALIDATION
        if(empty($pShape)){
            $pShapeErr = "Please select a nail shape.";
        }
        else{
            $defaultShape = $pShape;
        }
        if(empty($pLength)){
            $pLengthErr = "Please select a nail length.";
        } 
        else{
            $defaultLength = $pLength;
        }
        if(empty($pSize)){
            $pSizeErr = "Please select a nail size.";
        }
        else{
            $defaultSize = $pSize;
        }

        if($pSize === 'Custom'){
            foreach($fingersArray as $fingerNail){
                $left = $pLeft[$fingerNail] ?? '';
                $right = $pRight[$fingerNail] ?? '';
                
                if(empty($left) || $left < 7 || $left > 20){
                    $pLeftErr =  "Please enter valid left hand nail sizes from 7-20 mm.";
                }
                if(empty($right) || $right < 7 || $right > 20){
                    $pRightErr = "Please enter valid right hand nail sizes from 7-20 mm.";
                }
            }
        }

        if($pSize === 'Custom' && (empty($userId))){
            $pLeftErr = "";
            $pRightErr = "";
            $pCustomErr = "Please login to select custom size.";
        }

        // Check if Cart exist
        // If user is logged in and no active cart
        if($userId){
            $statement = $DB->prepare("SELECT cart_id FROM cart WHERE  id = :user AND cart_status = 'active' LIMIT 1");
            $statement->bindValue(':user', $userId,   PDO::PARAM_INT);
        }
        // If user is a guest and no active cart
        else{
            $statement = $DB->prepare("SELECT cart_id FROM cart WHERE  user_session = :user_session AND cart_status = 'active' LIMIT 1");
            $statement->bindValue(':user_session', $user_session,   PDO::PARAM_STR);
        }

        $statement->execute();
        $cart = $statement->fetch(PDO::FETCH_ASSOC);

        // If no existing cart then create
        if(!$cart){
            // Create cart
            $active = "active";
            // If user is logged in
            if($userId){
                //Pass the variable values to be inserted into the database
                $cartCreate = $DB->prepare("INSERT INTO cart(id, cart_status) 
                VALUES (:user, 'active')");

                $cartCreate->bindValue(':user', $userId, PDO::PARAM_INT);
                
            }
            // User is a guest
            else{
                //Pass the variable values to be inserted into the database
                $cartCreate = $DB->prepare("INSERT INTO cart(user_session, cart_status) 
                VALUES (:user_session, 'active')");

                $cartCreate->bindValue(':user_session', $user_session, PDO::PARAM_STR);
            }
            $cartCreate->execute();
            
            // Variable for new cart
            $cart_id = $DB->lastInsertId(); 
        }
        // If cart is active and has user existing then, set cart_id
        else{
            $cart_id = $cart['cart_id'];
        }
       
        // If no errors
        if(empty($pShapeErr) && empty($pLengthErr) && empty($pSizeErr)
            && empty($pLeftErr) && empty($pRightErr) && empty($pCustomErr)){


                //Pass the variable values to be inserted into th cart items table
                $statement = $DB->prepare("INSERT INTO cart_items (cart_id, prod_id, nail_size, nail_length, nail_shape, price)
                VALUES (:cart_id, :pID, :pSize, :pLength, :pShape, :price)");

                $statement->bindValue(':cart_id', $cart_id,   PDO::PARAM_INT);
                $statement->bindValue(':pID', $pID,   PDO::PARAM_INT);
                $statement->bindValue(':pSize', $pSize,   PDO::PARAM_STR);
                $statement->bindValue(':pLength', $pLength,   PDO::PARAM_STR);
                $statement->bindValue(':pShape', $pShape,   PDO::PARAM_STR);
                $statement->bindValue(':price', $price,   PDO::PARAM_INT);
            
                $statement->execute();

                // Store custom size id
                $cart_item_id = $DB->lastInsertId();

                if($pSize === 'Custom'){
                    
                    // Insert to user_custom_size table
                    $stmtSize = $DB->prepare("INSERT INTO user_custom_sizes (id, set_id,
                        r_thumb, r_index, r_middle, r_ring, r_pinky, l_thumb, l_index, l_middle, l_ring, l_pinky)
                    VALUES (:user, :set_id, :r_thumb, :r_index, :r_middle, :r_ring, :r_pinky, 
                    :l_thumb, :l_index, :l_middle, :l_ring, :l_pinky)");

                    $stmtSize->bindValue(':user', $userId,  PDO::PARAM_INT);
                    $stmtSize->bindValue(':set_id', NULL,  PDO::PARAM_NULL);

                    $stmtSize->bindValue(':r_thumb', $pRight['Thumb'],  PDO::PARAM_INT);
                    $stmtSize->bindValue(':r_index', $pRight['Index'],  PDO::PARAM_INT);
                    $stmtSize->bindValue(':r_middle', $pRight['Middle'],  PDO::PARAM_INT);
                    $stmtSize->bindValue(':r_ring', $pRight['Ring'],  PDO::PARAM_INT);
                    $stmtSize->bindValue(':r_pinky', $pRight['Pinky'],  PDO::PARAM_INT);
                    $stmtSize->bindValue(':l_thumb', $pLeft['Thumb'],  PDO::PARAM_INT);
                    $stmtSize->bindValue(':l_index', $pLeft['Index'],  PDO::PARAM_INT);
                    $stmtSize->bindValue(':l_middle', $pLeft['Middle'],  PDO::PARAM_INT);
                    $stmtSize->bindValue(':l_ring', $pLeft['Ring'],  PDO::PARAM_INT);
                    $stmtSize->bindValue(':l_pinky', $pLeft['Pinky'],  PDO::PARAM_INT);

                    $stmtSize->execute();
                    
                    // Store custom size id
                    $custom_size_id = $DB->lastInsertId();

                    //Pass the variable values to be inserted into the database
                    $statement = $DB->prepare("UPDATE cart_items 
                        SET custom_size_id = :custom_size_id WHERE cart_item_id = :cart_item_id");

                        $statement->bindValue(':custom_size_id', $custom_size_id,   PDO::PARAM_INT);
                        $statement->bindValue(':cart_item_id', $cart_item_id,   PDO::PARAM_INT);

                        $statement->execute();
                    }

                // Clear all error message
                unset($pShapeErr, $pLengthErr, $pSizeErr, $pLeftErr, $pRightErr, $pCustomErr);
                // Clear all input
                unset($pShape, $pLeft, $pSize, $pLeft, $pRight,);

               // Display success message and exit
                $_SESSION['success'] = "Product Added to Cart!";  
                header('Location: addCart.php?prod_id=' . $pID .'&prod_price='.$price);
                exit;              
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<?php include './php/head.php';?>    
<body>
    <?php include './php/nav.php';?>   
   <main>
        <!-- Banner -->
        <section class="banner-text py-5">
            <div class="text-center container-lg gy-3">
                <div class="text-color primary xs-line-height">
                    <h2> ADD PRODUCT TO CART</h2>
                    <h5> Please select details</h5>
                </div>
            </div>
        </section>

        <!-- Product Section -->
        <section>
            <div class="container-lg mt-3 d-flex justify-content-center">
                <div class="row align-items-stretch g-3 g-md-4">
                    <!-- Display single product -->
                    <?php include './displayProducts/singleProduct.php'; ?>
                </div>
            </div>
        </section>   
        
        <!-- Recently Viewed -->
        <?php if(isset($_COOKIE['recent'])): ?>
            <section>
                <?php include './displayProducts/showRecent.php';?>
            </section>
        <?php endif; ?>
        
   </main>
    
    <?php include './php/footer.php';?>
    <?php include './php/script.php';?>

</body>
</html>

