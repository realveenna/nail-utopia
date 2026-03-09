
<body>
    <div class="container-lg">
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
                        $result = $statement->fetchAll();
                    ?>
                        <!-- Gallery -->
                        <?php   
                            echo '<div class="row g-2">';
                            if($result){
                                foreach ($result as $rs) {
                                    echo '<div class="col-12 col-sm-6 col-lg-4">';
                                        include 'transitionImg.php';
                                        echo'<div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>';
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
                    $statement = $DB->prepare("SELECT * FROM pov");  
                    //Executes a prepared statement
                    $statement->execute();

                    //Returns an array containing all of the remaining rows in the result set
                    $result = $statement->fetchAll();
                    ?>
                    <!-- POV -->
                    <?php   
                        if($result){
                        echo '<div class="row g-2">';
                            if($result){
                                foreach ($result as $rs) {
                                    echo '<div class="col-6 col-md-4 col-lg-3"> <h2>njsajns</h2>';
                                        // include 'transitionImg.php';
                                        // echo '</div>'; // Close transitionImg.php
                                        // Insert same as above
                                    echo '</div>'; // Close col

                                }
                                
                            }else{
                                echo "No result Found";
                            }
                            echo '</div>';
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
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
