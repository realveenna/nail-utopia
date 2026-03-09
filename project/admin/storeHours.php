<?php
    session_start();
    require_once '../connect.php';

    $today = date('Y-m-d');

    $hoursId = $_POST['hours_id'] ?? null; 

    // Select one open hour
    $statement = $DB->prepare("SELECT * FROM open_hours WHERE hours_id = :hoursId"); 
    $statement ->bindValue(':hoursId', $hoursId, PDO::PARAM_INT);
    $statement ->execute();
    $hour = $statement->fetch(PDO::FETCH_ASSOC);

    // Select all open hours
    $statement = $DB->prepare("SELECT * FROM open_hours"); 
    $statement ->execute();
    $days = $statement->fetchAll(PDO::FETCH_ASSOC);

   
    $statusBadgeColors = [
        '1'  => 'success',
        '0'  => 'danger',
    ];
    $statusBadgeBool = [
        '1'  => 'Open',
        '0'  => 'Close',
    ];
    $dayHourError = [];

    //Edit store hours
    if(isset($_POST['btnEditHours'])){
        foreach($days as $d){
            $hoursId = $d['hours_id'];

            $openHours = $_POST[$hoursId . '-open'];
            $closeHours = $_POST[$hoursId . '-close'];

            // validate Time
            if ($openHours >= $closeHours) {
                $dayHourError[$hoursId] = "Please enter valid open and closing time. Open time must be earlier than closing time.";
            }
        }

        if(empty($dayHourError)){
            $updateStmt = $DB->prepare("UPDATE open_hours 
                SET open_time = :open_time, close_time = :close_time, is_closed = :is_closed
                WHERE hours_id = :hours_id
            ");

            foreach($days as $d){
                $hoursId = $d['hours_id'];

                $openHours = $_POST[$hoursId . '-open'];
                $closeHours = $_POST[$hoursId . '-close'];
                $status = $_POST[$hoursId . '-status'] ?? 0;

                $updateStmt->bindValue(':open_time', $openHours, PDO::PARAM_STR);
                $updateStmt->bindValue(':close_time', $closeHours, PDO::PARAM_STR);
                $updateStmt->bindValue(':is_closed', $status, PDO::PARAM_INT);
                $updateStmt->bindValue(':hours_id', $hoursId, PDO::PARAM_INT);
                $updateStmt->execute();

            }
            
            $_SESSION['success'] = "Store hours successfully updated!";
            header('Location: storeHours.php'); 
            exit();
        }
    }

    $tab = $_GET['tab'] ?? 'hours';   
    switch($tab){
        case 'edit':
            $pageTitle = "Edit Store Hours";
            break;

        default:
            $pageTitle = "View Store Hours";

    }
print_r($_POST);
?>


<!DOCTYPE html>
<html lang="en">
<?php include '../main/php/head.php';?>   
    <body>
        <?php include 'admin-nav.php';?>
        <main>
            <!-- Opening Hours -->
            <div class="container-lg">
               <div class="row g-3 g-md-4">
                <div class="col-12">
                        <h2><?= $pageTitle?></h2>
                    </div>
                    <div class="col-12 d-flex">
                        <ul class="nav nav-tabs" id="hoursTab">
                            <li class="nav-item">
                                <a class="nav-link <?= ($tab==='hours') ? 'active' : '' ?>" href="storeHours.php?tab=hours">Store Hours</a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link <?= ($tab==='edit') ? 'active' : '' ?>" href="storeHours.php?tab=edit">Edit Hours</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-12">
                        <div class="tab-content">
                            <!-- Store Hours Section -->
                            <div class="tab-pane fade  <?= $tab == 'hours' ? 'show active' : '' ?>" id="storeHours">
                                <!-- Hours Table -->
                                <?php
                                    if($days){
                                        echo' 
                                        <div class="table-responsive">
                                            <table class="table text-center table-hover">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="text-main">Day of Week</th>
                                                        <th scope="col" class="text-main">Opening Time</th>
                                                        <th scope="col" class="text-main">Closing Time</th>
                                                        <th scope="col" class="text-main">Status</th>
                                                    </tr>
                                                </thead>';
                                            echo '<tbody>';
                                        foreach($days as $d){
                                                echo '<tr>';
                                                echo '<td> '.$d['day_of_week'] .'</td>';
                                                echo '<td> '. date("h:i a", strtotime($d['open_time'])) .'</td>';
                                                echo '<td> '. date("h:i a", strtotime($d['close_time']))  .'</td>';
                                                echo '<td class="text-capitalize">
                                                        <h4 class="badge bg-'.$statusBadgeColors[$d['is_closed']].'">
                                                                '.$statusBadgeBool[$d['is_closed']].'
                                                        </h4>
                                                        </td>';
                                            echo '</tr>';
                                        }
                                        echo '</tbody>';
                                    }else{
                                        echo '<h5 class="text-center text-danger"> No result Found!</h5>';
                                    }
                                    echo '</table>
                                        </div>
                                    ';
                                ?>
                            </div>
                            
                            <!-- Edit Store Hours Section -->
                            <div class="tab-pane fade  <?= $tab == 'edit' ? 'show active' : '' ?>" id="editHours">
                                 <div class="form-box">
                                    <div class="text-center">
                                        <h4>Editing Store Hours</h4>
                                        <h5>Please enter details below.</h5>
                                    </div>
                                    <div>
                                        <!-- Form Input Group -->
                                        <form class="p-0 m-0" method="post">
                                            <?php foreach ($days as $d): ?>
                                                <div class="row gap-3">
                                                    <div class="col-12 text-start p-0 m-0">
                                                        <div class="mb-3 row">
                                                            <!-- Label for day -->
                                                            <label for="<?= $d['day_of_week']?>" class="col-8 col-form-label">
                                                                <?=$d['day_of_week']?>
                                                            </label>
                                                            <!-- Status Label -->
                                                            <div class="col-4">
                                                                <label for="<?= $d['day_of_week']?>-status" class="col-8 col-form-label">
                                                                    Status
                                                                </label>
                                                            </div>
                                                            <!-- Open Hours -->
                                                            <div class="col-sm-4">
                                                                <input type="time" class="form-control" id="<?=$d['hours_id']?>-open"
                                                                name="<?=$d['hours_id']?>-open" 
                                                                value="<?=htmlspecialchars($d['open_time'] ?? $openHours[$d['hours_id']] )?>">
                                                            </div>
                                                            <!-- Close Hours -->
                                                            <div class="col-sm-4">
                                                                <input type="time" class="form-control" id="<?=$d['hours_id']?>-close"
                                                                name="<?=$d['hours_id']?>-close" value="<?=htmlspecialchars( $d['close_time'] ?? $closeHours[$d['hours_id']] )?>">
                                                            </div>
                                                            <!-- Status  -->
                                                            <div class="col-sm-4">
                                                                <select class="form-select" aria-label="hours-status"  name = "<?=$d['hours_id']?>-status">
                                                                    <?php foreach ($statusBadgeBool as $key => $status) :?>
                                                                        <option value="<?=$key ?>"
                                                                        <?= ((int)$d['is_closed'] === (int)$key) ? 'selected' : '' ?>>
                                                                            <?=$status?>
                                                                        </option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <h6 class="error"><?= $dayHourError[$d['hours_id']] ?? ''?></h6>
                                                </div>
                                            <?php endforeach; ?>
                                             
                                            <div class="row">
                                                <div class="col-12 d-flex gap-2">
                                                    <button type="submit" class="w-100 btn flex-fill btn-primary" name="btnEditHours" value="btnEditHours">Confirm</button>
                                                    <button type="button" class="w-100 btn flex-fill btn-light" data-bs-dismiss="modal">Back</button>
                                                </div>
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
