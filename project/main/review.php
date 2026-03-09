<?php 
    session_start();
    include '../connect.php';

    // Set user id
    $userId = $_SESSION['userId'];

    if(!isset($_SESSION['userId']) || $_SESSION["loggedIn"] !== true){
        $_SESSION['errors'] = "Please log in to make a review.";
        header('Location: index.php');
        exit;
    }else{
        $reviewTitle = $reviewText = $reviewRating ="";
        $reviewTitleErr = $reviewTextErr = $reviewImageErr = $reviewRatingErr = "";

        if(isset($_POST['btnAddReview'])){
            $reviewTitle = $_POST['reviewTitle'];
            $reviewText = $_POST['reviewText'];
            $reviewRating = $_POST['reviewRating'] ?? 0;

            // VALIDATE INPUT
            if(empty($reviewTitle)){
                $reviewTitleErr = "Please enter a review title.";
            }
            if(empty($reviewText)){
                $reviewTextErr = "Please enter a review description.";
            }
            if(empty($reviewRating) || $reviewRating === 0){
                $reviewRatingErr = "Please select rating";
            }

        // Default Image
        $reviewImage = "";
        $target_dir = "../uploads/rating/";
        $target_file = $target_dir . basename($_FILES["reviewImage"]["name"]);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // If no image selected
            if (!isset($_FILES['reviewImage']) || $_FILES['reviewImage']['error'] === UPLOAD_ERR_NO_FILE) {
                $reviewImageErr = 'Please select an image.';
            }
            else {
                switch ($_FILES['reviewImage']['error']) {
                    case 0:
                        // No error
                        if (empty($reviewTitleErr) && empty($reviewTextErr) && empty($reviewRatingErr)){
                            if (move_uploaded_file($_FILES["reviewImage"]["tmp_name"], $target_file)) {
                                $reviewImage = $target_file;
                            }else{
                                $reviewImageErr = 'Sorry, there was an error uploading your file.';
                            }
                        }
                        break;
                    case 1:
                        $reviewImageErr = 'The file exceeds the upload_max_filesize setting in php.ini.';
                        break;
                    case 2:
                        $reviewImageErr = 'The file exceeds the accepted file size.';
                        break;
                    case 3:
                        $reviewImageErr = 'The file was only partially uploaded.';
                        break;
                    case 4:
                        $reviewImageErr = 'No file was uploaded.';
                        break;
                    case 6:
                        $reviewImageErr = 'The temporary folder does not exist.';
                        break;
                    default:
                        $reviewImageErr = 'Something unforeseen happened.';
                        break;
                }
            }
            
            // If no errors
            if (empty($reviewTitleErr) && empty($reviewTextErr) && empty($reviewRatingErr) && empty($reviewImageErr)){
                // Convert to JSON
                $reviewImage = json_encode($reviewImage);      

                //Pass the variable values to be inserted into the database
                $statement = $GLOBALS['DB']->prepare("INSERT INTO reviews (id, review_image, review_text, ratings, review_title)
                VALUES (?, ?, ?, ?, ?)");

                $statement->bindValue(1, $userId,   PDO::PARAM_INT);
                $statement->bindValue(2, $reviewImage,   PDO::PARAM_STR);
                $statement->bindValue(3, $reviewText,    PDO::PARAM_STR);
                $statement->bindValue(4, $reviewRating,    PDO::PARAM_INT);
                $statement->bindValue(5, $reviewTitle,    PDO::PARAM_STR);
            
                $statement->execute();

                // Clear all error message
                unset($reviewTitleErr, $reviewTextErr, $reviewRatingErr, $reviewImageErr);

                // Clear all input
                unset($reviewTitle, $reviewText, $reviewRating);
                
                // Display success message and exit
                $_SESSION['success'] = "Your review is successfully submitted!";                
                header('Location: index.php'); 
                exit;
            }

        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<?php include './php/head.php';?>    
<body>
    <?php include './php/nav.php';?>   
   <main>
        <!-- Review Section -->
         <section>
            <div class="container-sm imageUpload" style="max-width: 700px;">  
                <div class="form-box">
                    <!-- Review Title -->
                    <div class="text-center">
                        <h2> MAKE A REVIEW</h2>
                        <h6> Please select details</h6>
                    </div>
                    <!-- Section Review Form -->
                    <form method="post" class="row gy-2" novalidate enctype="multipart/form-data">
                        <!-- Hidden value of user id -->
                        <input type="hidden" name="userId" value="<?= $userId  ?>">

                        <!-- Image -->
                        <div class="previewImagesRow"></div>
                         <div class="col-12">
                            <label for="reviewTextOutside" class="form-label">Enter Image:</label>
                            <label for="reviewImage" class="drop-zone">
                                Drop image here, or click to upload.
                                <input type="file" class="file-input" name="reviewImage" id="reviewImage" accept="image/*">
                            </label>
                            <h6 class="error"><?php echo $reviewImageErr;?></h6>
                       </div>

                        <!-- Rating Star -->
                        <div class="col-12">
                            <div class="row g-2">
                                <div class="col-auto">
                                    <label for="reviewRating" class="form-label">Rating:</label>
                                </div>
                                <div class="col d-flex star-wrap">
                                    <input type="radio" id="star1" value="5"
                                        <?= (isset($reviewRating) && $reviewRating == 5) ? 'checked' : ''?> name="reviewRating"/>
                                        <label for="star1">
                                            <svg class="star-svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width=".7" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                            </svg>
                                        </label>
                                    <input type="radio" id="star2" value="4" 
                                        <?= (isset($reviewRating) && $reviewRating == 4) ?  'checked' : ''?> name="reviewRating"/>
                                        <label for="star2">
                                            <svg class="star-svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width=".7" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                            </svg>
                                        </label>
                                    <input type="radio" id="star3" value="3" 
                                        <?= (isset($reviewRating) && $reviewRating == 3) ? 'checked' : ''?> name="reviewRating"/>
                                        <label for="star3">
                                            <svg class="star-svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width=".7" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                            </svg>
                                        </label>
                                    <input type="radio" id="star4" value="2" 
                                        <?= (isset($reviewRating) && $reviewRating == 2) ? 'checked' : ''?> name="reviewRating"/>
                                        <label for="star4">
                                            <svg class="star-svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width=".7" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                            </svg>
                                        </label>
                                    <input type="radio" id="star5" value="1" 
                                        <?= (isset($reviewRating) && $reviewRating == 1) ? 'checked' : ''?> name="reviewRating"/>
                                        <label for="star5">
                                            <svg class="star-svg" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width=".7" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.499a.562.562 0 0 1 1.04 0l2.125 5.111a.563.563 0 0 0 .475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 0 0-.182.557l1.285 5.385a.562.562 0 0 1-.84.61l-4.725-2.885a.562.562 0 0 0-.586 0L6.982 20.54a.562.562 0 0 1-.84-.61l1.285-5.386a.562.562 0 0 0-.182-.557l-4.204-3.602a.562.562 0 0 1 .321-.988l5.518-.442a.563.563 0 0 0 .475-.345L11.48 3.5Z" />
                                            </svg>
                                        </label>
                                </div>
                            </div>
                            <h6 class="error"><?php echo $reviewRatingErr;?></h6>
                        </div>

                        <!-- Title Input -->
                        <div class="col-12">
                            <label for="reviewTitle" class="form-label">Title</label>
                            <input type="text" class="form-control" name="reviewTitle" id="reviewTitle" placeholder="Enter Review Title"
                                value="<?php echo $reviewTitle;?>">
                            <h6 class="error"><?php echo $reviewTitleErr;?></h6>
                        </div>
                        
                        <!-- Review Text -->
                        <div class="col-12">
                            <label for="reviewText" class="form-label">Description:</label>
                               <textarea class="form-control" name="reviewText" id="reviewText" rows="3" 
                                placeholder="Enter Review Description"><?= trim($reviewText) ?></textarea>
                                <h6 class="error"><?php echo $reviewTextErr;?></h6>
                        </div>
  
                        <div class="col-12">
                            <div class="gap-2 d-flex justify-content-center">
                                    <button class="btn btn-primary upload-btn" name="btnAddReview" value="btnAddReview"> Submit</button>
                                    <button class="btn btn-secondary clear-btn">Clear</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>    
   </main>
    
    <?php include './php/footer.php';?>
    <?php include './php/script.php';?>
</body>
</html>

