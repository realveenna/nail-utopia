<?php
    session_start();
    require_once '../connect.php';
    
    if(isset($_POST['findUser'])) {
        $userEmail = $_POST["userEmail"];

        // Prepare the SQL statement with a placeholder
        $statement = $DB->prepare("SELECT * FROM userlogin WHERE email = :email");

        // Bind the userEmail to the placeholder
        $statement->bindParam(':email', $userEmail, PDO::PARAM_STR);

        // Execute the statement
        $statement->execute();

        // Fetch the single result
        $findEmail = $statement->fetch(PDO::FETCH_ASSOC);
    }

    // Confirm add admin
    if(isset($_POST['btnAddEmployee'])){
        $userEmail = $_POST['userEmail'];
        $userRole = $_POST['btnAddEmployee'];
        
        // Update statement
        $statement = $DB->prepare("UPDATE userlogin SET user_type = :userRole WHERE email = :email");
        
        $statement->bindParam(':userRole', $userRole, PDO::PARAM_STR);
        $statement->bindParam(':email', $userEmail, PDO::PARAM_STR);
        $statement->execute();

        // Remove from newsletter
        $remove = $DB->prepare("DELETE FROM newsletter WHERE id = :userId");
        $remove->bindValue(':userId', $userId, PDO::PARAM_INT);
        $remove->execute();

        // Remove cart & order
        $remove = $DB->prepare("DELETE FROM cart WHERE id = :userId");
        $remove->bindValue(':userId', $userId, PDO::PARAM_INT);
        $remove->execute();

        echo $userId;

        // Display success message and exit
        $_SESSION['success'] =  "Successfully added as " . $userRole . "!";           
        header('Location: staff.php'); 
        exit;
    }
?>

<!DOCTYPE html>
<html lang="en">
<?php include '../main/php/head.php';?>   
    <?php if (isset($_POST['findUser'])): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const getModal = document.getElementById('staticBackdrop');
                const modal = new bootstrap.Modal(getModal);
                modal.show();
            });
        </script>
    <?php endif; ?>
    <body>
        <?php include 'admin-nav.php';?>
        <main>
            <!-- Modal -->
            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="staticBackdropLabel">Result</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <!-- Modan Body Content -->
                        <div class="modal-body">
                            <?php if($findEmail): ?>
                                    <?php if($findEmail['user_type'] !== 'admin'): ?>
                                        <h5>Do you want to add <?= $findEmail['fname'] ?> <?= $findEmail['lname'] ?> as admin or staff?</h5>
                                    <?php else: ?>
                                        <p class="text-danger"> <?= $findEmail['email']?> is already an admin. Please try again.</p>
                                    <?php endif; ?>
                            <?php else: ?>
                                    <p class="text-danger"> No result found. Please create a new account to continue.</p>
                            <?php endif; ?>
                        </div>
                        <!-- Modal Footer Buttons -->
                        <div class="modal-footer">
                            <!-- Add Admin Button -->
                            <?php if($findEmail && $findEmail['user_type'] !== 'admin'): ?>
                                <form method="post" class="row g-2 needs-validation" novalidate>
                                    <input type="hidden" name="userEmail" value="<?= $findEmail['email'] ?>">
                                    <!-- As Admin -->
                                   <div class="d-flex gap-2">
                                     <button type="submit" class="btn btn-secondary" name="btnAddEmployee"
                                        value="admin">Admin</button>

                                    <!-- As Staff -->
                                    <button type="submit" class="btn btn-primary" name="btnAddEmployee"
                                        value="staff">Staff</button>
                                   </div>
                                </form>
                            <!-- Result is not compatible as admin-->
                            <?php else: ?>
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Back</button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Staff -->
            <div class="container-lg">
                <form method="post" class="row g-2 needs-validation" novalidate>
                    <div class="row">
                        <label for="userEmail" class="form-label">Add Staff:</label>
                    </div>
                    <div class="row gx-2">
                        <div class="col">
                            <input type="email" class="form-control"  name="userEmail" id="userEmail" placeholder="Enter User Email" required>
                            <div class="invalid-feedback">
                                Please enter a valid email address.
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary mb-3" name="findUser"
                                value="findUser">Find User</button>
                        </div>
                    </div>
                </form>                
            </div>
        </main>
    </body>
    <?php include '../main/php/script.php';?>
</body>
</html>
