<?php    
    //Single Product View with Options
    $pid = ($_POST['pid'] ?? $_POST['prod_id'] ?? $_GET['prod_id'] ?? 0);

    $statement = $DB->prepare("SELECT * FROM press_on WHERE prod_id = :pid");
    $statement->bindValue(':pid', $pid, PDO::PARAM_STR);
    $statement->execute();
    $rs = $statement->fetch();


    $defimage = json_decode($rs['prod_default_image'], true);
    $images = json_decode($rs['prod_image']) ?? [];

    // Convert Array Color to String
    $colors = json_decode($rs['prod_color'], true);
    $colorText = implode(", ", $colors);

    // Convert Array Tag to String
    $tags = json_decode($rs['prod_tag'], true);
    $tagText = implode(", ", $tags);
?>

   <div>
        <div class="row gy-3 gy-md-4 mx-auto">
            <!-- Image Column -->
            <div class="col-12 col-md-5 h-100 p-0">
                <div class="swiper">
                    <!-- Slider main container -->
                    <div class="swiper-container gallery-top">
                        <!-- Additional required wrapper -->
                        <div class="swiper-wrapper">
                        <!-- Slides -->
                            <div class="swiper-slide swiper-slide-thumb-active">
                                <img loading="lazy" src="<?= $defimage?>" alt="<?= $rs['prod_name'] ?>">
                                <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
                            </div>
                            <?php
                                if($images){
                                    $count = 1;
                                    foreach($images as $img){
                                        echo'
                                            <div class="swiper-slide">
                                                <img loading="lazy" src="' . $img . '" alt="' . $rs['prod_name'] . ' ' . $count . '" class="img-fluid">
                                                <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
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
                                    <img loading="lazy" src="<?= $defimage?>" alt="<?= $rs['prod_name'] ?>">
                                    <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
                                </div>
                                <?php
                                    $images = json_decode($rs['prod_image']);
                                    if($images){
                                        $count = 1;
                                        foreach($images as $img){
                                            echo'
                                                <div class="swiper-slide">
                                                    <img loading="lazy" src="' . $img . '" alt="' . $rs['prod_name'] . ' ' . $count . '" class="img-fluid">
                                                    <div class="swiper-lazy-preloader swiper-lazy-preloader-white"></div>
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
            <div class="col-12 col-md-7 h-100 d-flex flex-column gap-2 ps-0 ps-lg-3">
                <div class="form-box small-gap">
                    <!-- Product Name -->
                    <div>
                        <h4 class="fw-bold"><?= $rs['prod_name'] ?></h4>
                        <h5><?= $rs['prod_price'] ?></h5>
                    </div>

                    <!-- If a user display option-->
                    <?php if(isset($_SESSION["userType"]) && $_SESSION["userType"]  !== "admin" && $_SESSION["userType"]  !== "staff"): ?>
                        <?php include 'productOption.php';?>
                    <?php else: ?>
                        <p class="card-text text-capitalize">Tag: <?= ucfirst($tagText) ?></p>
                        <p class="card-text text-capitalize">Color: <?= ucfirst($colorText) ?></p>
                        <p>Discount: <?= $rs['prod_discount'] ?>%</p>
                    <?php endif; ?>
                    <div>
                        <br>
                        <p>Product Details: </p>
                        <p><?= $rs['prod_info'] ?></p>
                    </div>
                                       
                    <!-- If a user display product inclusion and more details-->
                    <?php if(isset($_SESSION["userType"]) && $_SESSION["userType"]  !== "admin" && $_SESSION["userType"]  !== "staff"): ?>
                        <!-- Accordion -->
                        <div class="accordion" id="addCartAccordion">
                            <div class="accordion-item">
                                <h4 class="accordion-header">
                                    <button class="accordion-button ps-3" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInclusions" aria-expanded="false" aria-controls="collapseInclusions">
                                        INCLUSIONS
                                    </button>
                                </h4>
                                <div id="collapseInclusions" class="accordion-collapse collapse show" data-bs-parent="#addCartAccordion">
                                    <div class="accordion-body">
                                        <ul class="disc">
                                            <li>Nail glue</li>
                                            <li>24 adhesive tabs (short wear / reusable)</li>
                                            <li>Mini nail file & buffer</li>
                                            <li>Cuticle stick</li>
                                            <li>Alcohol prep pad</li>
                                            <li>Application & removal guide card</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h4 class="accordion-header">
                                    <button class="accordion-button ps-3 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseShipping" aria-expanded="true" aria-controls="collapseShipping">
                                        SHIPPING
                                    </button>
                                </h4>
                                <div id="collapseShipping" class="accordion-collapse collapse" data-bs-parent="#addCartAccordion">
                                    <div class="accordion-body">
                                        <p>Orders are handmade and prepared within <strong>2-5 business days.</strong></p><br>
                                        <p>Estimated delivery times:</p>
                                        <ul>
                                            <li>UK: 2-4 working days</li>
                                            <li>Europe: 5-10 working days</li>
                                            <li>International: 7-15 working days</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h4 class="accordion-header">
                                    <button class="accordion-button ps-3 collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseReturnPolicy" aria-expanded="false" aria-controls="collapseReturnPolicy">
                                        RETURN POLICY
                                    </button>
                                </h4>
                                <div id="collapseReturnPolicy" class="accordion-collapse collapse" data-bs-parent="#addCartAccordion">
                                    <div class="accordion-body">
                                        <p>Due to hygiene reasons, all press-on nails are <strong>non-returnable</strong>and <strong> non-exchangeable </strong>once delivered.</p><br>
                                        <p>However, we will gladly replace your set if:</p>
                                        <ul>
                                            <li>You received the wrong design</li>
                                            <li>You received the wrong size, length or shape</li>
                                            <li>Items arrived damaged</li>
                                        </ul>
                                        <br>
                                        <p>You must contact us within <strong>48 hours of delivery</strong> with photo proof.</p>
                                        <p>Incorrect sizes entered at checkout are the customer's responsibility. We can offer a discounted remake.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <!-- If an admin display modify & delete button -->
                    <?php else: ?>
                        <div class="col-12">
                            <form method="post">
                                <input type="hidden" name="pid" value="<?= $rs['prod_id'] ?>">
                                <div class="d-flex justify-content-center gap-2">
                                    <button type="submit" class="btn btn-primary w-100" name="btnModifyProd" value="btnModifyProd">Modify</a>
                                    <button type="button" class="btn btn-light w-100" name="btnDeleteProd" value="btnDeleteProd">Delete</button>
                                </div>
                            </form>
                        </div>
                    <?php endif; ?>

                    <!-- Copyright -->
                     <div>
                        <small> Press-on product images and description courtesy of <a href="https://mimiyaga.com/">Mimiyaga</a> used for demo purposes only.</small>
                    </div> 
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
