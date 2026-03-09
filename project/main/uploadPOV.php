 <?php 
    session_start();
    include '../connect.php';

    $POVImagesErr = $captionErr = $caption = ""; 

    if(isset($_POST['btnUploadPOV'])) {
        // If logged and is a user in only allow upload
        if($userId && $userType === "user"){

            $uploadDate = date("Y-m-d");  // get current date
            $caption = $_POST["caption"];

            // Caption
            if (empty($caption)) {
                $captionErr = "Please enter a caption";
            }
            else if (strlen($caption) < 3){
                $captionErr = "Please enter atleast 3 or more characters for caption.";
            }


        // Default Image
        $POVImages = "";
        $target_dir = "../uploads/pov/";
        $target_file = $target_dir . basename($_FILES["POVImages"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // If no image selected
            if (!isset($_FILES['POVImages']) || $_FILES['POVImages']['error'] === UPLOAD_ERR_NO_FILE) {
                $POVImagesErr = 'Please select an image.';
            }
            else {
                switch ($_FILES['POVImages']['error']) {
                    case 0:
                        // No error
                        if (empty($POVImagesErr) && empty($captionErr)){
                            if (move_uploaded_file($_FILES["POVImages"]["tmp_name"], $target_file)) {
                                $POVImages = $target_file;
                            }else{
                                $POVImagesErr = 'Sorry, there was an error uploading your file.';
                            }
                        }
                       
                        break;
                    case 1:
                        $POVImagesErr = 'The file exceeds the upload_max_filesize setting in php.ini.';
                        break;
                    case 2:
                        $POVImagesErr = 'The file exceeds the accepted file size.';
                        break;
                    case 3:
                        $POVImagesErr = 'The file was only partially uploaded.';
                        break;
                    case 4:
                        $POVImagesErr = 'No file was uploaded.';
                        break;
                    case 6:
                        $POVImagesErr = 'The temporary folder does not exist.';
                        break;
                    default:
                        $POVImagesErr = 'Something unforeseen happened.';
                        break;
                    }
            }
        }
        elseif($userType === "admin"){
            $POVImagesErr = "Admins are not allowed to upload a POV images.";
        }
        else{
            $POVImagesErr = "Please log in with your account to upload.";
        }

        // If no error message
        if(empty($POVImagesErr) && empty($captionErr)){
            // Convert to JSON
            $POVImages = json_encode($POVImages);      

              //Pass the variable values to be inserted into the database
            $statement = $GLOBALS['DB']->prepare("INSERT INTO pov (user_id, caption, pov_images)
            VALUES (?, ?, ?)");
            
            $statement->bindValue(1, $userId,   PDO::PARAM_INT);
            $statement->bindValue(2, $caption,   PDO::PARAM_STR);
            $statement->bindValue(3, $POVImages,    PDO::PARAM_STR);
        
            $statement->execute();

            // Clear all error message
            unset($POVImagesErr, $captionErr);

            // Clear all input
            unset($caption);
            
            // Display success message and exit
            $_SESSION['success'] = "Your POV image has been uploaded successfully!";                
            header('Location: uploadPOV.php'); 
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<?php include './php/head.php';?>    
<body>
    <?php include './php/nav.php';?>   
   <main>
    <section>
        <div class="container-lg mb-4">
            <!-- Image Upload -->
            <div class="col-12 imageUpload"> 
                    <div class="form-box">
                    <!-- Form Title Add Product-->
                    <div class="text-center">
                    <h2>Upload Your Own POV</h2>
                    <h5>Please enter details below.</h5>
                </div>
                <div>
                    <form method="post" class="row g-2" novalidate enctype="multipart/form-data">
                        <div class="previewImagesRow"></div>
                        <div class="col-12">
                            <label for="caption" class="form-label">Caption:</label>
                               <textarea class="form-control" name="caption" id="caption" rows="3" 
                                placeholder="Enter Caption"><?= trim($caption) ?></textarea>
                                <h6 class="error"><?php echo $captionErr;?></h6>
                        </div>
                        <div class="col-12">
                            <label for="POVImages" class="drop-zone">
                                Drop images here, or click to upload.
                                <input type="file" class="file-input" name="POVImages" id="POVImages" multiple accept="image/*">
                            </label>
                            <h6 class="error"><?php echo $POVImagesErr;?></h6>
                            <div class="gap-2 d-flex">
                                <button class="btn btn-primary upload-btn" name="btnUploadPOV" value="btnUploadPOV"> Upload</button>
                                <button class="btn btn-secondary clear-btn">Clear</button>
                            </div>
                       </div>
                    </form>
                </div>
            </div>
        </div> 
    </section>
   </main>
     
    <?php include './php/footer.php';?>
    <?php include './php/script.php';?>
    
</body>
</html>

