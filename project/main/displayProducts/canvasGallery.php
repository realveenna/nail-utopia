<?php
    //Prepares an SQL statement to be executed by the execute() method
    $statement = $DB->prepare("SELECT * FROM gallery"); 
    //Executes a prepared statement
    $statement->execute();

    //Returns an array containing all of the remaining rows in the result set
    $result = $statement->fetchAll();
?>

  <!-- Swiper -->
  <div class="swiper mySwiper">
   <div class="swiper-wrapper">
    <!-- Gallery -->
    <?php   
        if($result){
            foreach ($result as $rs) {
              echo '<div class="swiper-slide">';
                echo '<div class="card-carousel">';
                  include 'transitionImg.php';
                  echo'<div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>';
                  echo '</div>'; // Close transitionImg.php
                echo '</div>'; // Close card-carousel 
              echo'</div>'; // Close swiper-slide
            }
        }else{
          echo '<h5 class="text-center text-danger"> No result Found!</h5>';
        }
      ?>
    </div>

    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
    <div class="col-12 py-2">
      <div class="swiper-scrollbar scrollGallery">
      </div>
    </div>
  </div>

