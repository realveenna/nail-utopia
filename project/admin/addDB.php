<?php 
    // include at the start of every page
    session_start();
    require_once '../connect.php'; 

    // Define error variables and set to empty values
    $pnameErr = $ppriceErr = $tagsErr = $colorsErr = $pinfoErr = $pdefImgErr = $pimageErr ="";
    $pname = $pprice =  $tags[] = $colors[] = $pinfo = "";

    // Array of Colors
    $arrayColors = ["black","blue","brown","gold","green","grey","burgundy","neutral","orange","pink","purple","red","silver","white","yellow","multicolor","pastel"];
    // Array of Tags
    $arrayTags = ["Featured","Cute","Aerochrome","Chrome","Cateye","Flower","Pearl Aura","French Tip","3D","Minimalist","Floral","Artistic","Seasonal"];

    $selectedColors = [];
    $selectedTags = [];

    if (isset($rs)) {
        $DBSelectedColors = json_decode($rs['prod_color'], true) ?? [];
        $DBSelectedTags = json_decode($rs['prod_tag'], true) ?? [];

        $selectedColors = $DBSelectedColors ?? [];
        $selectedTags   = $DBSelectedTags ?? [];
    }

    // Button Add Product
    if(isset($_POST['btnAddDB'])) {
        $pname = $_POST["pname"];
        $pprice = $_POST["pprice"];
        $tags = $_POST["selectTag"] ?? [];
        $colors = $_POST["selectColor"] ?? [];
        $pinfo = $_POST["pinfo"];

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

        // Default Image
        $pdefImg = "";
        $target_dir = "../uploads/products/";
        $target_file = $target_dir . basename($_FILES["pdefImg"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
            // If no image selected
            if (!isset($_FILES['pdefImg']) || $_FILES['pdefImg']['error'] === UPLOAD_ERR_NO_FILE) {
                $pdefImgErr = 'Please select a product image.';
            }
            else {
                switch ($_FILES['pdefImg']['error']) {
                    case 0:
                        // No error
                        if (empty($pnameErr) && empty($ppriceErr) && empty($tagsErr) && empty($colorsErr) 
                            && empty($pinfoErr) && empty($pdefImgErr) && empty($pimageErr)){
                            if (move_uploaded_file($_FILES["pdefImg"]["tmp_name"], $target_file)) {
                                $pdefImg = $target_file;
                            }else{
                                $pdefImgErr = 'Sorry, there was an error uploading your file.';
                            }
                        }
                        break;
                    case 1:
                        $pdefImgErr = 'The file exceeds the upload_max_filesize setting in php.ini.';
                        break;
                    case 2:
                        $pdefImgErr = 'The file exceeds the accepted file size.';
                        break;
                    case 3:
                        $pdefImgErr = 'The file was only partially uploaded.';
                        break;
                    case 4:
                        $pdefImgErr = 'No file was uploaded.';
                        break;
                    case 6:
                        $pdefImgErr = 'The temporary folder does not exist.';
                        break;
                    default:
                        $pdefImgErr = 'Something unforeseen happened.';
                        break;
                    }
            }

         // Upload multiple images in database
        $images = [];
        if(!empty($_FILES['pimages']['name'][0])) {
            $targetDir = "../uploads/products/";
            foreach ($_FILES['pimages']['tmp_name'] as $key => $value) {
                $fileName = basename($_FILES['pimages']['name'][$key]);
                $targetFilePath = $targetDir . $fileName;
                  // If no image selected
                if (!isset($_FILES['pimages']) && $_FILES['pimages']['error'] !== UPLOAD_ERR_NO_FILE) {
                    $pimageErr = '';
                }
                else {
                    $errImages = $_FILES['pimages']['error'][$key];
                    switch ($errImages) {
                        case 0:
                            // No error
                            if (empty($pnameErr) && empty($ppriceErr) && empty($tagsErr) && empty($colorsErr) 
                                && empty($pinfoErr) && empty($pdefImgErr) && empty($pimageErr)){
                                if(move_uploaded_file($value, $targetFilePath)) {
                                    $images[] = $targetFilePath;
                                }else{
                                    $pimageErr = 'Sorry, there was an error uploading one or more images.';
                                }
                            }
                            break;
                        case 1:
                            $pimageErr = 'One or more images exceeds the upload_max_filesize setting in php.ini.';
                            break;
                        case 2:
                            $pimageErr = 'One or more images exceeds the accepted file size.';
                            break;
                        case 3:
                            $pimageErr = 'One or more images was only partially uploaded.';
                            break;
                        case 4:
                            $pimageErr = 'No image was uploaded.';
                            break;
                        case 6:
                            $pimageErr = 'The temporary folder does not exist.';
                            break;
                        default:
                            $pimageErr = 'Something unforeseen happened.';
                            break;
                        }
                }
            }
        }

        // If no errors
        if (empty($pnameErr) && empty($ppriceErr) && empty($tagsErr) && empty($colorsErr) 
            && empty($pinfoErr) && empty($pdefImgErr) && empty($pimageErr)){

            // Convert to json
            $pcolor = json_encode(array_values($colors));
            $ptag = json_encode(array_values($tags));
    
            $pdefImg = json_encode($pdefImg);
            $pimage = json_encode($images);
    
            //Pass the variable values to be inserted into the database
            $statement = $GLOBALS['DB']->prepare("INSERT INTO press_on (prod_id, prod_name, prod_price, prod_tag, prod_color, prod_info, prod_default_image, prod_image)
            VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)");

                $statement->bindValue(1, $pname,   PDO::PARAM_STR);
                $statement->bindValue(2, $pprice);
                $statement->bindValue(3, $ptag,    PDO::PARAM_STR);
                $statement->bindValue(4, $pcolor,  PDO::PARAM_STR);
                $statement->bindValue(5, $pinfo,   PDO::PARAM_STR);
                $statement->bindValue(6, $pdefImg);
                $statement->bindValue(7, $pimage);
            
                $statement->execute();

                // Clear all error message
                unset($pnameErr, $ppriceErr, $tagsErr, $colorsErr, 
                    $pinfoErr, $pdefImgErr, $pimageErr);

                // Clear all input
                unset($pname, $pprice, $tags, $colors, 
                    $pinfo, $pdefImg, $pimage);

                 // Display success message and exit
                $_SESSION['success'] = "Product Added Successfully!";                
                header('Location: addDB.php'); 
                exit;
            }
        }
      
    ?>

<!DOCTYPE html>
<html lang="en">
<?php include '../main/php/head.php';?>   
        <body>
            <?php include 'admin-nav.php';?>
            <main>
               <div class="container-lg">
                  <div class="form-box">
                        <!-- Form Title Add Product-->
                      <div class="text-center">
                        <h2>Adding a Product</h2>
                        <h5>Please enter details below.</h5>
                    </div>
                    <div>
                        <!-- Form Input Group -->
                        <form method="post" class="row g-2" novalidate enctype="multipart/form-data">
                            <div class="col-md-6">
                                <label for="pname" class="form-label">Product Name:</label>
                                <input type="text" class="form-control" name="pname" id="pname" placeholder="Enter Product Name"
                                    value="<?php echo $pname;?>">
                                <h6 class="error"><?php echo $pnameErr;?></h6>
                            </div>
                            <div class="col-md-6">
                                <label for="pprice" class="form-label">Price: </label>
                                <input type="number" min="0" max="70" class="form-control" name="pprice" id="pprice" placeholder="Enter Price"
                                    value="<?php echo $pprice;?>">
                                <h6 class="error"><?php echo $ppriceErr;?></h6>
                            </div>
                            <!-- Color -->
                            <div class="col-md-6">
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

                            <div class="col-md-6">
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

                            <div class="col-md-6">
                                <label for="pdefImg" class="form-label"> Default Image: </label>
                                <input type="file" class="form-control" name="pdefImg" id="pdefImg" accept="image/*" onchange="loadImg(event)">
                                <h6 class="error"><?php echo $pdefImgErr;?></h6>
                                <div class="col-12 previewImage">
                                    <!-- Default Image Here -->
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="pimages" class="form-label">Thumbnail Images: </label>
                                <input type="file" class="form-control" name="pimages[]" id="pimages" multiple accept="image/*" onchange="previewThumb(this)">
                                <h6 class="error"><?php echo $pimageErr;?></h6>
                                <div class="row mx-auto g-2" id="thumbnails">
                                    <!-- Thumbnail Image Here -->
                                </div>
                            </div>
                            <div class="col-12">
                                <label for="pinfo" class="form-label">Description: </label>
                                <textarea class="form-control" name="pinfo" id="pinfo" rows="3" 
                                placeholder="Enter Description"><?= trim($pinfo) ?></textarea>
                                <h6 class="error"><?php echo $pinfoErr;?></h6>  
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary mb-3" name="btnAddDB"
                                    value="btnAddDB" >Add</button>
                            </div>
                        </form>
                    </div>
                  </div>
               </div>
            </main>
        </body>
    <?php include '../main/php/script.php';?>
</body>
</html>
