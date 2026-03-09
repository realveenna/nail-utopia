<?php    
    //Single Product View with Options
    $pid = ($_POST['pID'] ?? $_POST['prod_id'] ?? $_GET['prod_id'] ?? 0);
    $statement = $DB->prepare("SELECT * FROM press_on WHERE prod_id = '$pid'");
    $statement->execute();
    $rs = $statement->fetch();

    $defimage = json_decode($rs['prod_default_image'], true);
    $images = json_decode($rs['prod_image']) ?? [];

?>

   <div class="container-fluid">
        <div class="row">
            <!-- Image Column -->
            <div class="col-12 col-md-5 h-100">
                <div class="swiper">
                        <!-- Slider main container -->
                    <div class="swiper-container gallery-top">
                        <!-- Additional required wrapper -->
                        <div class="swiper-wrapper">
                        <!-- Slides -->
                            <div class="swiper-slide swiper-slide-thumb-active">
                                <img src="<?= $defimage?>" alt="<?= $rs['prod_name'] ?>">
                            </div>
                            <?php
                                if($images){
                                    $count = 1;
                                    foreach($images as $img){
                                        echo'
                                            <div class="swiper-slide">
                                                <img src="' . $img . '" alt="' . $rs['prod_name'] . ' ' . $count . '" class="img-fluid">
                                            </div>';
                                        $count++;
                                    }
                                }
                            ?>
                        </div>
                        <!-- Add Arrows -->
                        <div class="swiper-button-next swiper-button-white"></div>
                        <div class="swiper-button-prev swiper-button-white"></div>

                        <div class="swiper-container gallery-thumbs mt-2">
                            <!-- Additional required wrapper -->
                            <div class="swiper-wrapper">
                                <!-- Slides -->
                                <div class="swiper-slide swiper-slide-thumb-active">
                                    <img src="<?= $defimage?>" alt="<?= $rs['prod_name'] ?>">
                                </div>
                                <?php
                                    $images = json_decode($rs['prod_image']);
                                    if($images){
                                        $count = 1;
                                        foreach($images as $img){
                                            echo'
                                                <div class="swiper-slide">
                                                    <img src="' . $img . '" alt="' . $rs['prod_name'] . ' ' . $count . '" class="img-fluid">
                                                </div>';
                                            $count++;
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-12 col-md-7 h-100 d-flex flex-column gap-2">
                <div class="form-box small-gap">
                    <!-- Product Name -->
                    <div>
                        <h4 class="fw-bold"><?= $rs['prod_name'] ?></h4>
                        <h5><?= $rs['prod_price'] ?></h5>
                    </div>
                    
                    <?php include  'productOption.php';?>
                </div>
            </div>
        </div> 
   </div>

    
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    var galleryThumbs = new Swiper('.gallery-thumbs', {
      spaceBetween: 8,
      slidesPerView: 4,
      loop: true,
      freeMode: true,
      loopedSlides: 5, //looped slides should be the same
      watchSlidesVisibility: true,
      watchSlidesProgress: true,
    });

    var galleryTop = new Swiper('.gallery-top', {
      spaceBetween: 8,
      loop: true,
      loopedSlides: 5, //looped slides should be the same
      navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
      },
      thumbs: {
        swiper: galleryThumbs,
      },
    });
</script>