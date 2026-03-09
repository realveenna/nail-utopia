<?php
    // include at the start of every page
    session_start();
    require_once '../connect.php';
    
    // Get prod id, exit if not found
    if (isset($_GET['prod_id'])) {
        $pid = (int)$_GET['prod_id']; 
    } else {
        $_SESSION['errors'] = "Product not found!";
        header('Location: shop.php'); 
        exit;
    }

    // Fetch product data
    $statement = $DB->prepare("SELECT * FROM press_on WHERE prod_id = :pid");
    $statement->bindParam(':pid', $pid, PDO::PARAM_INT);
    $statement->execute();
    $rs = $statement->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
    <html lang="en">
    <?php include '../main/php/head.php';?>   
    <body>
        <?php include 'admin-nav.php';?>
        <main>
        <!-- Product Section -->
        <section>
            <div class="container-lg mt-3 d-flex justify-content-center">
                <div class="row align-items-stretch g-3 g-md-4">
                    <!-- Display single product -->
                    <?php include '../main/displayProducts/singleProduct.php';?>
                </div>
            </div>
        </section>   
        </main>
    <?php include '../main/php/script.php';?>
    </body>
</html>


