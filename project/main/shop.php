<?php 
    session_start();
    include '../connect.php';

    // Default title
    $shopTitle = "Shop All";
    $shopSubTitle = "Select wide ranges of press on!";

    include './search/header.php';
?>

<!DOCTYPE html>
<html lang="en">
<?php include './php/head.php';?>   
<body>
    <?php include './php/nav.php';?>
    <main>

        <!-- Index Banner -->
        <?php include './section/collection.php';?>

        <!-- Shop All -->
        <div class="container-lg py-3 py-md-5" id="shopProducts">
            <?php include '../main/search/body.php';?>
        </div>

   </main>
   <!-- Additional script for carousel -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <?php include './php/footer.php';?>
    <?php include './php/script.php';?>
    <script>
        document.addEventListener("DOMContentLoaded", (event) => {
            document.getElementById("buttonCollection").classList.add("hidden");
        });
   </script>
</body>
</html>

