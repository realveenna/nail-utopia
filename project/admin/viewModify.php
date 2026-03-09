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

    
    $defimage = json_decode($rs['prod_default_image'], true);
    $images = json_decode($rs['prod_image']) ?? [];

    // Convert Array Color to String
    $colors = json_decode($rs['prod_color'], true);
    $colorText = implode(", ", $colors);

    // Convert Array Tag to String
    $tags = json_decode($rs['prod_tag'], true);
    $tagText = implode(", ", $tags);


    // Define error variables and set to empty values
    $pnameErr = $ppriceErr = $tagsErr = $colorsErr = $pinfoErr = $pdiscountErr = "";
    $pname = $pprice =  $tags[] = $colors[] = $pinfo = $pdiscount = "";

    // Array of Colors
    $arrayColors = ["black","blue","brown","gold","green","grey","burgundy","neutral","orange","pink","purple","red","silver","white","yellow","multicolor","pastel"];
    // Array of Tags
    $arrayTags = ["Featured","Cute","Aerochrome","Chrome","Cateye","Flower","Pearl Aura","French Tip","3D","Minimalist","Floral","Artistic","Seasonal"];

    if (!$rs) {
        $_SESSION['errors'] = "Product not found!";
        header('Location: shop.php'); 
        exit();
    }

    $DBSelectedColors = json_decode($rs['prod_color'], true) ?? [];
    $DBSelectedTags = json_decode($rs['prod_tag'], true) ?? [];

    $selectedColors = $DBSelectedColors ?? [];
    $selectedTags   = $DBSelectedTags ?? [];
        
    $pname = $rs["prod_name"] ?? $pname;
    $pprice = $rs["prod_price"] ?? $pprice;
    $pinfo = $rs["prod_info"] ?? $pinfo;
    $pdiscount = $rs["prod_discount"] ?? 0;

    // Array of Colors
    $arrayColors = ["black","blue","brown","gold","green","grey","burgundy","neutral","orange","pink","purple","red","silver","white","yellow","multicolor","pastel"];
    $prevSelectedColors = json_decode($rs['prod_color'], true) ?? [];

    if(isset($_POST['btnUpdateDB'])){
        $pname = $_POST["pname"];
        $pprice = $_POST["pprice"];
        $tags = $_POST["selectTag"] ?? [];
        $colors = $_POST["selectColor"] ?? [];
        $pinfo = $_POST["pinfo"];
        $pdiscount = $_POST["pdiscount"] ?? 0;

        // Track selected color and tags
        $selectedColors = $colors;
        $selectedTags = $tags;   

        // INPUT VALIDATION
        // Product Name 
        if (empty($pname)) {
            $pnameErr = "Product name is required";
        }
        else if (strlen($pname) < 3){
            $pnameErr = "Please enter more than 3 characters.";
        }
        // Price 
        if (empty($pprice)) {
            $ppriceErr = "Please enter a price.";
        }
        else if($pprice > 70){
            $ppriceErr = "Price is above accepted range.";
        }
        else if($pprice < 0){
            $ppriceErr = "Price is below accepted range.";
        }
        // Discount
        if($pdiscount < 0 || $pdiscount > 100){
            $pdiscountErr = "Please enter a valid discount between 0 and 100.";
        }
        // Color 
        if (count($colors) < 1) {
            $colorsErr = "Please select one or more colors";
        }
        // Tag
        if (count($tags) < 1) {
            $tagsErr = "Please select one or more tags";
        }
        // Description
        if (empty($pinfo)) {
            $pinfoErr = "Please enter a product information";
        }
        else if (strlen($pinfo) < 20){
            $pinfoErr = "Please enter atleast 20 or more characters for product information.";
        }


            // If no errors
        if (empty($pnameErr) && empty($ppriceErr) && empty($tagsErr) && empty($colorsErr)
             && empty($pinfoErr) && empty($pdiscountErr)){
            // Convert to json
            $pcolor = json_encode(array_values($colors));
            $ptag = json_encode(array_values($tags));
    
            //Pass the variable values to be updated into the database
            $statement = $DB->prepare("UPDATE press_on SET 
            prod_name = ?, 
            prod_price = ?, 
            prod_tag = ?, 
            prod_color = ?, 
            prod_info = ?,
            prod_discount = ?
            WHERE prod_id = ?");

            $statement->bindValue(1, $pname,   PDO::PARAM_STR);
            $statement->bindValue(2, $pprice);
            $statement->bindValue(3, $ptag,    PDO::PARAM_STR);
            $statement->bindValue(4, $pcolor,  PDO::PARAM_STR);
            $statement->bindValue(5, $pinfo,   PDO::PARAM_STR);
            $statement->bindValue(6, $pdiscount, PDO::PARAM_INT);
            $statement->bindValue(7, $pid, PDO::PARAM_INT);

            $statement->execute();
        
            
            // Clear all error message
            unset($pnameErr, $ppriceErr, $tagsErr, $colorsErr, $pinfoErr, $pdiscountErr);

            // Clear all input
            unset($pname, $pprice, $tags, $colors, $pinfo, $pdefImg, $pimage, $pdiscount);

                // Display success message and exit
            $_SESSION['success'] = "Product Modified Successfully!";                
            header('Location: shop.php'); 
            exit;
        }
        else{
            $_SESSION['errros'] = "errr";
        }
    }
    
    
?>

<!DOCTYPE html>
    <html lang="en">
    <?php include '../main/php/head.php';?>   
    <body>
        <?php include 'admin-nav.php';?>
        <main>

        <!-- Banner for modify-->
        <section class="banner-text py-5">
            <div class="text-center container-lg gy-3">
                <div class="text-color primary xs-line-height">
                    <h2> MODIFY PRODUCT</h2>
                    <h5> Please enter details below</h5>
                </div>
            </div>
        </section>

        <!-- Product Section -->
        <section>
            <div class="container-lg mt-3 d-flex justify-content-center">
                <div class="row gy-3 gy-md-4 mx-auto">
                    <!-- Image Column -->
                    <div class="col-12 col-lg-5 h-100 p-0">
                        <div class="d-flex align-items-center justify-content-center mx-auto" style="max-width: 600px;">
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
                    </div>
                    
                    <!-- Product Details -->
                    <div class="col-12 col-lg-7 h-100 d-flex flex-column gap-2 ps-0 ps-lg-3">
                        <div class="form-box small-gap">
                            <!-- Form Input Group -->
                            <form method="post" class="row g-2" novalidate enctype="multipart/form-data">
                                <!-- Product Name -->
                                <div class="col-12">
                                    <label for="pname" class="form-label">Product Name:</label>
                                    <input type="text" class="form-control" name="pname" id="pname" placeholder="Enter Product Name"
                                        value="<?php echo $pname;?>">
                                    <h6 class="error"><?php echo $pnameErr;?></h6>
                                </div>
                                <!-- Price -->
                                <div class="col-12 col-lg-6">
                                    <label for="pprice" class="form-label">Price: </label>
                                    <input type="number" min="0" max="70" class="form-control" name="pprice" id="pprice" placeholder="Enter Price"
                                        value="<?php echo $pprice;?>">
                                    <h6 class="error"><?php echo $ppriceErr;?></h6>
                                </div>
                                <!-- Price -->
                                <div class="col-12 col-lg-6">
                                    <label for="pdiscount" class="form-label">Discount: </label>
                                    <input type="number" min="0" max="100" class="form-control" name="pdiscount" id="pdiscount" placeholder="Enter Discount by "
                                        value="<?php echo $pdiscount;?>">
                                    <h6 class="error"><?php echo $pdiscountErr;?></h6>
                                </div>
                                <!-- Color -->
                                <div class="col-12">
                                    <label for="pcolor" class="form-label">Color: </label>
                                    <div class="row gy-2 gx-2 row-cols-auto">
                                        <?php foreach ($arrayColors as $color): ?>
                                            <?php $colorID = str_replace(' ', '-', strtolower($color)); ?>
                                            <div class="col">
                                                <input type="checkbox" name="selectColor[]" class="btn-check" 
                                                    id="<?= $colorID ?>" value="<?= $color ?>"
                                                    <?php 
                                                        if(in_array($color, $selectedColors)){
                                                            echo 'checked';
                                                        }
                                                    ?>>
                                                <label class="btn btn-outline-primary text-capitalize" for="<?= $colorID ?>">
                                                    <?= $color ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <h6 class="error"><?php echo $colorsErr;?></h6>
                                </div>
                                <!-- Tag -->
                                <div class="col-12">
                                    <label for="ptag" class="form-label">Tag: </label>
                                    <div class="row gy-2 gx-2 row-cols-auto">
                                        <?php foreach($arrayTags as $tag) :?>
                                            <?php $tagID = str_replace(' ', '-', strtolower($tag)); ?>
                                            <?php $tagId = "tag-" . preg_replace('/\s+/', '-', strtolower($tag)); ?>
                                            <div class="col">
                                            <input type="checkbox" name="selectTag[]" class="btn-check" 
                                            id="<?= $tagId ?>" value="<?= $tag ?>" autocomplete="off"
                                                <?php 
                                                if(in_array($tag, $selectedTags)){
                                                    echo 'checked';
                                                }
                                            ?>>
                                            <label class="btn btn-outline-primary text-capitalize" for="<?= $tagId ?>">
                                                <?php echo $tag ?>
                                            </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <h6 class="error"><?php echo $tagsErr;?></h6>
                                </div>
                                <!-- Description -->
                                <div class="col-12">
                                    <label for="pinfo" class="form-label">Description: </label>
                                    <textarea class="form-control" name="pinfo" id="pinfo" rows="8" 
                                    placeholder="Enter Description"><?= trim($pinfo) ?></textarea>
                                    <h6 class="error"><?php echo $pinfoErr;?></h6>  
                                </div>
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary mb-3" name="btnUpdateDB"
                                        value="btnUpdateDB" >Modify</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>   
        </main>
    <?php include '../main/php/script.php';?>
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
    </body>
</html>


