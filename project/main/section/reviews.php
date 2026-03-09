<?php
    //Prepares an SQL statement to be executed by the execute() method
    $statement = $DB->prepare("SELECT u.fname, r.* FROM reviews r INNER JOIN userlogin u ON r.id = u.id"); // change to reviews for final
    //Executes a prepared statement
    $statement->execute();
    //Returns an array containing all of the remaining rows in the result set
    $result = $statement->fetchAll();
?>

  <!-- Swiper -->
  <div class="swiper reviewSwiper">
    <div class="swiper-wrapper" id="reviewsContainer">
    <?php   
        if($result){
            $rowCount = 0;
            foreach ($result as $rs) {

               $username = $rs['fname'] ?? "a user";

              // POV Username, Date and Caption
              $dateRaw = $rs['date'];
              $date = date('M-d-Y', strtotime($dateRaw)); 

              if($rowCount == 8){
                    break;
                }
              else{
                echo '<div class="swiper-slide">';
                  echo '<div class="card-carousel h-100">';
                    // Display Image
                    echo '<div class="gallery-images">';
                      $defimage = json_decode($rs['review_image']);
                      if($defimage){
                          echo '<img src="' . $defimage . '" alt=""Image uploaded by "' .$rs['fname']. '" class="single">';
                      }
                    echo '</div>'; // Close gallery-images 
                     ?>
                      <div class="row p-3 m-0 light-bg d-flex flex-column text-start row-gap-4 h-100">
                        <div class="d-flex justify-content-between gap-2 flex-nowrap">
                            <div class="d-block">
                              <h6 class="capitalize m-0 fw-semibold"> <?=$username?> </h6>
                              <small class="fw-light text-muted"> <?=$date?> </small>
                            </div>
                            <!-- Star Rating -->
                            <div class="d-flex justify-content-between gap-0 flex-nowrap">
                             <!--   -->
                               <?php for ($i = 1; $i <= 5; $i++ ):?>
                                    <svg class="star-svg" xmlns="http://www.w3.org/2000/svg" fill="<?= $i <= $rs['ratings'] ? '#FDCC0D' : 'none' ?>" viewBox="0 0 24 24" stroke-width=".7" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                    </svg>
                                <?php endfor;?>
                            </div>
                        </div>
                        
                        <div class="d-flex flex-column">
                            <p class="fw-bold"> <?=$rs['review_title']?></p>
                            <h6 > <?=$rs['review_text']?></h6>
                        </div>
                      </div>
                 </div>
                </div>
              <?php $rowCount++; 
              }
            }
            
        }else{
            echo '<h5 class="text-center text-danger"> No Result Found!</h5>';
        }
    ?>
    </div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
  </div>


  <!-- Swiper JS -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <!-- Initialize Swiper -->
  <script>
    var reviewSwiper = new Swiper(".reviewSwiper", {
    // Default parameters
    slidesPerView: 3,     
    spaceBetween: 8,  
      autoplay: {
        delay: 4000,
        stopOnLastSlide: true,
        disableOnInteraction: false,
      },
      zoom: {
        maxRatio: 1.2,
        minRation: 1
    },
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
       scrollbar: {
        el: '.swiper-scrollbar',
        draggable: true,
      },
      breakpoints: {
          320: { slidesPerView: 1 }, // when window width is >= 320px
          640: { slidesPerView: 2 }, // when window width is >= 640px
          980: { slidesPerView: 3 }, // when window width is >= 980px
      } 
    });
  </script>
