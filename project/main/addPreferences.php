<?php
    session_start();
    require_once '../connect.php';
    
    // Store User Id
    $userId = $_SESSION['userId'] ?? null; 
    $isAddPreference = true;

    include './displayProducts/productOptionHeader.php';

    // Button Add to Cart
    if(isset($_POST['btnAddPreference'])) {
        $pShape = $_POST["pShape"] ?? '';
        $pLength = $_POST["pLength"] ?? '';
        $pSize = $_POST["pSize"] ?? '';
        $set_name = $_POST["set_name"] ?? '';


    echo "<pre>";
    var_dump($_POST);
    echo "</pre>";

        // Custom Size
        $pLeft  = $_POST['left']  ?? [];
        $pRight = $_POST['right'] ?? [];

        // INPUT VALIDATION
        if(empty($set_name)){
            $setNameErr = "Please enter preference name.";
        }
        if(empty($pShape)){
            $pShapeErr = "Please select a nail shape.";
        }
        if(empty($pLength)){
            $pLengthErr = "Please select a nail length.";
        } 
        if(empty($pSize)){
            $pSizeErr = "Please select a nail size.";
        }
        

        if($pSize === 'Custom'){
            foreach($fingersArray as $fingerNail){
                $left = $pLeft[$fingerNail] ?? '';
                $right = $pRight[$fingerNail] ?? '';
                
                if(empty($left) || $left < 7 || $left > 20){
                    $pLeftErr =  "Please enter valid left hand nail sizes from 7-20 mm.";
                }
                if(empty($right) || $right < 7 || $right > 20){
                    $pRightErr = "Please enter valid right hand nail sizes from 7-20 mm.";
                }
            }
        }
      
        // If no errors
        if(empty($pShapeErr) && empty($pLeftErr) && empty($pSizeErr)
            && empty($pLeftErr) && empty($pRightErr) && empty($setNameErr)){

                //Ensure to clear is_default by same user from preference table
                $clearDefault =  $DB->prepare("UPDATE user_custom_set SET is_default = 0 
                    WHERE id = :userId AND is_default = 1");

                $clearDefault->bindValue(':userId', $userId,  PDO::PARAM_INT);
                $clearDefault->execute(); 


                //Pass the variable values to be inserted into the database
                $statement = $DB->prepare("INSERT INTO preferences (id, pref_shape, pref_length, pref_size)
                VALUES (:userId, :pShape, :pLength,:pSize)");

                $statement->bindValue(':userId', $userId,  PDO::PARAM_INT);
                $statement->bindValue(':pShape', $pShape,   PDO::PARAM_STR);
                $statement->bindValue(':pLength', $pLength,   PDO::PARAM_STR);
                $statement->bindValue(':pSize', $pSize,   PDO::PARAM_STR);
            
                $statement->execute();

                // Store preference id
                $preference_id = $DB->lastInsertId();

                // Insert to user_custom_set table
                $stmtSet = $DB->prepare("INSERT INTO user_custom_set (id, preference_id, set_name, is_default)
                VALUES (:userId, :preference_id, :set_name, :is_default)");

                $stmtSet->bindValue(':userId', $userId,  PDO::PARAM_INT);
                $stmtSet->bindValue(':preference_id', $preference_id,  PDO::PARAM_INT);
                $stmtSet->bindValue(':set_name', $set_name,  PDO::PARAM_STR);
                $stmtSet->bindValue(':is_default', 1,  PDO::PARAM_INT);


                $stmtSet->execute();

                // Store custom set id
                $set_id = $DB->lastInsertId();


                // If user selects Custom as size
                if($pSize === 'Custom'){
                    // Insert to user_custom_size table
                    $stmtSize = $DB->prepare("INSERT INTO user_custom_sizes (id, set_id,
                        r_thumb, r_index, r_middle, r_ring, r_pinky, l_thumb, l_index, l_middle, l_ring, l_pinky)
                    VALUES (:userId, :set_id, :r_thumb, :r_index, :r_middle, :r_ring, :r_pinky, 
                    :l_thumb, :l_index, :l_middle, :l_ring, :l_pinky)");

                    $stmtSize->bindValue(':userId', $userId,  PDO::PARAM_INT);
                    $stmtSize->bindValue(':set_id', $set_id,  PDO::PARAM_INT);

                    $stmtSize->bindValue(':r_thumb', $pRight['Thumb'],  PDO::PARAM_INT);
                    $stmtSize->bindValue(':r_index', $pRight['Index'],  PDO::PARAM_INT);
                    $stmtSize->bindValue(':r_middle', $pRight['Middle'],  PDO::PARAM_INT);
                    $stmtSize->bindValue(':r_ring', $pRight['Ring'],  PDO::PARAM_INT);
                    $stmtSize->bindValue(':r_pinky', $pRight['Pinky'],  PDO::PARAM_INT);
                    $stmtSize->bindValue(':l_thumb', $pLeft['Thumb'],  PDO::PARAM_INT);
                    $stmtSize->bindValue(':l_index', $pLeft['Index'],  PDO::PARAM_INT);
                    $stmtSize->bindValue(':l_middle', $pLeft['Middle'],  PDO::PARAM_INT);
                    $stmtSize->bindValue(':l_ring', $pLeft['Ring'],  PDO::PARAM_INT);
                    $stmtSize->bindValue(':l_pinky', $pLeft['Pinky'],  PDO::PARAM_INT);

                    $stmtSize->execute();
                }
                
                // Clear all error message
                unset($pShapeErr, $pLengthErr, $pSizeErr, $pLeftErr, $pRightErr, $setNameErr);

                // Clear all input
                unset($pShape, $pLeft, $pSize, $pLeft, $pRight, $set_name);

               // Display success message and exit
                $_SESSION['success'] = "Successfully added to preference!";  
                header('Location: account.php');
                exit;              
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<?php include '../main/php/head.php';?>   
    <?php if (isset($_POST['findUser'])): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const getModal = document.getElementById('addPreferencesModal');
                const modal = new bootstrap.Modal(getModal);
                modal.show();
            });
        </script>
    <?php endif; ?>
    <body>
        <?php include '../main/php/nav.php';?>
        <!-- Modal -->
            <div class="modal fade" id="addPreferencesModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="addPreferencesModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="addPreferencesModalLabel">Result</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <!-- Modan Body Content -->
                        <div class="modal-body">
                           
                        </div>
                        <!-- Modal Footer Buttons -->
                        <div class="modal-footer">

                        </div>
                    </div>
                </div>
            </div>

        <main>
            <!-- Add Preference Section -->
            <div class="container-sm" style="max-width: 700px;">  
                <div class="form-box">
                    <!-- Product Name -->
                    <div class="text-center">
                        <h2>Add Nail Preferences</h2>
                        <h6>Please enter details below.</h6>
                    </div>
                    <?php include './displayProducts/productOption.php';?>
                </div>
            </div>
        </main>
    </body>
    <?php include '../main/php/script.php';?>
</body>
</html>
