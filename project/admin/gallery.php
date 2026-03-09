<?php
    // include at the start of every page
    session_start();
    require_once '../connect.php'; 

    $date = new DateTime();
    $uploadDate = date("Y-m-d");  // get current date
    
    // Define error variables and set to empty values
    $imageTitle = $caption = $firstImg = $secondImg = "";
    $imageTitleErr = $captionErr = $firstImgErr = $secondImgErr = "";

    // Adding Image to Gallery
    if (isset($_POST['btnAddGallery'])) {
        $imageTitle = trim($_POST['image_title']);
        $caption = trim($_POST['caption']);
        $firstImg = trim($_POST['default_image'] ?? '');
        $secondImg  = trim($_POST['second_image'] ?? null);

        // VALIDATION
        // Image Title Validation
        if (empty($imageTitle)) {
            $imageTitleErr = "Gallery title is required";
        }
        else if (strlen($imageTitle) < 3){
            $imageTitleErr = "Please enter more than 3 characters.";
        }

        // Caption Validation
        if (empty($caption)) {
            $captionErr = "Please enter a caption";
        }
        else if (strlen($caption) < 5){
            $captionErr = "Please enter atleast 5 or more characters for caption.";
        }

        // Gallery Image Validation
        // Default Image
        $firstImg = "";
        $target_dir = "../uploads/gallery/";
        $target_file = $target_dir . basename($_FILES["default_image"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // If no image selected
            if (!isset($_FILES['default_image']) || $_FILES['default_image']['error'] === UPLOAD_ERR_NO_FILE) {
                $firstImgErr = 'Please select a gallery image.';
            }
            else {
                switch ($_FILES['default_image']['error']) {
                    case 0:
                        // No error
                        if (empty($imageTitleErr) && empty($captionErr) && empty($firstImgErr) && empty($secondImgErr)){
                            if (move_uploaded_file($_FILES["default_image"]["tmp_name"], $target_file)) {
                                $firstImg = $target_file;
                            }else{
                                $firstImgErr = 'Sorry, there was an error uploading your file.';
                            }
                        }
                        break;
                    case 1:
                        $firstImgErr = 'The file exceeds the upload_max_filesize setting in php.ini.';
                        break;
                    case 2:
                        $firstImgErr = 'The file exceeds the accepted file size.';
                        break;
                    case 3:
                        $firstImgErr = 'The file was only partially uploaded.';
                        break;
                    case 4:
                        $firstImgErr = 'No file was uploaded.';
                        break;
                    case 6:
                        $firstImgErr = 'The temporary folder does not exist.';
                        break;
                    default:
                        $firstImgErr = 'Something unforeseen happened.';
                        break;
                    }
            }

        // Second Image
        $secondImg = "";
        $second_target_dir = "../uploads/gallery/";
        $second_target_file = $second_target_dir . basename($_FILES["second_image"]["name"]);
        $imageFileType = strtolower(pathinfo($second_target_file,PATHINFO_EXTENSION));
            // If no image selected
            if (!isset($_FILES['second_image']) || $_FILES['second_image']['error'] === UPLOAD_ERR_NO_FILE) {
                $secondImgErr = 'Please select a gallery image.';
            }
            else {
                switch ($_FILES['second_image']['error']) {
                    case 0:
                        // No error
                        if (empty($imageTitleErr) && empty($captionErr) && empty($secondImgErr) && empty($secondImgErr)){
                            if (move_uploaded_file($_FILES["second_image"]["tmp_name"], $second_target_file)) {
                                $secondImg = $second_target_file;
                            }else{
                                $secondImgErr = 'Sorry, there was an error uploading your file.';
                            }
                        }
                        break;
                    case 1:
                        $secondImgErr = 'The file exceeds the upload_max_filesize setting in php.ini.';
                        break;
                    case 2:
                        $secondImgErr = 'The file exceeds the accepted file size.';
                        break;
                    case 3:
                        $secondImgErr = 'The file was only partially uploaded.';
                        break;
                    case 4:
                        $secondImgErr = 'No file was uploaded.';
                        break;
                    case 6:
                        $secondImgErr = 'The temporary folder does not exist.';
                        break;
                    default:
                        $secondImgErr = 'Something unforeseen happened.';
                        break;
                    }
            }

        // If no errors
        if (empty($imageTitleErr) && empty($captionErr) && empty($firstImgErr) && empty($secondImgErr)){
            // Prepare the SQL statement with a placeholder
            $statement = $DB->prepare("INSERT INTO gallery (image_title, caption, alt, default_image, second_image, upload_date)
            VALUES (?, ?, ?, ?, ?, ?)");
            
            // Set alt same as image title
            $alt = $imageTitle;
            $firstImg = json_encode($firstImg);
            $secondImg = json_encode($secondImg);

            $statement->bindParam(1, $imageTitle, PDO::PARAM_STR);
            $statement->bindParam(2, $caption, PDO::PARAM_STR);
            $statement->bindParam(3, $alt, PDO::PARAM_STR);
            $statement->bindValue(4, $firstImg, PDO::PARAM_STR);
            $statement->bindValue(5, $secondImg, PDO::PARAM_STR);
            $statement->bindValue(6, $uploadDate, PDO::PARAM_STR);

            $statement->execute();

            // Clear all error message
            unset($imageTitleErr, $captionErr, $firstImgErr, $secondImgErr);

            // Clear all input
            unset($imageTitle, $caption);

            // Display success message and exit
            $_SESSION['success'] = "Added Successfully to Gallery!";                
            header('Location: gallery.php'); 
            exit;
       }
    }
?>

<!DOCTYPE html>
<html lang="en">
<?php include '../main/php/head.php';?>   
    <body>
        <?php include 'admin-nav.php';?>
        <?php include 'myAlert.php';?>
        <main>
            <div class="container-lg">
                <div class="form-box">
                    <div class="text-center">
                        <h2>Add Gallery Image</h2>
                        <h5>Please enter details below.</h3>
                    </div>
                    <form method="post"class="row g-2" enctype="multipart/form-data">
                        
                        <div class="col-12">
                            <label for="galleryTitle" class="form-label">Gallery Title:</label>
                            <input type="text" class="form-control" name="image_title" id="image_title" 
                                value="<?php echo $imageTitle;?>"
                                placeholder="Enter Gallery Title" >
                            <h6 class="error"><?php echo $imageTitleErr;?></h6>
                        </div>
                        <div class="col-md-6">
                            <label for="default_image" class="form-label">Default Image:</label>
                            <input type="file" class="form-control" name="default_image" id="default_image" accept="image/*" onchange="loadImg(event)">
                            <h6 class="error"><?php echo $firstImgErr;?></h6>
                            <div class="col-12 previewImage">
                                <!-- First Image Here -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="alt" class="form-label">Second Image:</label>
                            <input type="file" class="form-control" name="second_image" id="second_image"  accept="image/*"  onchange="loadImg(event)">
                            <h6 class="error"><?php echo $secondImgErr;?></h6>
                            <div class="col-12 previewImage">
                                <!-- Second Image Here -->
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="caption" class="form-label">Caption:</label>
                            <textarea class="form-control" name="caption" id="caption" rows="3" 
                            placeholder="Enter Caption"><?= trim($caption) ?></textarea>
                            <h6 class="error"><?php echo $captionErr;?></h6>
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary mb-3" name="btnAddGallery"
                                value="Add" >Add to Gallery</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </body>
    <?php include '../main/php/script.php';?>
</body>
</html>