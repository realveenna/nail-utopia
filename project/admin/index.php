<?php
    session_start();
    require_once '../connect.php';

    $totalRevenue = 0;
    $totalCustomer = 0;
    $totalProducts = 0;
    $newOrder = 0;

    $statement = $DB->prepare("SELECT id FROM userlogin WHERE user_type = :user");
    $statement->bindValue(':user', 'user', PDO::PARAM_STR);
    $statement->execute();
    $totalCustomer = $statement->rowCount();
       
    $statement = $DB->prepare("SELECT * FROM press_on");
    $statement->execute();
    $totalProducts = $statement->rowCount();

    $statement = $DB->prepare("SELECT * FROM orders WHERE order_status = ('pending')");
    $statement->execute();
    $newOrder = $statement->rowCount();
    
    $statement = $DB->prepare("SELECT MONTH(order_date) AS month_number,
        DATE_FORMAT(order_date, '%b') AS month_name,  SUM(subtotal + shipping_fee - discount) AS total_income 
        FROM orders WHERE YEAR(order_date) = YEAR(CURDATE()) AND order_status IN ('delivered', 'confirmed')
        GROUP BY MONTH(order_date) ORDER BY MONTH(order_date) ASC");
        
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);

    $dataPoints = [];

    $months = [
        1=>"Jan",2=>"Feb",3=>"Mar",4=>"Apr",5=>"May",6=>"Jun",
        7=>"Jul",8=>"Aug",9=>"Sep",10=>"Oct",11=>"Nov",12=>"Dec"
    ];

    $monthlyIncome = array_fill(1,12,0);

    foreach($result as $row){
        $monthlyIncome[(int)$row["month_number"]] = (float)$row["total_income"];
    }

    foreach($months as $num => $mname){
        $dataPoints[] = [
            "label" => $mname, // month
            "y" => $monthlyIncome[$num] // revenue
        ];
        $totalRevenue += $monthlyIncome[$num];
    }

?>

<!DOCTYPE html>
<html lang="en">
<?php include '../main/php/head.php';?>   
    <body>
        <?php include 'admin-nav.php';?>
        <main>
            <div class="container-lg">
               <div class="row g-3 g-md-4">
                  <!-- Dashboard -->   
                    <div class="col-12 col-lg-4">
                        <div class="secondary p-4 sticky px-2 px-md-5 py-4">
                           <div class="d-flex flex-column justify-content-between gap-3">
                                <div>
                                    <h1 class="text-center">Dashboard Menu</h1>
                                    <hr>
                                    <div class="text-center d-flex gap-2 mx-auto flex-column">
                                        <ul class="navbar-nav ms-2">
                                            <li class="nav-item">
                                                <a class="nav-link"  href="index.php">HOME</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link"  href="orders.php">ORDERS</a>
                                            </li>
                                             <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    PRODUCT
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="addDB.php">ADD PRODUCT</a></li>
                                                    <li><a class="dropdown-item" href="shop.php">VIEW PRODUCT</a></li>
                                                </ul>
                                            </li>
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    GALLERY
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="gallery.php">ADD GALLERY</a></li>
                                                    <li><a class="dropdown-item" href="viewGallery.php">SHOW GALLERY</a></li>
                                                </ul>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" href="staff.php">MANAGE STAFF</a>
                                            </li>
                                             <li class="nav-item">
                                                <a class="nav-link" href="customer.php">CUSTOMER</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <hr>
                                </div>
                                <div>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <a href="voucher.php" class="btn btn-light flex-fill"> Manage Voucher</a>
                                        <a href="storeHours.php" class="btn btn-secondary flex-fill">Manage Store Hours</a>
                                    </div>
                                </div>
                           </div>
                        </div>
                    </div>

                    <!-- MORE DETAILS -->
                    <div class="col-12 col-lg">
                          <div class="form-box small-gap py-4 h-100">
                             <div class="row gap-3">
                                <div class="card col-4 col-lg-4 col-xl-2 card-body py-3 px-2 text-center d-flex align-items-center justify-content-center">
                                    <h2 class="fw-bold text-danger"><?= $newOrder ?></h2>
                                    <h5 class="text-muted mb-2">New Orders</h5>
                                </div>
                                <div class="card col-4 col-lg-4 col-xl-2 card-body py-3 px-2 text-center d-flex align-items-center justify-content-center">
                                    <h2 class="fw-bold text-success">£ <?= $totalRevenue ?></h2>
                                    <h5 class="text-muted mb-2">Total Revenue</h5>
                                </div>
                                <div class="card col-4 col-lg-4 col-xl-2 card-body py-3 px-2 text-center d-flex align-items-center justify-content-center">
                                    <h2 class="fw-bold text-info"><?= $totalCustomer ?></h2>
                                    <h5 class="text-muted mb-2">Total Customers</h5>
                                </div>
                                <div class="card col-4 col-lg-4 col-xl-2 card-body py-3 px-2 text-center d-flex align-items-center justify-content-center">
                                    <h2 class="fw-bold text-warning"><?= $totalProducts ?></h2>
                                    <h5 class="text-muted mb-2">Total Products</h5>
                                </div>
                            </div>
                            <div id="chartContainer" style="height: 370px; width: 100%;"></div>
                        </div>
                    </div>

                  
                </div>
            </div>
        </main>
    <?php include '../main/php/script.php';?>
    <script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
        <script>
        window.onload = function () {
            var chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2",
                title: {
                    text: "Monthly Revenue (<?= date('Y') ?>)"
                },
                axisY: {
                    title: "Total Income (£)"
                },
                data: [{
                    type: "column",
                    yValueFormatString: "£#,##0",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            });
            chart.render();
        }
    </script>
</body>
</html>