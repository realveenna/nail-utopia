<?php 
    session_start();
    include '../connect.php';

    $sendFname = $sendLName =  $sendEmail = $sendMessageText = "";
    $sendFnameErr = $sendLNameErr = $sendEmailErr = $sendMessageTextErr = "";

    // Select all open hours
    $statement = $DB->prepare("SELECT * FROM open_hours"); 
    $statement ->execute();
    $days = $statement->fetchAll(PDO::FETCH_ASSOC);

    if(isset($_POST['btnSendMessage'])){
        $sendFname = trim($_POST["sendFname"]);
        $sendLName = trim($_POST["sendLName"]);
        $sendEmail = trim($_POST["sendEmail"]);
        $sendMessageText = trim($_POST["sendMessageText"]);

        if (empty($sendFname)) {
            $sendFnameErr = "Enter your first name.";
        } 
        if (empty($sendLName)) {
            $sendLNameErr = "Enter your last name.";
        } 
        if (empty($sendMessageText)) {
            $sendMessageTextErr = "Please enter your message.";
        } 
        if (empty($sendEmail)) {
            $sendEmailErr = "Enter an email.";
        } 
        elseif (!filter_var($sendEmail, FILTER_VALIDATE_EMAIL)) {
            $sendEmailErr= "Invalid email format.";
        }

        if(empty($sendFnameErr) && empty($sendLNameErr) && empty($sendEmailErr) && empty($sendMessageTextErr)){

            unset($sendFnameErr,$sendLNameErr,$sendEmailErr,$sendMessageTextErr);
            unset($sendFname,$sendLName,$sendEmail,$sendMessageText);

            $_SESSION['success'] = "Message sent successfully!";                
            header('Location: contact.php'); 
            exit;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<?php include './php/head.php';?>    
<body>
    <?php include './php/nav.php';?>   
   <main>
        <!-- Banner -->
        <section class="banner-text py-5">
            <div class="text-center container-lg gy-3">
                <div class="text-color primary xs-line-height">
                    <h1> CONTACT US</h1>
                    <h5> We'd love to hear from you. Get in touch for bookings, questions, or enquiries.</h5>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section>
            <div class="container-lg py-3 py-md-5 d-flex justify-content-center">
                <div class="row align-items-stretch g-3 g-md-4">
                    <!-- Get In Touch -->
                    <div class="col-12 col-md-4">
                        <div class="form-box p-4 h-100 text-center d-flex justify-content-evenly flex-column">
                            <div class="container no-underline">
                                <h2>Get In Touch!</h2>
                                <h6>We're here to help with appointments, services, or any enquiries.</h6>

                                <div class="svg-contact d-flex flex-column align-items-center py-3 g-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                    </svg>
                                    <a href="https://maps.app.goo.gl/LRJzADMkT4aAdxe6A">
                                        123 Street, Town, <br>
                                        City, Country <br>
                                        Zip Code
                                    </a>
                                </div>
                                <div class="svg-contact d-flex flex-column align-items-center py-3 g-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                    </svg>
                                    <a href="tel:+0141 272 9000">
                                        +0141 272 9000
                                    </a>
                                </div>  
                                <div class="svg-contact d-flex flex-column align-items-center py-3 g-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                    </svg>
                                    <a href="mailto:info@glasgowclyde.ac.uk">
                                        support@nailutopia.com
                                    </a>
                                </div>
                                <div class="svg-contact d-flex flex-column align-items-center py-3 g-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                    <div class="row">
                                    <?php 
                                        $groupDays =[];
                                        
                                        foreach ($days as $d) {
                                            $dayRaw   = $d['day_of_week'];
                                            $day = ucfirst(substr($dayRaw, 0, 3)); 
                                            $open  = $d['open_time'];
                                            $close = $d['close_time'];
                                            
                                            // check if closed
                                            if ($d['is_closed'] === 0) {
                                                $hours = 'Closed';
                                            } else {
                                                $hours = $open . '-' . $close;
                                            }

                                            $groupDays[$hours][] = $day;
                                        }

                                        // Compare for common store hours
                                        foreach ($groupDays as $hours => $dayList) {
                                            $first = reset($dayList);
                                            $last = end($dayList);

                                            // If only one day
                                            if($first === $last){
                                                $dayRange = $first;
                                            }
                                            // Else combine common days
                                            else{
                                                $dayRange = $first .' - '. $last;
                                            }

                                            // Display openinig hours
                                            if($hours === 'Closed'){
                                                echo 
                                                    '
                                                    <div class="col-12 d-flex gap-2 justify-content-center">
                                                        <p class="text-end" style="width:120px;">'.$dayRange.'</p>
                                                        <p>:</p>
                                                        <p class="text-start" style="width:120px;">Close</p>
                                                    </div>
                                                    ';
                                            }
                                            else{
                                                list($open,$close) = explode('-', $hours);
                                                echo 
                                                '
                                                    <div class="col-12 d-flex gap-2 justify-content-center">
                                                        <p class="text-end" style="width:120px;">'.$dayRange.'</p>
                                                        <p>:</p>
                                                        <p class="text-start" style="width:120px;">
                                                            '.date('H:i', strtotime($open)) .
                                                            ' - ' .
                                                            date('H:i', strtotime($close)) .'
                                                        </p>
                                                    </div>
                                                ';
                                            }
                                        }
                                    ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Form -->
                    <div class="col-12 col-md d-flex">
                         <div class="form-box no-border px-1 px-md-3 h-100">
                            <form class="row g-3 h-100" method="post">
                            <div class="text-center">
                                <h2>Send a Message</h2>
                                <h6>Your perfect nails start here.</h6>
                            </div>   
                            <h6 class="success"> </h6>
                            <div class="col-12 col-md-6">
                                <label for="sendFname" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="sendFname" name="sendFname" placeholder="First Name"
                                value="<?php echo $sendFname;?>">
                                <h6 class="error"><?php echo $sendFnameErr;?></h6>
                            </div>
                            <div class="col-12 col-md-6">
                                <label for="sendLName" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="sendLName" name="sendLName"  placeholder="Last Name"
                                value="<?php echo $sendLName;?>">
                                <h6 class="error"><?php echo $sendLNameErr;?></h6>
                            </div>
                            <div class="col-12">
                                <label for="sendEmail" class="form-label">Email</label>
                                <input type="sendEmail" class="form-control" id="sendEmail" name="sendEmail" placeholder="youremail@gmail.com"
                                value="<?php echo $sendEmail;?>">
                                <h6 class="error"><?php echo $sendEmailErr;?></h6>
                            </div>
                            <!-- Message Text -->
                            <div class="col-12">
                                <label for="sendMessageText" class="form-label">Message:</label>
                                <textarea class="form-control" name="sendMessageText" id="sendMessageText" rows="3" 
                                    placeholder="Type a Message..."><?= trim($sendMessageText) ?></textarea>
                                    <h6 class="error"><?php echo $sendMessageTextErr;?></h6>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary" name="btnSendMessage">Send</button>
                            </div>
                            </form>
                         </div>
                    </div>
                </div>
                
            </div>
        </section>    
        
   </main>
    
    <?php include './php/footer.php';?>
    <?php include './php/script.php';?>
</body>
</html>

