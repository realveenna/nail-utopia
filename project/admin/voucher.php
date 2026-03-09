<?php
    session_start();
    require_once '../connect.php';

    $voucherStatus = "<h4 class='badge text-bg-success'>Active</h4>";
    $voucherId = ($_GET['voucher_id']) ?? null;
    $voucherType = ['registered', 'all', 'birthday'];

    // Select one voucher
    $statement = $DB->prepare("SELECT * FROM voucher WHERE voucher_id = :voucherId"); 
    $statement ->bindValue(':voucherId', $voucherId, PDO::PARAM_INT);
    $statement ->execute();
    $voucher = $statement->fetch(PDO::FETCH_ASSOC);

    $voucherCode = $voucher['voucher_code'] ?? null;
    $discount = $voucher['voucher_discount'] ?? null;

    $startAt = $voucher['start_at'] ?? null;
    $expiresAt = $voucher['expires_at'] ?? null;

    $minOrder = $voucher['min_order'] ?? 0;

    if(!empty($startAt)){
        $startAt = date('Y-m-d', strtotime($voucher['start_at']));
    }
    else{
        $startAt = null;
    }

    if(!empty($expiresAt)){
        $expiresAt = date('Y-m-d', strtotime($voucher['expires_at']));
    }
    else{
        $expiresAt = null;
    }

    $voucherCodeErr = $discountErr = $startAtErr = $expiresAtErr = "";
    $voucherTypeErr = $minOrderErr = "";

    // If button add voucher
    if(isset($_POST['btnAddVoucher'])){
        include 'voucherProcess.php';

        // Check if voucher exists
        $statement = $DB->prepare("SELECT voucher_code FROM voucher WHERE voucher_code = :voucherCode"); 
        $statement ->bindValue(':voucherCode', $voucherCode, PDO::PARAM_STR);
        $statement ->execute();
        $count = $statement->rowCount();
        if($count == 1) {
            $voucherCodeErr = "This voucher code already exists!";
        }


        if(empty($voucherCodeErr) && empty($discountErr) && empty($expiresAtErr)){
            $statement = $DB->prepare("INSERT INTO voucher (voucher_code, voucher_discount, start_at, expires_at, voucher_type, min_order)
                VALUES (:voucherCode, :discount, :startAt, :expiresAt, :voucherType, :minOrder)"); 
            $statement->bindValue( ':voucherCode', $voucherCode, PDO::PARAM_STR);
            $statement->bindValue( ':discount', $discount, PDO::PARAM_INT);
            $statement->bindValue( ':startAt', $startAt, PDO::PARAM_STR);
            $statement->bindValue( ':expiresAt', $expiresAt, PDO::PARAM_STR);
            $statement->bindValue( ':voucherType', $voucherType, PDO::PARAM_STR);
            $statement->bindValue( ':minOrder', $minOrder, PDO::PARAM_INT);
            $statement->execute(); //sends the query to the sql database

            unset($voucherCode,$discount,$startAt,$expiresAt,$minOrder,$voucherType);
            unset($voucherCodeErr,$discountErr,$startAtErr,$expiresAtErr,$minOrderErr,$voucherTypeErr);

             // Display success message and exit
            $_SESSION['success'] = "Voucher Successfully Added!";                
            header('Location: voucher.php'); 
            exit;
        }
    }

    if(isset($_POST['btnModifyVoucher'])){
        include 'voucherProcess.php';
        
        if(empty($voucherCodeErr) && empty($discountErr) && empty($expiresAtErr)){
            $statement = $DB->prepare("UPDATE voucher
                SET voucher_code = :voucherCode, voucher_discount = :discount,
                    start_at = :startAt, expires_at = :expiresAt 
                WHERE voucher_id = :voucherId");

            $statement->bindValue( ':voucherCode', $voucherCode, PDO::PARAM_STR);
            $statement->bindValue( ':discount', $discount, PDO::PARAM_INT);
            $statement->bindValue( ':startAt', $startAt, PDO::PARAM_STR);
            $statement->bindValue( ':expiresAt', $expiresAt, PDO::PARAM_STR);
            $statement->bindValue( ':voucherId', $voucherId, PDO::PARAM_INT);
            $statement->execute(); //sends the query to the sql database

            unset($voucherCode,$discount,$startAt,$expiresAt);
            unset($voucherCodeErr,$discountErr,$startAtErr,$expiresAtErr);

             // Display success message and exit
            $_SESSION['success'] = "Voucher Successfully Modified!";                
            header('Location: voucher.php'); 
            exit;
        }
    }

                   
    $tab = $_GET['tab'] ?? 'all';   

    switch($tab){
        case 'add':
            $pageTitle = "Add Voucher";
            break;

        case 'manage':
            $pageTitle = "Manage Voucher";
            break;

        default:
            $pageTitle = "View All Voucher";
            break;
    }

    // Select all vouchers
    $statement = $DB->prepare("SELECT * FROM voucher");
    $statement->execute();
    $vouchers = $statement->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<?php include '../main/php/head.php';?>   
    <body>
        <?php include 'admin-nav.php';?>
        <main>
            <!-- Voucher -->
            <div class="container-lg">
                <div class="row g-3 g-md-4">
                    <div class="col-12">
                        <h2><?= $pageTitle?></h2>
                    </div>
                    <!-- Tab Toggle -->
                    <div class="col-12 d-flex">
                        <ul class="nav nav-tabs" id="myTab">
                            <li class="nav-item">
                                <a class="nav-link <?= ($tab==='all') ? 'active' : '' ?>" href="voucher.php?tab=all">All Voucher</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link <?= ($tab==='add') ? 'active' : '' ?>" href="voucher.php?tab=add">Add Voucher</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link <?= ($tab==='manage') ? 'active' : '' ?>" href="voucher.php?tab=manage">Manage Voucher</a>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="col-12">
                        <div class="tab-content">
                            
                            <!-- All Voucher -->
                            <div class="tab-pane fade  <?= $tab == 'all' ? 'show active' : '' ?>" id="allVoucher">
                                <!-- Voucher Table -->
                                <?php if($vouchers): ?>
                                    <div class="table-responsive">
                                        <table class="table text-center table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="text-main">Voucher ID</th>
                                                    <th scope="col" class="text-main">Voucher Code</th>
                                                    <th scope="col" class="text-main">Discount</th>
                                                    <th scope="col" class="text-main">Date Created</th>
                                                    <th scope="col" class="text-main">Expiration Date</th>
                                                    <th scope="col" class="text-main">Status</th>
                                                    <th scope="col" class="text-main">Manage</th>
                                                </tr>
                                            </thead>
                                        <?php
                                            foreach($vouchers as $v){
                                                echo '<tbody>';
                                                    echo '<tr>';
                                                        echo '<td scope="row"> '.$v['voucher_id'].' </td>';
                                                        echo '<td> '.$v['voucher_code'].' </td>';
                                                        echo '<td> '.$v['voucher_discount'].'%</td>';
                                                        echo '<td> '.(new DateTime(datetime: $v['created_at']))->format('Y-m-d').' </td>';
                                                        echo '<td> '.$v['expires_at'].' </td>';
                                                            // Voucher Status
                                                            if(!empty($v['expires_at']) && strtotime($v['expires_at']) < time()){
                                                                $voucherStatus = '<h4 class="badge bg-danger">Expired</h4>';
                                                            }
                                                            echo '<td>'.$voucherStatus.'</td>';
                                                        echo '<td>';
                                                        // Allow manage voucher
                                                        echo'
                                                            <a href="voucher.php?tab=manage&voucher_id='.(int)$v['voucher_id'].'">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                                                </svg>
                                                            </a>
                                                            ';
                                                        echo'
                                                            </td>';
                                                    echo '</tr>';
                                                echo '</tbody>';
                                            }
                                        ?>
                                            </table>
                                        </div>
                                    <?php else: ?>
                                            <p class="text-danger"> No items found</p>
                                <?php endif; ?>
                            </div>
                            
                            <!-- Add Voucher -->
                            <div class="tab-pane fade  <?= $tab == 'add' ? 'show active' : '' ?>" id="addVoucher">
                                 <div class="form-box">
                                    <div class="text-center">
                                        <h4>Adding a Voucher</h4>
                                        <h5>Please enter details below.</h5>
                                    </div>
                                    <div>
                                        <!-- Form Input Group -->
                                        <form method="post" class="row g-2" novalidate>
                                            <!-- Voucher Code -->
                                            <div class="col-md-6">
                                                <label for="voucherCode" class="form-label">Voucher Code:</label>
                                                <input type="text" class="form-control" name="voucherCode" id="voucherCode" placeholder="Enter Voucher Code"
                                                    value="<?php echo $voucherCode;?>">
                                                <h6 class="error"><?php echo $voucherCodeErr;?></h6>
                                            </div>
                                            <!-- Voucher Discount -->
                                            <div class="col-md-6">
                                                <label for="discount" class="form-label">Discount %:</label>
                                                <input type="int" min="0" max="100" class="form-control" name="discount" id="discount" placeholder="Enter Discount as Number"
                                                    value="<?php echo $discount;?>">
                                                <h6 class="error"><?php echo $discountErr;?></h6>
                                            </div>

                                            <!-- Start and Expiration Date -->
                                            <div class="col-md-6">
                                                <label for="startAt" class="form-label">Start Date:</label>
                                                <input type="date" class="form-control" name="startAt" id="startAt" 
                                                    value="<?php echo  !empty($startAt) ? $startAt : '';?>">
                                                <h6 class="error"><?php echo $startAtErr;?></h6>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="expiresAt" class="form-label">Expiration Date:</label>
                                                <input type="date" class="form-control" name="expiresAt" id="expiresAt" placeholder="Enter Expiration Date"
                                                    value="<?php echo $expiresAt;?>">
                                                <small>Leave blank if no expiration date.</small>
                                                <h6 class="error"><?php echo $expiresAtErr;?></h6>
                                            </div>
                                            <!-- Voucher Type -->
                                            <div class="col-md-6">
                                                <label for="voucherType" class="form-label">Voucher Type:</label>
                                                <select class="form-select"  name="voucherType">
                                                    <option selected>Select Voucher Type</option>
                                                    <?php foreach($voucherType as $t):?>
                                                        <option value="<?=$t?>"
                                                        <?= (isset($_GET['voucher_id']) && isset($v['voucher_type']) && $v['voucher_type'] == $t) ? 'selected' : '' ?>>
                                                            <?= ucfirst($t)?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <h6 class="error"><?php echo $voucherTypeErr;?></h6>
                                            </div>

                                            <!-- Minimum Order -->
                                            <div class="col-md-6">
                                                <label for="minOrder" class="form-label">Minimum Order:</label>
                                                <input type="number" class="form-control" name="minOrder" id="minOrder" 
                                                    value="<?php echo  $minOrder?>">
                                                <h6 class="error"><?php echo $minOrderErr;?></h6>
                                            </div>

                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary mb-3" name="btnAddVoucher"
                                                    value="btnAddVoucher" >Confirm</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Manage Voucher -->
                            <div class="tab-pane fade  <?= $tab == 'manage' ? 'show active' : '' ?>" id="selectVoucher">
                                 <div class="form-box">
                                    <div class="text-center">
                                        <h4>Manage a Voucher</h4>
                                        <h5>Please enter details below.</h5>
                                    </div>
                                    <div>
                                        <!-- Form Input Group -->
                                        <form method="get" class="row g-2" action="voucher.php">
                                            <input type="hidden" name="tab" value="manage">
                                            <label for="selectVoucher" class="form-label">Select Voucher Code:</label>
                                            <select class="form-select" aria-label="Default select example" name="voucher_id" onchange="this.form.submit()">
                                                <option value="0" selected>Select Voucher</option>
                                                <?php foreach($vouchers as $v):?>
                                                    <option value="<?=$v['voucher_id']?>"
                                                     <?= (isset($_GET['voucher_id']) && $_GET['voucher_id'] == $v['voucher_id']) ? 'selected' : '' ?>>
                                                        <?=$v['voucher_code']?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </form>

                                        <!-- Form to modify voucher -->
                                        <form method="post" class="row g-2" id="manageVoucher">
                                            <!-- Voucher Code -->
                                            <div class="col-md-6">
                                                <label for="voucherCode" class="form-label">Voucher Code:</label>
                                                <input type="text" class="form-control" name="voucherCode" id="voucherCode" placeholder="Enter Voucher Code"
                                                    value="<?php echo $voucherCode;?>">
                                                <h6 class="error"><?php echo $voucherCodeErr;?></h6>
                                            </div>
                                            <!-- Voucher Discount -->
                                            <div class="col-md-6">
                                                <label for="discount" class="form-label">Discount %:</label>
                                                <input type="int" min="0" max="100" class="form-control" name="discount" id="discount" placeholder="Enter Discount as Number"
                                                    value="<?php echo $discount;?>">
                                                <h6 class="error"><?php echo $discountErr;?></h6>
                                            </div>

                                            <!-- Start and Expiration Date -->
                                                <div class="col-md-6">
                                                <label for="startAt" class="form-label">Start Date:</label>
                                                <input type="date" class="form-control" name="startAt" id="startAt" 
                                                    value="<?php echo  !empty($startAt) ? $startAt : '';?>">
                                                <h6 class="error"><?php echo $startAtErr;?></h6>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="expiresAt" class="form-label">Expiration Date:</label>
                                                <input type="date" class="form-control" name="expiresAt" id="expiresAt" placeholder="Enter Expiration Date"
                                                    value="<?php echo $expiresAt;?>">
                                                <small>Leave blank if no expiration date.</small>
                                                <h6 class="error"><?php echo $expiresAtErr;?></h6>
                                            </div>

                                             <!-- Voucher Type -->
                                            <div class="col-md-6">
                                                <label for="voucherType" class="form-label">Voucher Type:</label>
                                                <select class="form-select"  name="voucherType">
                                                    <option selected>Select Voucher Type</option>
                                                    <?php foreach($voucherType as $t):?>
                                                        <option value="<?=$t?>"
                                                        <?= (isset($_GET['voucher_id']) && isset($v['voucher_type']) && $v['voucher_type'] == $t) ? 'selected' : '' ?>>
                                                            <?= ucfirst($t)?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <h6 class="error"><?php echo $voucherTypeErr;?></h6>
                                            </div>

                                            <!-- Minimum Order -->
                                            <div class="col-md-6">
                                                <label for="minOrder" class="form-label">Minimum Order:</label>
                                                <input type="number" class="form-control" name="minOrder" id="minOrder" 
                                                    value="<?php echo  !empty($minOrder) ? $minOrder : '';?>">
                                                <h6 class="error"><?php echo $minOrderErr;?></h6>
                                            </div>
                                            <!-- Button -->
                                            <div class="d-grid">
                                                <button type="submit" class="btn btn-primary mb-3" name="btnModifyVoucher"
                                                    value="btnModifyVoucher" >Confirm</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </main>
    <?php include '../main/php/script.php';?>
</body>
</html>
