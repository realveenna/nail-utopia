<?php
    session_start();
    require_once '../connect.php';
    require_once './php/test_input.php';

    $date = new DateTime();

    // Define variables and set to empty values
    $emailErr =  $newPasswordErr = $confirmNewPassErr = $birthdayErr = "";
    $email =  $newPassword = $confirmNewPass = $birthday = "";

    if(isset($_SESSION['reset_email'])){
        $validCredentials = true;
    }else{
        $validCredentials = false;
    }
  
    // Reset Password PHP Validation
    if(isset($_POST['reset'])) {
        // Validate Email
        $birthday = $_POST['birthday'] ?? '';
        
        if (empty($_POST["email"])) {
            $emailErr = "Email is required";
        } else {
            $email = test_input($_POST["email"]);
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid email format";
            }else{
                // Check if email is registered
                $statement=$DB->prepare("SELECT * FROM userLogin WHERE email = :email");
                $statement->bindValue( ':email', $email, PDO::PARAM_STR);
                $statement->execute(); //sends the query to the sql database
                $resetEmail = $statement->fetch(PDO::FETCH_ASSOC);

                // If successful then the database should generate 1 row that matches our login details
                $count = $statement->rowCount();

                // If email is already registered display error 
                if($count!==1) {
                    $emailErr = 'Email not found';
                }
            }
        }
        if(empty($birthday)){
            $birthdayErr = "Please enter your birthday";
        }
        else if($resetEmail['birthday'] !== $birthday){
            $birthdayErr = "Birthday does not match with our record";
        }

        // If there are no error message (inputs are all valid)
        if(empty($emailErr) && empty($birthdayErr)){
            $validCredentials = true;
            $_SESSION['reset_email'] = $email;
        }
       
    }

    if(isset($_POST['confirm'])){
        $email = $_SESSION['reset_email'] ?? '';
        $newPassword = $_POST['newPassword'] ?? '';
        $confirmNewPass = $_POST['confirmNewPass'] ?? '';

        if(empty($email)){
            $validCredentials = false;
            $_SESSION['errors'] = 'Please enter your email address';
            header('Location: resetPassword.php'); 
            exit();
        }
        if(empty($newPassword)){
            $newPasswordErr = "Please enter new password";
        }
        else if(empty($confirmNewPass)){
            $confirmNewPassErr = "Please confirm new password";
        }
        else {
            if (strlen($newPassword) <= 8) {
                $newPasswordErr = "Your Password Must Contain At Least 8 Characters!";
            }
            elseif(!preg_match("#[0-9]+#",$newPassword)) {
                $newPasswordErr = "Your Password Must Contain At Least 1 Number!";
            }
            elseif(!preg_match("#[A-Z]+#",$newPassword)) {
                $newPasswordErr = "Your Password Must Contain At Least 1 Capital Letter!";
            }
            elseif(!preg_match("#[a-z]+#",$newPassword)) {
                $newPasswordErr = "Your Password Must Contain At Least 1 Lowercase Letter!";
            }
            // Hash password if valid
            else if($confirmNewPass === $newPassword){
                $salt ="4g£yc7!L(";
                $pass = md5($newPassword.$salt);
            }
            else{
                $confirmNewPassErr = "Password does not match";
            }
        }
        if(empty($newPasswordErr) && empty($confirmNewPassErr) && $validCredentials === true){
            // update password in db

             $statement = $DB->prepare("UPDATE userLogin SET pass = :pass WHERE email = :email");
        
            $statement->bindParam(':pass', $pass, PDO::PARAM_STR);
            $statement->bindParam(':email', $email, PDO::PARAM_STR);
            $statement->execute();

            $_SESSION['success'] = 'Password successfully changed! Please login to continue.';
            header('Location: login.php'); 
            exit();
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
                    <div class="form-box">
                        <?php if($validCredentials === true): ?>
                            <form class="row g-2" method="post">
                            <h1>Enter New Password</h1>
                            <div class="col-md-12">
                                <label for="newPassword" class="form-label">New Password</label>
                                <div class="position-relative">
                                    <input type="password" class="form-control password-input" id="newPassword" name="newPassword"
                                    value="<?php echo $newPassword;?>"> 
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
                                    <label class="form-check-suggest" for="suggestedNewPassword">
                                    <input class="form-check-input" type="checkbox" value="" id="suggestedNewPassword">
                                        <small> Generate Strong Password</small>
                                    </label>
                                </div>
                                <h6 class="error"><?php echo $newPasswordErr ;?></h6>
                            </div>
                            <div class="col-md-12">
                                <label for="confirmNewPass" class="form-label">Confirm New Password</label>
                                <div class="position-relative">
                                    <input type="password" class="form-control password-input" id="confirmNewPass" name="confirmNewPass"
                                    value="<?php echo $confirmNewPass ;?>"> 
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
                                <h6 class="error"><?php echo $confirmNewPassErr ;?></h6>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary" name="confirm">Confirm New Password</button>
                            </div>
                        </form>
                        <?php else: ?>
                            <form class="row g-2" method="post">
                                <h1>Reset Your Password</h1>
                                <div class="col-md-12">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" 
                                    value="<?php echo $email;?>">
                                    <h6 class="error"><?php echo $emailErr;?></h6>
                                </div>
                                <div class="col-md-12">
                                    <label for="birthday" class="form-label">Birthday</label>
                                    <input type="date" class="form-control" id="birthday" name="birthday" 
                                    value="<?php echo $birthday;?>" >
                                    <h6 class="error"><?php echo $birthdayErr;?></h6>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-primary" name="reset">Reset</button>
                                </div>
                            </form>
                        <?php endif;?>
                    </div>
                </div>
            </section>
            </main>
        <?php include './php/footer.php';?>
        <?php include './php/script.php';?>
        <script>
            // Suggest Password 
            const password = document.getElementById("newPassword");
            const suggestedPassword = document.getElementById("suggestedNewPassword");

            if(password && suggestedPassword){
                suggestedPassword.addEventListener('change', function(){
                    if(suggestedPassword.checked){
                        generateStrongPassword();
                    }
                    else{
                        password.value = "";
                    }
                });
            }
        </script>
    </body>
</html>
