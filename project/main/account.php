<?php 
    session_start();
    require_once '../connect.php';  
    include './section/cartOrderHeader.php';
    
    
    // NEWSLETTER
    $statement = $DB->prepare("SELECT newsletter_status FROM newsletter WHERE id = :userId LIMIT 1");
    $statement->bindValue(':userId', $userId, PDO::PARAM_INT);
    $statement->execute();
    $newsletter = $statement->fetch(PDO::FETCH_ASSOC);

    $status = $newsletter['newsletter_status'];
    $isSubscribed = ($status == 'subscribed') ? 1 : 0;


    // UPLOAD
    //Prepares an SQL statement to be executed by the execute() method
    $statement = $DB->prepare("SELECT p.* , u.fname FROM pov p 
        JOIN userLogin u ON u.id = p.user_id WHERE p.user_id = ?"); 

    $statement->bindValue(1, $userId, PDO::PARAM_INT);

    //Executes a prepared statement
    $statement->execute();

    $result = $statement->fetchAll();
    $count = count($result);

    // User deleting an image
    if(isset($_POST['btnDeletePOV'])) {
        $id = $_POST['pov_id']; 

        $statement = $DB->prepare("DELETE FROM pov WHERE pov_id = ?");
        // Bind the pid to the placeholder
        $statement->bindParam(1, $id, PDO::PARAM_INT);
        $statement->execute();
        $_SESSION['success'] = "Image Deleted Successfully!";   
        header('Location: account.php'); 
        exit;
    }

    // GET ADDRESS
    $statement = $DB->prepare("SELECT * FROM addresses WHERE  id = :userId ORDER BY address_id DESC LIMIT 1");
    $statement->bindValue(':userId', $userId,PDO::PARAM_INT);
    $statement->execute();
    $userAddress = $statement->fetch(PDO::FETCH_ASSOC);

    // If user has existing address in database set value
    if($userAddress){
        $address_id = $userAddress['address_id'] ?? "";
        $line1 = $userAddress['line_1'] ?? ""; 
        $line2 = $userAddress['line_2'] ?? null; 
        $city = $userAddress['city'] ?? "";
        $postcode = $userAddress['postcode'] ?? "";
        $country = $userAddress['country'] ?? "";
    }

?>

<!--Login HTML-->
<?php include 'php/head.php';?>    
    <body>
        <?php include './php/nav.php';?>   
        <main>
            <?php   
                $dateRaw = $user['date_registered'];
                $date = date('M-d-Y', strtotime($dateRaw)); 
            ?>
            <!-- Account Dashboard -->
            <div class="container-lg">
               <div class="row g-3 g-md-4">
                    <!-- User Information -->   
                    <div class="col-12 col-lg-auto">
                        <div class="secondary p-4 sticky px-2 px-md-5 py-4">
                           <div class="d-flex flex-column justify-content-between gap-3">
                               <div>
                                    <h2 class="text-center">User Information: </h2>
                                    <hr>
                                    <table class="table secondary ">
                                        <tbody>
                                            <tr>
                                                <td>Name: </td>
                                                <td class="capitalize"><?= $user['fname']; echo ' '; echo $user['lname'];?></td>
                                            </tr>
                                            <tr>
                                                <td>Email Address: </td>
                                                <td><?= $user['email'];?></td>
                                            </tr>
                                            <tr>
                                                <td>Birthday: </td>
                                                <td><?= $user['birthday'];?> </td>
                                            </tr>
                                            <?php if($userAddress): ?>
                                            <tr>
                                                <td>Address:</td>
                                                <td>
                                                    <?= $line1 ?><br>
                                                    <?php 
                                                        if(!empty($line2)){
                                                            echo $line2;
                                                            echo "<br>";
                                                        }
                                                    ?>
                                                    <?= $city ?> <br>
                                                    <?= $country ?> <br>
                                                    <?= $postcode ?>
                                                </td>
                                            </tr>
                                            <?php endif; ?>
                                            <tr>
                                                <td>
                                                    Receive exclusive offers
                                                </td>
                                                <td>
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" role="switch" 
                                                        id="newsletterSwitch" name="newsletter" value="1" 
                                                        <?php if($isSubscribed) echo 'checked'; ?>
                                                        onchange="updateNewsletter(this.checked)">
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <small id="newsletterMessage"></small>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <hr>
                               </div>
                                <a href="logout.php">
                                    <button type="button" class="btn btn-primary w-100">Logout</button>
                                </a>
                           </div>
                        </div>
                    </div>
                    <!-- MORE DETAILS -->
                    <div class="col-12 col-lg">
                        <!-- Order History -->
                         <div class="form-box small-gap mb-3 py-4">
                            <div>
                                <h2>Order History:</h2>
                                <br>
                                <?php
                                    if($cartOrder){
                                        foreach($cartOrder as $o){
                                            echo '<hr>';                 

                                            $order = $o['order'];
                                            $items = $o['items'];
                                            ?>
                                <?php include './section/cartOrder.php';?>
                                <?php
                                        }
                                    }else{
                                        echo '<h6> No Order History </h6>';
                                    }
                                ?>
                            </div>
                        </div>
                        <!-- Preferences  -->
                         <div class="form-box small-gap mb-3 py-4">
                            <div>
                                <h2>Preferences:</h2>
                                <div class="row g-2 gy-4">
                                   <?php include './section/preferences.php';?>
                                </div> 
                            </div>
                        </div>
                        <!-- Your uploads -->
                        <div class="form-box small-gap mb-3 py-4">
                            <div>
                                <h2>Your Uploads:</h2>
                                <div class="row g-2 gy-4">
                                    <?php if(count($result) > 0):?>
                                        <?php foreach($result as $rs):?>
                                        <?php $isAccountPhp = true; ?>
                                            <div class="col-12 col-lg-6 ">
                                                <?php include './displayProducts/singleHerPOV.php'; ?>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else:?>
                                        <div class="col-12">
                                            <p class="text-left"> 
                                                No Uploads yet. 
                                                Click <a href="uploadPOV.php">here</a> 
                                                to upload.
                                            </p>
                                        </div>  
                                    <?php endif; ?>
                                </div> 
                            </div>
                        </div>
                    </div>
               </div>
            </div>
        </main>

        <?php include './php/footer.php';?> 
        <?php include './php/script.php';?>
    </body>
</html> 
