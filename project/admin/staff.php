<?php
    session_start();
    require_once '../connect.php';

    //Prepares an SQL statement to be executed by the execute() method
    $statement = $DB->prepare("SELECT * FROM userlogin WHERE user_type = ? OR user_type = ?");
    $statement->bindValue(1, 'admin', PDO::PARAM_STR);
    $statement->bindValue(2, 'staff', PDO::PARAM_STR);

    //Executes a prepared statement
    $statement->execute();
            
    //Returns an array containing all of the remaining rows in the result set
    $result = $statement->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">
<?php include '../main/php/head.php';?>   
    <body>
        <?php include 'admin-nav.php';?>
        <main>
            <!-- Account Dashboard -->
            <div class="container-lg">
               <div class="row g-3 g-md-4 ">
                    <!-- User Information -->   
                    <div class="col-12 col-lg-auto">
                        <div class="secondary p-4 sticky px-5 py-4">
                           <div class="d-flex flex-column justify-content-between gap-3">
                               <div>
                                    <h2 class="text-center">Admin Information: </h2>
                                    <hr>
                                    <table class="table secondary ">
                                        <tbody>
                                            <tr>
                                                <td>Name: </td>
                                                <td class="capitalize"><p class="capitalize"> <?php echo $user['fname']; echo ' '; echo $user['lname']; ?></p></td>
                                            </tr>
                                            <tr>
                                                <td>Email Address: </td>
                                                <td><?= $user['email'];?></td>
                                            </tr>
                                            <tr>
                                                <td>User Type:</td>
                                                <td><?= $user['user_type']?></td>
                                            </tr>
                                            <tr>
                                                <td>Date Registered:</td>
                                                <td><?=$user['date_registered']?></td>
                                            </tr>
                                            <tr>
                                                <td>Birthday: </td>
                                                <td><?= $user['birthday'];?> </td>
                                            </tr>
                                            <?php if(isset($userAddress)): ?>
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
                                        </tbody>
                                    </table>
                                    <hr>
                               </div>
                                <a href="../main/logout.php">
                                    <button type="button" class="btn btn-primary w-100">Logout</button>
                                </a>
                           </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg">
                        <!-- Staff Lists -->
                        <div id="staffListCon">
                            <div class="text-left">
                                <h2>All Staffs</h2>
                            </div>
                                <?php
                                    if($result){
                                        echo' 
                                        <div class="table-responsive">
                                            <table class="table text-center table-hover">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="text-main">ID</th>
                                                        <th scope="col" class="text-main">Role</th>
                                                        <th scope="col" class="text-main">Full Name</th>
                                                        <th scope="col" class="text-main">Email</th>
                                                        <th scope="col" class="text-main">Birthday</th>
                                                        <th scope="col" class="text-main">Date Registered</th>
                                                        <th scope="col" class="text-main">Remove</th>

                                                    </tr>
                                                </thead>';
                                        foreach($result as $rs){
                                            echo '<tbody>';
                                                echo '<tr>';
                                                    echo '<td scope="row"> '.$rs['id'].' </td>';
                                                    echo '<td scope="row"> '.$rs['user_type'].' </td>';
                                                    echo '<td> '.$rs['fname'].' '.$rs['lname'].' </td>';
                                                    echo '<td> <a href="mailto:'.$rs['email'].'"> '.$rs['email'].' </a> </td>';
                                                    echo '<td> '.$rs['birthday'].' </td>';
                                                    echo '<td> '.$rs['date_registered'].' </td>';
                                                    echo '<td>';
                                                        // Allow staff removal if role is a staff
                                                        if($rs['user_type'] !== 'admin'){
                                                            echo'
                                                                <button class="no-bg" type="submit" name="btnRemoveStaff">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                                    </svg>
                                                                </button>
                                                            ';
                                                        }
                                                    echo'
                                                        </td>';
                                                echo '</tr>';
                                            echo '</tbody>';
                                        }
                                    }else{
                                        echo "No result Found";
                                    }
                                    echo '</table>
                                        </div>
                                    ';
                                ?>
                           
                        </div>
                    </div>
                    <!-- Admin may add more staff -->
                    <?php if($user['user_type'] === 'admin'):?>
                        <div class="d-flex justify-content-end">
                            <a class="btn btn-primary primary" href="addStaff.php" role="button">Add Staff</a>
                        </div>
                    <?php endif?>
                    
                </div>
            </div>
        </main>
    </body>
    <?php include '../main/php/script.php';?>
</body>
</html>
