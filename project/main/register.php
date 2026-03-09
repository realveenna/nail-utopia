<?php
    session_start();
    require_once '../connect.php';
    require_once './php/test_input.php';

    $date = new DateTime();

    // Define variables and set to empty values
    $fnameErr = $lnameErr = $emailErr = $passErr = $birthdayErr = "";
    $fname = $lname = $email = $rawPass = $birthday = "";
    $terms = $newsletter = "";
    $termsErr = "";
  
    // Register PHP Validation
    if(isset($_POST['register'])) {
        $terms = (int)($_POST['checkTerms'] ?? 0);
        $newsletterStatus = (int)($_POST['checkNewsletter'] ?? 0); 
        
       
        // Validate Email First
         if (empty($_POST["email"])) {
            $emailErr = "Email is required";
        } else {
            $email = test_input($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            }else{
                // Check if email is already registered
                $statement=$DB->prepare("SELECT * FROM userLogin WHERE email = :email");
                $statement->bindValue( ':email', $email, PDO::PARAM_STR);
                $statement->execute(); //sends the query to the sql database

                // If successful then the database should generate 1 row that matches our login details
                $count = $statement->rowCount();

                // If email is already registered display error 
                if($count==1) {
                    $emailErr = 'Email is already registered! Click <a href="login.php">here</a> to login instead.';
                }

                // Only if not registered, then validate the rest of the input
                else{
                    // Validate First Name
                    if (empty($_POST["fName"])) {
                        $fnameErr = "First name is required";
                    } else {
                        $fname = test_input($_POST["fName"]);
                        // Check if name only contains letters and whitespace
                        if (!preg_match("/^[a-zA-Z-' ]*$/",$fname)) {
                        $fnameErr = "Only letters and white space allowed";
                        }
                    }

                    // Validate Last Name
                    if (empty($_POST["lName"])) {
                        $lnameErr = "Last name is required";
                    } else {
                        $lname = test_input($_POST["lName"]);
                        // check if name only contains letters and whitespace
                        if (!preg_match("/^[a-zA-Z-' ]*$/",$lname)) {
                        $lnameErr = "Only letters and white space allowed";
                        }
                    }

                    // Validate Password
                    if (empty($_POST["password"])) {
                        $passErr = "Password is required";
                    } else {
                        $rawPass = test_input($_POST["password"]);
                        if (strlen($_POST["password"]) <= 8) {
                            $passErr = "Your Password Must Contain At Least 8 Characters!";
                        }
                        elseif(!preg_match("#[0-9]+#",$rawPass)) {
                            $passErr = "Your Password Must Contain At Least 1 Number!";
                        }
                        elseif(!preg_match("#[A-Z]+#",$rawPass)) {
                            $passErr = "Your Password Must Contain At Least 1 Capital Letter!";
                        }
                        elseif(!preg_match("#[a-z]+#",$rawPass)) {
                            $passErr = "Your Password Must Contain At Least 1 Lowercase Letter!";
                        }
                        // Hash password if valid
                        else{
                            $salt ="4g£yc7!L(";
                            $pass = md5($rawPass.$salt);
                        }
                    }
                    
                    // Validate age
                    if (empty($_POST["birthday"])) {
                        $birthdayErr = "Birthday is required";
                    }else{
                        $birthday = test_input($_POST['birthday']);
                        $birthday_obj = new DateTime($birthday);
                        $diff = $date->diff($birthday_obj);
                        $yearGap = $diff->y;
                        
                        if($yearGap < 18){
                            $birthdayErr = 'You must be 18 years old to continue';
                        }
                    }
                }
            }
        }
     

        // If there are no error message (inputs are all valid)
        if(empty($fnameErr) && empty($lnameErr) && empty($emailErr) 
            && empty($passErr) && empty($birthdayErr)){

            // If terms is checked then submit form
            if($terms === 1){

                // Set default details
                $user_type = 'user'; // default user_type
                $date_registered = date("Y-m-d");  // get current registered date

                //Pass the variable values to be inserted into the database
                $statement = $DB->prepare("INSERT INTO userLogin(fname, lname, email, pass, birthday, user_type, date_registered)
                VALUES (:fname, :lname, :email, :pass, :birthday, :user_type, :date_registered)
                ");
                                    
                $statement->bindValue(':fname', $fname, PDO::PARAM_STR);
                $statement->bindValue(':lname', $lname, PDO::PARAM_STR);
                $statement->bindValue(':email', $email, PDO::PARAM_STR);
                $statement->bindValue(':pass', $pass, PDO::PARAM_STR);
                $statement->bindValue(':birthday', $birthday, PDO::PARAM_STR);
                $statement->bindValue(':user_type', $user_type, PDO::PARAM_STR);
                $statement->bindValue(':date_registered', $date_registered, PDO::PARAM_STR);

                $statement->execute();

                // Get insert id
                $id = $DB->lastInsertId(); 
                
                $newsletterStatus = ($newsletterStatus === 1) ? 'subscribed' : 'unsubscribed';

                $statement = $DB->prepare("INSERT INTO newsletter (id, newsletter_status)
                    VALUES (:userId, :newsletterStatus)
                    ON DUPLICATE KEY UPDATE newsletter_status = :newsletterStatus ");

                $statement->bindValue(':userId', $id, PDO::PARAM_INT);
                $statement->bindValue(':newsletterStatus', $newsletterStatus, PDO::PARAM_STR);
                $statement->execute();

                // Clear all input
                unset($fnameErr, $lnameErr, $emailErr, $passErr, $birthdayErr, $success);
                unset($fname, $lname, $email, $rawPass, $birthday);

                // Display success message and exit
                $_SESSION['success'] = "Registered Successfully. Click <a href='login.php'>here</a> to login.";                
                header('Location: register.php'); 
                exit();
            }
            else{
                $termsErr = "Please accept the Terms and Conditions to continue.";
            }
        }
    }
?>

<!--Register HTML-->
<?php include './php/head.php';?>    
    <body>
        <?php include './php/nav.php';?> 
            <main>
                <section id="register">
                <!--Register Form-->
                <div class="container-sm" style="max-width: 700px;">  
                    <div class="form-box" id="register-form">
                        <form class="row g-2" method="post" action="#register-form">
                            <h1>REGISTER</h1>
                            <div class="col-md-12">
                                <label for="fName" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="fName" name="fName" 
                                value="<?php echo $fname;?>">
                                <h6 class="error"><?php echo $fnameErr;?></h6>
                            </div>
                            <div class="col-md-12">
                                <label for="lName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lName" name="lName" 
                                value="<?php echo $lname;?>">
                                <h6 class="error"><?php echo $lnameErr;?></h6>
                            </div>
                            <div class="col-md-12">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                value="<?php echo $email;?>">
                                <h6 class="error"><?php echo $emailErr;?></h6>
                            </div>
                            <div class="col-md-12">
                                <label for="password" class="form-label">Password</label>
                                <div class="position-relative">
                                    <input type="password" class="form-control password-input" id="password" name="password"
                                    value="<?php echo $rawPass;?>"> 
                                    <!--Show/Hide Password-->
                                    <div class="svg-form toggle-password">
                                        <svg class="show-pass pointer active" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                        <svg class="hide-pass pointer" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                        </svg>
                                    </div>
                                </div>
                                <div id="suggestPasswordCheck" >
                                    <label class="form-check-suggest" for="suggestedPassword">
                                    <input class="form-check-input" type="checkbox" value="" id="suggestedPassword">
                                        <small> Generate Strong Password</small>
                                    </label>
                                </div>
                                <h6 class="error"><?php echo $passErr;?></h6>
                            </div>
                            <div class="col-md-12">
                                <label for="birthday" class="form-label">Birthday</label>
                                <input type="date" class="form-control" id="birthday" name="birthday" 
                                value="<?php echo $birthday;?>" >
                                <h6 class="error"><?php echo $birthdayErr;?></h6>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" name="checkTerms" id="checkTerms">
                                <label class="form-check-label" for="checkTerms">
                                    <small> I agree to the <a target="_blank" href="legalInformation.php#terms-condition">Terms and Conditions</a> 
                                    and <a target="_blank" href="legalInformation.php#privacy-policy">Privacy Policy</a>.</small>
                                </label>
                                <h6 class="error"><?php echo $termsErr;?></h6>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="1" name="checkNewsletter"  id="checkNewsletter">
                                <label class="form-check-label" for="checkNewsletter">
                                    <small>Get exclusive offers and updates</small>
                                </label>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary" name="register">Register</button>
                            </div>
                            <small>Already have an account? <a href="login.php">Login</a></small>
                        </form>
                    </div>
                </div>
            </section>
            </main>
        <?php include './php/footer.php';?>
        <?php include './php/script.php';?>
        <script>
            document.addEventListener("DOMContentLoaded", (event) => {
                // Suggest Password 
                const password = document.getElementById("password");
                const suggestedPassword = document.getElementById("suggestedPassword");
                suggestedPassword.addEventListener('change', function(){
                    if(suggestedPassword.checked){
                        generateStrongPassword();
                    }
                    else{
                        password.value = "";
                    }
                });

            });
        </script>
    </body>
</html>




