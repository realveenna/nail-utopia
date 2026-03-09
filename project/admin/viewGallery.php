<?php
    session_start();
    require_once '../connect.php';

    //Prepares an SQL statement to be executed by the execute() method
    $statement = $DB->prepare("SELECT * FROM gallery"); 
        
    //Executes a prepared statement
    $statement->execute();

    //Returns an array containing all of the remaining rows in the result set
    $result = $statement->fetchAll();

    // If user is an admin
    if(isset($_SESSION["userType"]) && $_SESSION["userType"]  === "admin"){
        // Allow delete gallery
        if(isset($_POST['btnDeleteGallery'])) {
            $gid = $_POST['id']; 

            $statement = $DB->prepare("SELECT  id, image_title, default_image, second_image FROM gallery WHERE id = $gid");
            // Bind the pid to the placeholder
            $statement->execute();
            $rs = $statement->fetch(PDO::FETCH_ASSOC);

            $default_image = json_decode($rs['default_image']);
            $second_image = json_decode($rs['second_image']);   
            
            if($rs){
                $path = realpath(__DIR__ . "/..") . "/" . ltrim(preg_replace('~^\.\./~', '', $default_image), '/');
                if (file_exists($path)) {
                    unlink(filename: $path);
                }
                $path2 = realpath(__DIR__ . "/..") . "/" . ltrim(preg_replace('~^\.\./~', '', $second_image), '/');
                if (file_exists($path2)) {
                    unlink($path2);
                }
                
                $title = $rs['image_title'];
                $deleteDB = $DB->prepare("DELETE FROM gallery WHERE id = ?");
                $deleteDB->bindParam(1, $gid, PDO::PARAM_INT);
                $deleteDB->execute();

                //if successful then the database should generate 1 row that matches our login details
                $count = $deleteDB->rowCount();
                if($count > 0){
                    $_SESSION['success'] = $title.  "has been deleted successfully!";
                }else{
                    $_SESSION['errors'] = "Failed to delete!";
                }
            }
            else{
                $_SESSION['errors'] = "Gallery Not Found!";
            }
            header('Location: viewGallery.php'); 
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
            <?php   
                echo '<div class="container-lg" id="ListAllGallery">';
                // Return the total count of results
                $count = count( $result );
                echo '<h6> Total Results: '.$count.' </h6>';
                    if($result){
                        echo '<div class="row g-2 gy-4">';
                        foreach ($result as $rs) {
                            include '../main/displayProducts/displayGallery.php';
                        }
                        echo '</div>'; // Close row 
                    }else{
                        echo "No result Found";
                    }
                echo'</div>'; // Close container-lg
            ?>
        </main>
    <?php include '../main/php/script.php';?>
    </body>
</html>
<?php 