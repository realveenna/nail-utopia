<?php 
    session_start();
    include '../connect.php';

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
                    <h1> THE CANVAS</h1>
                    <h5> A showcase of elegant and trendy nail art</h5>
                </div>
            </div>
        </section>
        <!-- Gallery Section -->
        <section>
        <div class="container-lg py-3 py-md-5 d-flex justify-content-center">
            <div class="row gy-3 gy-md-4">
                <div class="col-12">
                    <ul class="nav-underline m-0">
                        <div class="col navbar justify-content-center column-gap-5">
                            <li class="nav-item">
                                <a onclick="canvasGalleryMain()" class="nav-link"><h4>From Our Gallery</h4></a>
                            </li>
                            <li class="nav-item">
                                <a onclick="canvasPOVMain()" class="nav-link"><h4>From Her POV</h4></a>
                            </li>
                            <li class="nav-item">
                                <a href="uploadPOV.php" class="nav-link"><h4>Upload Your Own</h4></a>
                            </li>
                        </div>
                    </ul>
                </div>
               
                <div class="col-12">
                <!-- Our Gallery Carousel -->
                <div id="ourGalleryMain">
                    
                    <?php
                        //Prepares an SQL statement to be executed by the execute() method
                        $statement = $DB->prepare("SELECT * FROM gallery"); 
                        //Executes a prepared statement
                        $statement->execute();

                        //Returns an array containing all of the remaining rows in the result set
                        $resultGallery = $statement->fetchAll();
                    ?>
                    <!-- Gallery -->
                    <?php   
                        echo '<div class="row g-2">';
                        if($resultGallery){
                            foreach ($resultGallery as $rs) {
                                echo '<div class="col-12 col-sm-6 col-lg-4">';
                                    include './displayProducts/transitionImg.php';
                                    echo '</div>'; // Close transitionImg.php
                                    // Gallery Caption and Name
                                    echo '<strong> '.$rs['image_title'].' </strong> <br>';
                                    echo '<small> '.$rs['caption'].' </small>';
                                echo '</div>'; // Close col
                            }
                        }else{
                            echo "No result Found";
                        }
                        echo '</div>';
                    ?>
                </div>
                    <!-- Her POV Carousel Hidden by Default -->
                <div class="hidden" id="herPOVMain">
                    <?php
                        //Prepares an SQL statement to be executed by the execute() method
                        $statement = $DB->prepare("SELECT p.* , u.fname FROM pov p 
                        JOIN userLogin u ON u.id = p.user_id "); 

                        //Executes a prepared statement
                        $statement->execute();

                        //Returns an array containing all of the remaining rows in the result set
                        $resultPOV = $statement->fetchAll();
                    ?>
                        <!-- POV -->
                        <?php   
                            if($resultPOV){
                            echo '<div class="row g-2">';
                                foreach($resultPOV as $rs){
                                    echo '<div class="col-12 col-sm-6 col-lg-4">';
                                        include './displayProducts/singleHerPOV.php';
                                    echo '</div>'; // Close col
                                }
                            }
                            else{
                                echo '<h5 class="text-center text-danger"> No result Found!</h5>';
                            }
                            echo '</div>';
                        ?>
                    </div>
                </div>
            </div>
        </div>
        </section>   
   </main>
     
    <?php include './php/footer.php';?>
    <?php include './php/script.php';?>
    <script>
        function canvasGalleryMain() {
        var gallery = document.getElementById("ourGalleryMain").classList.remove("hidden");
        var pov = document.getElementById("herPOVMain").classList.add("hidden");
        }
        function canvasPOVMain() {
        var gallery = document.getElementById("ourGalleryMain").classList.add("hidden");
        var pov = document.getElementById("herPOVMain").classList.remove("hidden");
        }
    </script>
</body>
</html>

