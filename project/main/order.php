<?php 
    session_start();
    include '../connect.php';
    require_once './php/test_input.php';


    $countries =
    array(
    "AF" => "Afghanistan",
    "AL" => "Albania",
    "DZ" => "Algeria",
    "AS" => "American Samoa",
    "AD" => "Andorra",
    "AO" => "Angola",
    "AI" => "Anguilla",
    "AQ" => "Antarctica",
    "AG" => "Antigua and Barbuda",
    "AR" => "Argentina",
    "AM" => "Armenia",
    "AW" => "Aruba",
    "AU" => "Australia",
    "AT" => "Austria",
    "AZ" => "Azerbaijan",
    "BS" => "Bahamas",
    "BH" => "Bahrain",
    "BD" => "Bangladesh",
    "BB" => "Barbados",
    "BY" => "Belarus",
    "BE" => "Belgium",
    "BZ" => "Belize",
    "BJ" => "Benin",
    "BM" => "Bermuda",
    "BT" => "Bhutan",
    "BO" => "Bolivia",
    "BA" => "Bosnia and Herzegovina",
    "BW" => "Botswana",
    "BV" => "Bouvet Island",
    "BR" => "Brazil",
    "IO" => "British Indian Ocean Territory",
    "BN" => "Brunei Darussalam",
    "BG" => "Bulgaria",
    "BF" => "Burkina Faso",
    "BI" => "Burundi",
    "KH" => "Cambodia",
    "CM" => "Cameroon",
    "CA" => "Canada",
    "CV" => "Cape Verde",
    "KY" => "Cayman Islands",
    "CF" => "Central African Republic",
    "TD" => "Chad",
    "CL" => "Chile",
    "CN" => "China",
    "CX" => "Christmas Island",
    "CC" => "Cocos (Keeling) Islands",
    "CO" => "Colombia",
    "KM" => "Comoros",
    "CG" => "Congo",
    "CD" => "Congo, the Democratic Republic of the",
    "CK" => "Cook Islands",
    "CR" => "Costa Rica",
    "CI" => "Cote D'Ivoire",
    "HR" => "Croatia",
    "CU" => "Cuba",
    "CY" => "Cyprus",
    "CZ" => "Czech Republic",
    "DK" => "Denmark",
    "DJ" => "Djibouti",
    "DM" => "Dominica",
    "DO" => "Dominican Republic",
    "EC" => "Ecuador",
    "EG" => "Egypt",
    "SV" => "El Salvador",
    "GQ" => "Equatorial Guinea",
    "ER" => "Eritrea",
    "EE" => "Estonia",
    "ET" => "Ethiopia",
    "FK" => "Falkland Islands (Malvinas)",
    "FO" => "Faroe Islands",
    "FJ" => "Fiji",
    "FI" => "Finland",
    "FR" => "France",
    "GF" => "French Guiana",
    "PF" => "French Polynesia",
    "TF" => "French Southern Territories",
    "GA" => "Gabon",
    "GM" => "Gambia",
    "GE" => "Georgia",
    "DE" => "Germany",
    "GH" => "Ghana",
    "GI" => "Gibraltar",
    "GR" => "Greece",
    "GL" => "Greenland",
    "GD" => "Grenada",
    "GP" => "Guadeloupe",
    "GU" => "Guam",
    "GT" => "Guatemala",
    "GN" => "Guinea",
    "GW" => "Guinea-Bissau",
    "GY" => "Guyana",
    "HT" => "Haiti",
    "HM" => "Heard Island and Mcdonald Islands",
    "VA" => "Holy See (Vatican City State)",
    "HN" => "Honduras",
    "HK" => "Hong Kong",
    "HU" => "Hungary",
    "IS" => "Iceland",
    "IN" => "India",
    "ID" => "Indonesia",
    "IR" => "Iran, Islamic Republic of",
    "IQ" => "Iraq",
    "IE" => "Ireland",
    "IL" => "Israel",
    "IT" => "Italy",
    "JM" => "Jamaica",
    "JP" => "Japan",
    "JO" => "Jordan",
    "KZ" => "Kazakhstan",
    "KE" => "Kenya",
    "KI" => "Kiribati",
    "KP" => "Korea, Democratic People's Republic of",
    "KR" => "Korea, Republic of",
    "KW" => "Kuwait",
    "KG" => "Kyrgyzstan",
    "LA" => "Lao People's Democratic Republic",
    "LV" => "Latvia",
    "LB" => "Lebanon",
    "LS" => "Lesotho",
    "LR" => "Liberia",
    "LY" => "Libyan Arab Jamahiriya",
    "LI" => "Liechtenstein",
    "LT" => "Lithuania",
    "LU" => "Luxembourg",
    "MO" => "Macao",
    "MK" => "Macedonia, the Former Yugoslav Republic of",
    "MG" => "Madagascar",
    "MW" => "Malawi",
    "MY" => "Malaysia",
    "MV" => "Maldives",
    "ML" => "Mali",
    "MT" => "Malta",
    "MH" => "Marshall Islands",
    "MQ" => "Martinique",
    "MR" => "Mauritania",
    "MU" => "Mauritius",
    "YT" => "Mayotte",
    "MX" => "Mexico",
    "FM" => "Micronesia, Federated States of",
    "MD" => "Moldova, Republic of",
    "MC" => "Monaco",
    "MN" => "Mongolia",
    "MS" => "Montserrat",
    "MA" => "Morocco",
    "MZ" => "Mozambique",
    "MM" => "Myanmar",
    "NA" => "Namibia",
    "NR" => "Nauru",
    "NP" => "Nepal",
    "NL" => "Netherlands",
    "AN" => "Netherlands Antilles",
    "NC" => "New Caledonia",
    "NZ" => "New Zealand",
    "NI" => "Nicaragua",
    "NE" => "Niger",
    "NG" => "Nigeria",
    "NU" => "Niue",
    "NF" => "Norfolk Island",
    "MP" => "Northern Mariana Islands",
    "NO" => "Norway",
    "OM" => "Oman",
    "PK" => "Pakistan",
    "PW" => "Palau",
    "PS" => "Palestinian Territory, Occupied",
    "PA" => "Panama",
    "PG" => "Papua New Guinea",
    "PY" => "Paraguay",
    "PE" => "Peru",
    "PH" => "Philippines",
    "PN" => "Pitcairn",
    "PL" => "Poland",
    "PT" => "Portugal",
    "PR" => "Puerto Rico",
    "QA" => "Qatar",
    "RE" => "Reunion",
    "RO" => "Romania",
    "RU" => "Russian Federation",
    "RW" => "Rwanda",
    "SH" => "Saint Helena",
    "KN" => "Saint Kitts and Nevis",
    "LC" => "Saint Lucia",
    "PM" => "Saint Pierre and Miquelon",
    "VC" => "Saint Vincent and the Grenadines",
    "WS" => "Samoa",
    "SM" => "San Marino",
    "ST" => "Sao Tome and Principe",
    "SA" => "Saudi Arabia",
    "SN" => "Senegal",
    "CS" => "Serbia and Montenegro",
    "SC" => "Seychelles",
    "SL" => "Sierra Leone",
    "SG" => "Singapore",
    "SK" => "Slovakia",
    "SI" => "Slovenia",
    "SB" => "Solomon Islands",
    "SO" => "Somalia",
    "ZA" => "South Africa",
    "GS" => "South Georgia and the South Sandwich Islands",
    "ES" => "Spain",
    "LK" => "Sri Lanka",
    "SD" => "Sudan",
    "SR" => "Suriname",
    "SJ" => "Svalbard and Jan Mayen",
    "SZ" => "Swaziland",
    "SE" => "Sweden",
    "CH" => "Switzerland",
    "SY" => "Syrian Arab Republic",
    "TW" => "Taiwan, Province of China",
    "TJ" => "Tajikistan",
    "TZ" => "Tanzania, United Republic of",
    "TH" => "Thailand",
    "TL" => "Timor-Leste",
    "TG" => "Togo",
    "TK" => "Tokelau",
    "TO" => "Tonga",
    "TT" => "Trinidad and Tobago",
    "TN" => "Tunisia",
    "TR" => "Turkey",
    "TM" => "Turkmenistan",
    "TC" => "Turks and Caicos Islands",
    "TV" => "Tuvalu",
    "UG" => "Uganda",
    "UA" => "Ukraine",
    "AE" => "United Arab Emirates",
    "GB" => "United Kingdom",
    "US" => "United States",
    "UM" => "United States Minor Outlying Islands",
    "UY" => "Uruguay",
    "UZ" => "Uzbekistan",
    "VU" => "Vanuatu",
    "VE" => "Venezuela",
    "VN" => "Viet Nam",
    "VG" => "Virgin Islands, British",
    "VI" => "Virgin Islands, U.s.",
    "WF" => "Wallis and Futuna",
    "EH" => "Western Sahara",
    "YE" => "Yemen",
    "ZM" => "Zambia",
    "ZW" => "Zimbabwe"
    );

    // If ever user is a guest
    $userId = $_SESSION['userId'] ?? null; 
    $user_session = session_id();

    $fNameOrder = $lNameOrder = $emailOrder = "";
    $fNameOrderErr = $lNameOrderErr = $emailOrderErr = "";

    $line1 = $line2 = $city = $postcode = $country = "";
    $line1Err = $line2Err = $cityErr =  $postcodeErr = $countryErr = "";

    $paymentErr = "";
    
    // set values
    $cart_id = $_SESSION['cart_id'];
    $totalItems = $_SESSION['totalItems'];
    $shippingFee = $_SESSION['shippingFee'];
    $subtotal = $_SESSION['subtotal'];
    $total = $_SESSION['total'] ;
    $totalDiscounted = $_SESSION['totalDiscounted'] ?? 0;
    $totalItems = $_SESSION['totalItems'] ?? 0;
    $appliedVoucher = $_SESSION['appliedVoucher'] ?? null;
    $voucherDiscount = $_SESSION['appliedVoucherDiscount'] ?? null;
    $voucherId = $_SESSION['voucherId'] ?? null; 
    $address_id =  $userAddress['address_id'] ?? 0;


    // If no items in cart
    if(!isset($_SESSION['totalItems']) || $_SESSION['totalItems'] <= 0){
        $_SESSION['errors'] = 'Oops! Your cart is empty. Browse our collection and add your favourite nails before checking out.';
        header('Location: shop.php');
        exit(); 
    }

    // If user is logged in and registered then get user details
    if($userId !== null){
        $statement = $DB->prepare("SELECT id, email, fname, lname FROM userLogin WHERE  id = :userId LIMIT 1");
        $statement->bindValue(':userId', $userId,PDO::PARAM_INT);
        $statement->execute();
        $userDetails = $statement->fetch(PDO::FETCH_ASSOC);
    }
    // If user exists update form value
    if($userDetails){
        $fNameOrder = $userDetails['fname'];
        $lNameOrder = $userDetails['lname'];
        $emailOrder = $userDetails['email'];

        $statement = $DB->prepare("SELECT * FROM addresses WHERE  id = :userId ORDER BY address_id DESC LIMIT 1");
        $statement->bindValue(':userId', $userId,PDO::PARAM_INT);
        $statement->execute();
        $userAddress = $statement->fetch(PDO::FETCH_ASSOC);
    }

    // If user has existing address in database set value
    if($userAddress){
        $address_id = $userAddress['address_id'];
        $line1 = $userAddress['line_1']; 
        $line2 = $userAddress['line_2']; 
        $city = $userAddress['city'];
        $postcode = $userAddress['postcode'];
        $country = $userAddress['country'];
    }

    // If details is submitted
    if(isset($_POST['confirmDetails'])){
        unset($_SESSION['orderDetailsConfirmed']);

        $fNameOrder = $_POST['fNameOrder'];
        $lNameOrder = $_POST['lNameOrder'];
        $emailOrder =  $_POST['emailOrder'];

        if(empty($fNameOrder)){
            $fNameOrderErr = "Please enter first name.";
        }
        if(empty($lNameOrder)){
            $lNameOrderErr = "Please enter last name.";
        }
        if(empty($emailOrder)){
            $emailOrderErr = "Please enter an email address.";
        }else{
            $emailOrder = test_input($_POST['emailOrder']);
            if(!filter_var($emailOrder, FILTER_VALIDATE_EMAIL)) {
                $emailOrderErr = "Invalid email format";
            }
        }

        $line1 = $_POST['line1'];
        $line2 = $_POST['line2'];
        $city = $_POST['city'];
        $postcode = $_POST['postcode'];
        $country = $_POST['country'];

        if(empty($line1)){
            $line1Err = "House number and street is required.";
        }
        if(empty($city)){
            $cityErr = "Please enter a city";
        }
        if(empty($postcode)){
            $postcodeErr = "Please enter a postcode";
        }
        if(empty($country) || $country === ""){
            $countryErr = "Please select a country";
        }

        
        // Add address to db
        if(empty($fNameOrderErr) && empty($lNameOrderErr) && empty($emailOrderErr) && empty($line1Err)
            && empty($line2Err) && empty($cityErr) && empty($postcodeErr) && empty($countryErr)){

            // avoid inserting duplicate address
            $check = $DB->prepare("SELECT id, line_1, postcode FROM addresses 
                 WHERE id = :userId AND line_1 = :line1 AND postcode = :postcode LIMIT 1");

            $check->bindValue(':userId', $userId, PDO::PARAM_INT);
            $check->bindValue(':line1', $line1,PDO::PARAM_STR);
            $check->bindValue(':postcode', $postcode,PDO::PARAM_STR);
            $check->execute();
            $duplicate = $check->fetch(PDO::FETCH_ASSOC);

            if($duplicate){
                 $address_id = $duplicate['address_id'] ?? '';
            }
            else{
                //Pass the variable values to be inserted into the database
                $statement = $DB->prepare("INSERT INTO addresses 
                    (id, line_1, line_2, city, country, postcode, user_session)
                    VALUES (?, ?, ?, ?, ?, ?, ?)");

                $statement->bindValue(1, $userId, $userId ? PDO::PARAM_INT : PDO::PARAM_NULL);
                $statement->bindValue(2, $line1,PDO::PARAM_STR);
                $statement->bindValue(3, $line2,PDO::PARAM_STR);
                $statement->bindValue(4, $city,PDO::PARAM_STR);
                $statement->bindValue(5, $country,PDO::PARAM_STR);
                $statement->bindValue(6, $postcode,PDO::PARAM_STR);
                $statement->bindValue(7, $user_session,PDO::PARAM_STR);

                $statement->execute();

                $address_id = $DB->lastInsertId();
            }
            
            // Display success message and exit
            $_SESSION['success'] = "Details confirmed! Please continue to payment.";
            $_SESSION['orderDetailsConfirmed'] = true;

        }
    }
    // Payment Button
    if(isset($_POST['payment'])){
        //Pass the variable values to be inserted into the database
        $statement = $DB->prepare("INSERT INTO orders 
            (cart_id, discount, shipping_fee ,voucher_id ,subtotal ,total,
                order_status, address_id, total_items)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $statement->bindValue(1, $cart_id,  PDO::PARAM_INT);
        $statement->bindValue(2, $totalDiscounted,PDO::PARAM_INT);
        $statement->bindValue(3, $shippingFee,PDO::PARAM_INT);
        $statement->bindValue(4, $voucherId,PDO::PARAM_INT);
        $statement->bindValue(5, $subtotal,PDO::PARAM_INT);
        $statement->bindValue(6, $total,PDO::PARAM_INT);
        $statement->bindValue(7, 'pending',PDO::PARAM_STR);
        $statement->bindValue(8, $address_id,PDO::PARAM_INT);
        $statement->bindValue(9, $totalItems,PDO::PARAM_INT);

        $statement->execute();

        // Get last order id
        $lastOrderId = $DB->lastInsertId();
        $currentDate = date("Ymd"); 

        $orderNumber = "NU-". $currentDate . "-". sprintf('%05d', $lastOrderId);

        $stmtUpdateOrders = $DB->prepare("UPDATE orders SET order_number = ? WHERE order_id = ?");
        $stmtUpdateOrders->bindValue(1, $orderNumber,  PDO::PARAM_STR);
        $stmtUpdateOrders->bindValue(2, $lastOrderId,  PDO::PARAM_INT);

        $stmtUpdateOrders->execute();

        // Update cart status
        $stmtUpdateCart = $DB->prepare("UPDATE cart SET cart_status = :cart_status WHERE cart_id = :cart_id");
        $stmtUpdateCart->bindValue(':cart_status', 'ordered',PDO::PARAM_STR);
        $stmtUpdateCart->bindValue(':cart_id', $cart_id,PDO::PARAM_INT);
        $stmtUpdateCart->execute();

        // Update voucher claim status to claimed
        if ($userId) {
            $stmtClaimed = $DB->prepare(" UPDATE voucher_claim SET claim_status = :claimed 
                WHERE id = :userId AND voucher_id = :voucherId AND claim_status = :applied");
            $stmtClaimed->bindValue(':userId', $userId, PDO::PARAM_INT);
        } else {
            $stmtClaimed = $DB->prepare(" UPDATE voucher_claim SET claim_status = :claimed 
                WHERE session_id = :user_session AND voucher_id = :voucherId AND claim_status = :applied");
            $stmtClaimed->bindValue(':user_session', $user_session, PDO::PARAM_STR);
        }

        $stmtClaimed->bindValue(':claimed', 'claimed',PDO::PARAM_STR);
        $stmtClaimed->bindValue(':applied', 'applied',PDO::PARAM_STR);
        $stmtClaimed->bindValue(':voucherId', $voucherId,PDO::PARAM_INT);
        $stmtClaimed->execute();
        
        unset($_SESSION['voucherId']);
        unset($_SESSION['appliedVoucher']);
        unset($_SESSION['appliedVoucherDiscount']);

        // Display success message and exit
        $_SESSION['success'] = "Purchase successful! Your order number is " .$orderNumber;
        unset($_SESSION['orderDetailsConfirmed']);
        header('Location: index.php');
        exit();
    }


?>

<!DOCTYPE html>
<html lang="en">
<?php include './php/head.php';?>    
<body>
    <?php include './php/nav.php';?>   
   <main>
        <!-- Cart -->
        <div class="container-lg">
            <div class="row g-3 g-md-4">
                    <!-- Cart Items -->
                    <div class="col-12 col-xl-8">
                        <form class="p-0 m-0" method="post">
                            <div class="form-box small-gap mb-3 py-4">
                                <h2>Delivery Details:</h2>
                                <div class="row gap-3">
                                    <!-- Contact Details -->
                                    <div class="col-12 text-start p-0 m-0">
                                        <div class="row p-0 m-0">
                                            <div class="col-12 ">
                                                <h4>Contact Information:</h4>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="fNameOrder" class="form-label">First Name</label>
                                                <input type="text" class="form-control" id="fNameOrder" name="fNameOrder"
                                                placeholder="Enter First Name"
                                                value="<?php echo $fNameOrder;?>">
                                                <h6 class="error"><?php echo $fNameOrderErr;?></h6>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="lNameOrder" class="form-label">Last Name</label>
                                                <input type="text" class="form-control" id="lNameOrder" name="lNameOrder" 
                                                placeholder="Enter Last Name"
                                                value="<?php echo $lNameOrder;?>">
                                                <h6 class="error"><?php echo $lNameOrderErr;?></h6>
                                            </div>
                                            <div class="col-md-12">
                                                <label for="emailOrder" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="emailOrder" name="emailOrder" 
                                                placeholder="Enter Email"
                                                value="<?php echo $emailOrder;?>">
                                                <h6 class="error"><?php echo $emailOrderErr;?></h6>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delivery Details -->
                                    <div class="col-12 text-start  p-0 m-0">
                                        <div class="row  p-0 m-0">
                                            <div class="col-12">
                                                <h4>Delivery Address:</h4>
                                            </div>
                                            <div class="col-12">
                                                <label for="line1" class="form-label">Address Line 1: </label>
                                                <input type="text" class="form-control" id="line1" name="line1" 
                                                placeholder="House number + Street"
                                                value="<?php echo $line1;?>">
                                                <h6 class="error"><?php echo $line1Err;?></h6>
                                            </div>
                                            <div class="col-12">
                                                <label for="line2" class="form-label">Address Line 2:</label>
                                                <input type="text" class="form-control" id="line2" name="line2" 
                                                placeholder="Flat / Apartment (optional)"
                                                value="<?php echo $line2;?>">
                                                <h6 class="error"><?php echo $line2Err;?></h6>
                                            </div>
                                            <div class="col-12">
                                                <label for="city" class="form-label">City:</label>
                                                <input type="text" class="form-control" id="city" name="city" 
                                                placeholder="Enter City"
                                                value="<?php echo $city;?>">
                                                <h6 class="error"><?php echo $cityErr;?></h6>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="postcode" class="form-label">Postcode:</label>
                                                <input type="text" class="form-control" id="postcode" name="postcode" 
                                                placeholder="Enter Postcode"
                                                value="<?php echo $postcode;?>">
                                                <h6 class="error"><?php echo $postcodeErr;?></h6>
                                            </div>
                                            <div class="col-12 col-md-6">
                                                <label for="country" class="form-label">Country:</label>
                                                <select class="form-select" autocomplete="country" id="country" name="country">
                                                    <option value="" disabled selected> Select Country:</option>
                                                    <?php foreach ($countries as $c): ?>
                                                        <option value="<?= $c ?>"
                                                            <?php 
                                                                if($country === $c){
                                                                    echo 'selected';
                                                                }
                                                            ?>>
                                                         <?= $c?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <h6 class="error"><?php echo $countryErr;?></h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="cart.php" class="btn btn-light w-100"> Return to Cart </a>
                                            <button type="submit" class="btn btn-primary w-100" name="confirmDetails">
                                                <?php if (isset($_SESSION['orderDetailsConfirmed']) && $_SESSION['orderDetailsConfirmed'] === true ):?>
                                                    Update
                                                <?php else: ?>
                                                    Confirm
                                                <?php endif; ?>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- Cart Summary -->
                    <div class="col-12 col-xl">
                        <div class="secondary p-4 sticky px-4 py-3">
                            <div class="d-flex flex-column justify-content-between gap-5 w-auto">
                                <div>
                                    <h2 class="text-center">Summary: </h2>
                                    <hr>
                                    <?php if($totalItems >= 1):?>
                                        <div class="row gy-2 px-2 text-center">
                                            <div class="col-6 text-start">Total Items</div>
                                            <div class="col-6 text-end fw-bold"><?= $totalItems ?></div>
                                            
                                            <!-- Subtotal -->
                                            <div class="col-6 text-start">Subtotal</div>
                                            <div class="col-6 text-end fw-bold">£<?= $subtotal ?></div>

                                            <?php if(isset($_SESSION['appliedVoucher']) and isset($_SESSION['appliedVoucherDiscount'])):?>
                                            <div class="col-6 text-start"><?= $_SESSION['appliedVoucher']?> </div>
                                            <div class="col-6 text-end fw-bold text-success">-<?= $_SESSION['appliedVoucherDiscount'] ?>%</div>
                                            <?php endif ;?>
                                            
                                            <!-- Total Discounted -->
                                            <?php if(isset($_SESSION['totalDiscounted']) && $_SESSION['totalDiscounted'] > 0):?>
                                            <div class="col-6 text-start">Total Discounted</div>
                                            <div class="col-6 text-end fw-bold text-danger">£<?= $totalDiscounted ?></div>
                                            <?php endif ;?>


                                            <!-- Shipping Fee -->
                                            <?php if($total > 1):?>
                                                <hr class="mb-0">
                                                <div class="col-6 text-start">Shipping Fee</div>
                                                <div class="col-6 text-end fw-bold">£<?= $shippingFee ?></div>
                                            <?php endif ;?>

                                            <!-- Total -->
                                            <hr class="mb-0">
                                            <div class="col-6 text-start"><h4 class="fw-bold">Total</h4></div>
                                            <div class="col-6 text-end"><h4 class="fw-bold"><?=$total?></h4></div>
                                           
                                        </div>
                                    <?php endif;?>
                                </div>
                                <?php if (isset($_SESSION['orderDetailsConfirmed']) && $_SESSION['orderDetailsConfirmed'] === true ):?>
                                    <form method="post" class="p-0 m-0 mt-2" >
                                        <button type="submit" class="btn btn-primary w-100" name="payment" value="payment">Continue to Payment</button>
                                    </form>
                                <?php endif; ?>

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

