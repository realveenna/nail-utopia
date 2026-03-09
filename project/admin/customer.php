<?php
    session_start();
    require_once '../connect.php';

    //Prepares an SQL statement to be executed by the execute() method
    $statement = $DB->prepare("SELECT * FROM userlogin WHERE user_type NOT IN (?, ?)");
    $statement->bindValue(1, 'admin', PDO::PARAM_STR);
    $statement->bindValue(2, 'staff', PDO::PARAM_STR);
    $statement->execute();
            
    $customer = $statement->fetchAll(PDO::FETCH_ASSOC);

    $address_id = $userAddress['address_id'] ?? "";
    $line1 = $userAddress['line_1'] ?? ""; 
    $line2 = $userAddress['line_2'] ?? null; 
    $city = $userAddress['city'] ?? "";
    $postcode = $userAddress['postcode'] ?? "";
    $country = $userAddress['country'] ?? "";

    // Mail Variables
    $subject = 
    $greetings = 
    $messageMail =
    $closing = 
    $voucherMail = "";

    $subjectErr = 
    $greetingsErr = 
    $messageMailErr =
    $closingErr = 
    $voucherMailErr =
    $mailTypeErr =
    $selectRecipientErr ="";

    $mailType = $_POST['mailType'] ?? '';
    $generalRecipient = $_POST['selectedRecipient'] ?? '';


    // Send Mail
    if(isset($_POST['btnSendMail'])){
        $mailType = $_POST['mailType'] ?? '';
        $generalRecipient = $_POST['selectedRecipient'] ?? '';
        $subject = $_POST['subject'];
        $greetings = $_POST['greetings'];
        $messageMail =  $_POST['messageMail'];
        $closing =  $_POST['closing']; 
        $listActualRecipient = $_POST['listActualRecipient'] ?? []; // inside input hidden

        if(empty($mailType)){
            $mailTypeErr = "Please select type of mail";
        }   
        if($mailType === 'others'){
             $generalRecipient = trim($_POST['generalRecipient'] ?? '');
            if(!empty($generalRecipient) && filter_var($generalRecipient, FILTER_VALIDATE_EMAIL)){
                $emails = [$generalRecipient];
            } else {
                $selectRecipientErr = "Invalid email address";
            }
        }
        else{
            if(!empty($listActualRecipient)){
                $emails = explode(",", $listActualRecipient);

                foreach($emails as $email){
                    $email = trim($email);
                    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                        $selectRecipientErr = "Invalid email format";
                        break;
                    }
                }
            }
            else{
                $emails = [];
                $selectRecipientErr = "Please select recipient";
            }
        }
        if($mailType === 'newsletter'){
            $voucherMail = $_POST['voucherMail'] ?? '';
            if(empty($voucherMail)){
                $voucherMailErr = "Please enter voucher code!";
            }
        }
        else{
            unset($voucherMail);
            $voucherMailErr = "";
        }
        
       
        if(empty($subject)){
            $subjectErr = "Please enter subject";
        }
        if(empty($greetings)){
            $greetingsErr = "Please enter greetings";
        }
        if(empty($messageMail)){
            $messageMailErr = "Please enter text body content for this mail";
        }
        if(empty($closing)){
            $closingErr = "Please enter closing statement";
        }

        // No errors
        if(empty( $subjectErr) && empty($greetingsErr) && empty($messageMailErr) && empty($closingErr)
             && empty($voucherMailErr) && empty($mailTypeErr) && empty($selectRecipientErr) && empty($voucherMailErr)){
            include 'sendMail.php';
            header('Location: customer.php');
            exit();
        }
        else{
            $_SESSION['errors'] = 'Failed to send email!';
        }
    }


    // Remove customer
    if(isset($_POST['removeCustomer'])){
        $id = $_POST['modifyCustomerId'];
        $remove = $DB->prepare("DELETE FROM userlogin WHERE id = :id");
        $remove->bindValue(':id', $id, PDO::PARAM_INT);
        $remove->execute();

        $_SESSION['success'] = "Customer Successfully Removed from Database!";
        header('Location: customer.php');
        exit();
    }

    // Tab
    $tab = $_GET['tab'] ?? 'all';   
    switch($tab){
        case 'send':
            $pageTitle = "Send Mail";
            break;

        default:
            $pageTitle = "View All Customer";
            break;
    }
?>

<!DOCTYPE html>
<html lang="en">
<?php include '../main/php/head.php';?>   
    <body>

        <?php if(isset($_GET['customerId'])): ?>
            <?php 
                $customerId = (int)$_GET['customerId']; 

                $statement = $DB->prepare("SELECT * FROM userlogin WHERE id = :customerId LIMIT 1");
                $statement->bindValue(':customerId', $customerId, PDO::PARAM_INT);
                $statement->execute();
                $customerManage = $statement->fetch();

                if ($customerId <= 0){ 
                    $_SESSION['errors'] .= "Customer Id is not found";
                    header('Location: ' .$_SERVER['PHP_SELF']); 
                    exit();
                }
                // GET ADDRESS
                $statement = $DB->prepare("SELECT * FROM addresses WHERE  id = :customerId ORDER BY address_id DESC LIMIT 1");
                $statement->bindValue(':customerId', $customerId,PDO::PARAM_INT);
                $statement->execute();
                $userAddress = $statement->fetch(PDO::FETCH_ASSOC);

                // If user has existing address in database set value
                if($userAddress){
                    $address_id = $userAddress['address_id'];
                    $line1 = $userAddress['line_1']; 
                    $line2 = $userAddress['line_2'] ?? null; 
                    $city = $userAddress['city'];
                    $postcode = $userAddress['postcode'];
                    $country = $userAddress['country'];
                }
                
            ?>
             <script>
                document.addEventListener("DOMContentLoaded", function(){
                    var modal = new bootstrap.Modal(document.getElementById('manageCustomerModal'));
                    modal.show();
                });
            </script>
        <?php endif; ?>

        <!-- Customer Modal -->
        <div class="modal fade" id="manageCustomerModal" data-bs-backdrop="static" tabindex="-1" aria-labelledby="manageCustomerModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h2 class="modal-title fs-1" id="manageCustomerModalLabel">Manage Customer</h2>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Modal Content -->
                    <div class="modal-body">
                        <table class="table">
                            <?php if($customerManage): ?>
                                <tbody>
                                <tr>
                                    <td>Name: </td>
                                    <td class="capitalize"><?= $customerManage['fname']; echo ' '; echo $customerManage['lname'];?></td>
                                </tr>
                                <tr>
                                    <td>Email Address: </td>
                                    <td><?= $customerManage['email'];?></td>
                                </tr>
                                <tr>
                                    <td>Birthday: </td>
                                    <td><?= $customerManage['birthday'];?> </td>
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
                            <?php else: ?>
                                    <p class="text-danger"> No items found</p>
                            <?php endif; ?>
                            
                        </table>

                    </div>
                    <!-- Modal Footer Buttons -->
                    <div class="modal-footer">
                        <!-- Manager -->
                        <form method="post" class="row g-2 needs-validation" novalidate>
                            <input type="hidden" name="modifyCustomerId" value="<?= $customerId ?>">
                            <div class="d-flex gap-2">
                                <button type="submit" class="w-100 btn btn-primary" name="removeCustomer">Remove</button>
                                <button type="button" class="w-100 btn btn-light" data-bs-dismiss="modal">Back</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <?php include 'admin-nav.php';?>
        <main>
            <!-- Customer PHP -->
            <div class="container-lg">
               <div class="row g-3 g-md-4 ">
                    <div class="col-12">
                        <h2><?= $pageTitle?></h2>
                    </div>

                    <!-- Tab Toggle -->
                    <div class="col-12 d-flex">
                        <ul class="nav nav-tabs" id="customerTab">
                            <li class="nav-item">
                                <a class="nav-link <?= ($tab ==='all') ? 'active' : '' ?>" href="customer.php?tab=all">All Customer</a>
                            </li>

                             <li class="nav-item">
                                <a class="nav-link <?= ($tab ==='send') ? 'active' : '' ?>" href="customer.php?tab=send">Send Mail</a>
                            </li>
                        </ul>
                    </div>

                    <div class="col-12">
                        <div class="tab-content">
                            <!-- All Customer Lists -->
                            <div id="customerListCon" class="tab-pane fade  <?= $tab == 'all' ? 'show active' : '' ?>" >
                                <?php
                                    if($customer){
                                        echo' 
                                        <div class="table-responsive">
                                            <table class="table text-center table-hover">
                                                <thead>
                                                    <tr>
                                                        <th scope="col" class="text-main">ID</th>
                                                        <th scope="col" class="text-main">Full Name</th>
                                                        <th scope="col" class="text-main">Email</th>
                                                        <th scope="col" class="text-main">Birthday</th>
                                                        <th scope="col" class="text-main">Date Registered</th>
                                                        <th scope="col" class="text-main">Manage</th>

                                                    </tr>
                                                </thead>';
                                        foreach($customer as $rs){
                                            echo '<tbody>';
                                                echo '<tr>';
                                                    echo '<td scope="row"> '.$rs['id'].' </td>';
                                                    echo '<td> '.$rs['fname'].' '.$rs['lname'].' </td>';
                                                    echo '<td> <a href="mailto:'.$rs['email'].'"> '.$rs['email'].' </a> </td>';
                                                    echo '<td> '.$rs['birthday'].' </td>';
                                                    echo '<td> '.$rs['date_registered'].' </td>';
                                                    echo '<td>';
                                                    // Allow customer management
                                                    echo'
                                                         <form method="get">
                                                            <input type="hidden" name="customerId" value="'.(int)$rs['id'].'">
                                                            <button type="submit" class="no-bg">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                        ';
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

                            <!-- Send Mail -->
                            <div id="sendMail" class="tab-pane fade  <?= $tab == 'send' ? 'show active' : '' ?>" >
                                <div class="form-box">
                                    <div class="text-center">
                                        <h4>Write an Email to Customers</h4>
                                        <h5>Please enter details below.</h5>
                                    </div>
                                    <div>
                                        <!-- Form Input Group -->
                                        <form method="post" class="row g-2" id="submitMailForm" novalidate>
                                            <!-- Mail type -->
                                             <div class="col-12">
                                                <label for="subject" class="form-label">Mail Type:</label>
                                                <select class="form-select" name="mailType" id="mailType" aria-label="Select Mail Type">
                                                    <option value="" selected>Select an option below</option>
                                                    <option value="general" <?= $mailType === "general" ? 'selected' : ''?>>General</option>
                                                    <option value="newsletter" <?= $mailType === "newsletter" ? 'selected' : ''?>>Newsletter</option>
                                                    <option value="order" <?= $mailType === "order" ? 'selected' : ''?> >Order Update</option>
                                                    <option value="individual" <?= $mailType === "individual" ? 'selected' : ''?>>Selected Recipients</option>
                                                    <option value="others" <?= $mailType === "others" ? 'selected' : ''?>>Others</option>
                                                </select>
                                                <h6 class="error"><?php echo $mailTypeErr;?></h6>    
                                             </div>
                                            <!-- List of Selected Recipient -->
                                            <div class="col-12">
                                                <label for="List of selected recipient" class="form-label">Recipients:</label>
                                                <div id="recipientList" class="d-flex flex-wrap gap-2 mt-2">
                                                    <input type="text" name="generalRecipient" value="<?= $generalRecipient ?>" class="form-control" placeholder="List of Recipients" readonly>
                                                </div>
                                                <h6 class="error"><?php echo $selectRecipientErr;?></h6>    
                                            </div>

                                            <input type="hidden" name="listActualRecipient" value="<?= $listActualRecipient ?>">

                                           
                                            <div class="col-12 d-none" id="selectRecipientContainer">
                                                <label for="subject" class="form-label">Select Recipients:</label>
                                                <select class="form-select" id="selectRecipient" name="recipients[]" multiple aria-label="selecting recipient">
                                                    <?php foreach($customer as $c): ?>
                                                        <option value="<?= $c['id']?>"> <?= $c['email'] ?> </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                           
                                            <!-- Subject -->
                                            <div class="col-12" id="subjectMail">
                                                <label for="subject" class="form-label">Subject:</label>
                                                <input type="text" class="form-control" name="subject" placeholder="Enter Subject"
                                                    value="<?php echo $subject;?>" required>
                                                <h6 class="error"><?php echo $subjectErr;?></h6>    
                                            </div>
                                            
                                            
                                            <!-- Greeting -->
                                            <div class="col-12" id="greetingMail">
                                                <label for="greetings" class="form-label">Greetings:</label>
                                                <input type="text" class="form-control" name="greetings" placeholder="Hello Nail Fairies,"
                                                    value="<?php echo $greetings;?>" required>
                                                <h6 class="error"><?php echo $greetingsErr;?></h6>    
                                            </div>

                                            <!-- Subject -->
                                            <div class="col-12 d-none" id="voucherMail">
                                                <label for="voucherMail" class="form-label">Voucher Code:</label>
                                                <input type="text" class="form-control" name="voucherMail" placeholder="Enter Voucher Code"
                                                    value="<?php echo $voucherMail;?>">
                                                <h6 class="error"><?php echo $voucherMailErr;?></h6>    
                                            </div>

                                            <!-- Message Body -->
                                            <div class="col-12">
                                                <label for="messageMail" class="form-label">Message:</label>
                                                <textarea class="form-control" name="messageMail" id="messageMail" rows="8" 
                                                    placeholder="Enter Message"><?= trim($messageMail) ?></textarea>
                                                <h6 class="error"><?php echo $messageMailErr;?></h6>    
                                            </div>

                                            <!-- Closing -->
                                            <div class="col-12" id="closingMail">
                                                <label for="closing" class="form-label">Closing:</label>
                                                 <textarea class="form-control no-scroll" name="closing" id="closing" rows="2" 
                                                    placeholder="Best regards, &#10;Nail Utopia"><?= trim($closing) ?></textarea>
                                                <h6 class="error"><?php echo $closingErr;?></h6>
                                            </div>

                                            <div class="gap-2 d-flex flex-wrap">
                                                <button type="button" class="btn btn-secondary clear-btn flex-fill">Clear</button>
                                                <button type="submit" class="btn btn-primary flex-fill" name="btnSendMail"
                                                    value="btnSendMail" >Send Mail</button>
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
    </body>
    <?php include '../main/php/script.php';?>

    <script>
  
        // MAIL ACTION AJAX
        const selectType = document.getElementById('mailType');
        const voucherMail = document.getElementById('voucherMail');
        const selectContainer = document.getElementById("selectRecipientContainer");
        const generalRecipient = document.querySelector('input[name="generalRecipient"]');
        const listActualRecipient = document.querySelector('input[name="listActualRecipient"]');
        const recipientList = document.getElementById("recipientList");
        const recipients = document.getElementById("selectRecipient");
        let type = selectType.value;

        window.addEventListener("load", (event) => {
            if (type === 'others'){
                generalRecipient.value = "";
                generalRecipient.toggleAttribute("readonly");
            }
            if (type === 'general'){
                generalRecipient.value = "All";
            }
        });


        // Select Mail Type AJAX
        selectType.addEventListener('change', function () {
            type = this.value;

            // reset value on change mail type
            generalRecipient.value = "";
            generalRecipient.placeholder = "";
            listActualRecipient.value = "";

            // is general
            const isGeneral = type === "general";

            // Toggle voucher input if mail type is not newsletter
            const isNewsletter = type === "newsletter";
            voucherMail.classList.toggle("d-none", !isNewsletter);

            // Mail type is order
            const isOrder = type === "order";

            // Toggle select container if mail type is individual
            const isIndividual = type === "individual";
            selectContainer.classList.toggle("d-none", !(isIndividual || isOrder));

            // Toggle readony attribiute from recipient list if input mail type is others
            const isOthers = type === "others";
            generalRecipient.toggleAttribute("readonly", !isOthers);

            if (isNewsletter) {
                generalRecipient.value = "All Subscribers";
            } else if (isOthers) {
                generalRecipient.placeholder = "Enter email address";
                generalRecipient.value = "";
            } else if(isGeneral) {
                generalRecipient.value = "All";
            }else if(isIndividual || isOrder){
                generalRecipient.placeholder = "Selected email address";
                generalRecipient.value = "";
            }


            mailAction(
                "selectType",
                { mailType: type},
                (data) => {
                    console.log("Mail Type: ", data.mailType);
                    console.log("Recipients: ", data.recipients);
                    const emails = data.recipients.map(r => r.email || r);
                    // join all email in a list
                    listActualRecipient.value = emails.join(","); // actual recipient    
                }
            )
        });

        // Select Recipient
        
        
        recipients.addEventListener("change", function(){
            // Get all selected values
            var selectedValues = Array.from(recipients.options) // Convert options to an array
                .filter(option => option.selected)      // Filter selected options
                .map(option => option.value);           // Map to an array of values

            mailAction(
                "selectRecipient",
                { recipients: selectedValues},
                (data) => {
                    console.log("Recipients: ", data.recipients);
                    // join all email in a list
                    const emails = data.recipients.map(r => r.email);
                    generalRecipient.value = emails.join(", "); // for ui
                    listActualRecipient.value = emails.join(","); 
                }
            )
        });


        // Allow multiple select without holding ctrl
        const multiSelectWithoutCtrl = ( elemSelector ) => {
        let options = [].slice.call(document.querySelectorAll(`${elemSelector} option`));
        options.forEach(function (element) {
            element.addEventListener("mousedown", 
                function (e) {
                    e.preventDefault();
                    element.parentElement.focus();
                    this.selected = !this.selected;

                    // trigger change manually
                        element.parentElement.dispatchEvent(new Event('change'));
                    return false;
                }, false );
            });
        }
        multiSelectWithoutCtrl('#selectRecipient');

        generalRecipient.addEventListener("input", function(){
            listActualRecipient.value = this.value.trim();
        })


        document.getElementById("submitMailForm").addEventListener("submit", function (e) {
            const generalRecipient = document.querySelector('input[name="generalRecipient"]');
            const actualRecipient = document.querySelector('input[name="listActualRecipient"]');
            if((type !== 'general' && type !== 'newsletter') && 
                (generalRecipient.value === 'All' ||  generalRecipient.value === 'All Subscribers')){
                alert("Something went wrong");
                e.preventDefault();
            }
        });
        

    </script>
</body>
</html>
