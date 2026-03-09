<?php
    // include at the start of every page
    session_start();
    require_once '../connect.php';


    // Default title
    $shopTitle = "Result for All Products";
    $shopSubTitle = "";

    // Search header
    include '../main/search/header.php';


    // Button Find ID 
    if(isset($_POST['btnFindID'])){

        $pid = $_POST["pid"];

        // Prepare the SQL statement with a placeholder
        $statement = $DB->prepare("SELECT * FROM press_on WHERE prod_id = :pid");

        // Bind the pid to the placeholder
        $statement->bindValue(':pid', $pid, PDO::PARAM_INT);

        // Execute the statement
        $statement->execute();

        // Fetch the single result
        $rs = $statement->fetch(PDO::FETCH_ASSOC);
    echo"
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const modalFind = document.getElementById('findProduct');
                const modal = new bootstrap.Modal(modalFind);
                modal.show();
            });
        </script>";
    }
?>

<!DOCTYPE html>
    <html lang="en">
    <?php include '../main/php/head.php';?>   
    <body>
        <?php include 'admin-nav.php';?>
        <main>
            <?php include '../main/search/body.php';?>
        </main>
    <?php include '../main/php/script.php';?>
    </body>
</html>