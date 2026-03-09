
<?php 
    session_start();
    require_once '../connect.php';  
    require_once './php/test_input.php';
        
    // Define error message variables and set to empty values
    $emailLoginErr = $passLoginErr = "";
    $loginEmail = $rawLoginPass = "";

    // Login PHP Validation
    if(isset($_POST['login'])) {
        // Validate Email
        if (empty($_POST["loginPassword"])) {
            $passLoginErr = "Password is required";
        }
        if (empty($_POST["loginEmail"])) {
            $emailLoginErr = "Email is required";
        } else {
            $loginEmail = test_input($_POST["loginEmail"]);
            // If invalid email format
            if (!filter_var($loginEmail, FILTER_VALIDATE_EMAIL)) {
                $emailLoginErr = "Invalid email format";
            }
            // Valid email format
            else{
                $statement=$DB->prepare("SELECT * FROM userLogin WHERE email = ?");
                $statement->bindValue(1, $loginEmail, PDO::PARAM_STR);
                $statement->execute(); //sends the query to the sql database

                //if successful then the database should generate 1 row that matches our login details
                $count = $statement->rowCount();

                // If email is found
                if($count==1) {
                    // Check password
                    
                    $user = $statement->fetch(PDO::FETCH_ASSOC);
                    $rawLoginPass = test_input($_POST["loginPassword"]);
                    
                    $salt ="4g£yc7!L(";
                    $loginPassword = md5($rawLoginPass.$salt);
                    
                    // If password is correct, sign in
                    if($user['pass'] === $loginPassword){
                        $_SESSION["userType"] = $user['user_type'] ?? 'customer';
                        $_SESSION["loggedIn"] = true; 
                        $_SESSION["userId"] = $user['id']; 

                        $userId = $_SESSION["userId"];
                        $statement = $DB->prepare("SELECT * FROM userlogin WHERE id = :userId");
                        $statement->bindValue(':userId', $userId, PDO::PARAM_INT);
                        $statement->execute();

                        $isRegistered = $statement->fetch(PDO::FETCH_ASSOC);
                        
                        if($isRegistered) {
                            $user = $statement->fetch();
                            $_SESSION['user'] = $user;

                            if($_SESSION["userType"]  === "admin" || $_SESSION["userType"]  === "staff" ) {
                                header('Location: ../admin/'); 
                                exit;
                            } else{
                                $_SESSION['success'] = "Welcome back, " . $isRegistered['fname'] . "!";
                                header('Location: index.php'); 
                                exit;
                            }
                        }
                    }
                    // Password is incorrect
                    else{
                        $passLoginErr = 'Incorrect password.';
                    }
                }
                // Email is not found
                else{
                    $emailLoginErr = 'Email is not registered. Click <a href="register.php">here</a> to register.';
                }
            }
        }
    }
?>

<!--Login HTML-->
<?php include './php/head.php';?>    
    <body>
        <?php include './php/nav.php';?> 
            <!--Login Form-->
            <main>
                <div class="container-sm" style="max-width: 700px;">  
                    <div class="form-box" id="login-form">
                        <form class="row g-2" method="post">
                        <div class="text-center">
                            <h1>Login</h1>
                            <h3>Please enter details below.</h3>
                        </div>
                            <div class="col-12">
                                <label for="loginEmail" class="form-label">Email</label>
                                <input type="email" class="form-control" id="loginEmail" name="loginEmail"
                                    value="<?php echo $loginEmail;?>">
                                <h6 class="error"><?php echo $emailLoginErr;?></h6>
                            </div>
                            <div class="col-12">
                                <label for="loginPassword" class="form-label">Password</label>
                                <div class="position-relative">
                                    <input type="password" class="form-control password-input" id="loginPassword" name="loginPassword"
                                    value="<?php echo $rawLoginPass;?>">
                                    <!-- Show/Hide Password -->
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
                                <h6 class="error"><?php echo $passLoginErr;?></h6>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary" name="login">Login</button>
                            </div>
                            <small>Don't have an account? <a href="register.php">Register</a></small>
                        </form>
                    </div>
                </div>
            </main>
        <?php include './php/footer.php';?>
        <?php include './php/script.php';?>
    </body>
</html> 