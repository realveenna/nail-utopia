<?php
require '../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$voucherSection = '';
$success = '';
$fail = '';

if (!empty($voucherMail)) {
    $voucherSection = '
        <br>
        <div style="margin:1rem;padding:15px;border:1px dashed #ccc;text-align:center;">
            <strong>Your Voucher Code:</strong><br>
            <span style="font-size:20px;font-weight:bold;">' . htmlspecialchars($voucherMail) . '</span>
        </div>
        <br>
    ';
}

  foreach($emails as $email){
    $mail = new PHPMailer(true);

    try{
      $mail->isSMTP();
      $mail->Host       = 'sandbox.smtp.mailtrap.io';
      $mail->SMTPAuth   = true;
      $mail->Username   = '0eef88f25d8058';
      $mail->Password   = '5466ea82ba1314';
      $mail->Port       = 2525;
      $mail->setFrom('test@nailutopia.com', 'Nail Utopia');
      $mail->addAddress($email);
      $mail->addEmbeddedImage('../uploads/logo/logo.png', 'logo');
      $mail->Subject = $subject ?? 'Subject';
      $mail->isHTML(true);
      $mail->Body    = 
      '
        <html>
          <body>
            <img src="cid:logo" alt="Nail Utopia Logo" width="150" style="display:block;margin:auto;"> </img>
            <hr>
            <br>
            <strong> '.htmlspecialchars($greetings) .' </strong>
            <br>
            <p> '.htmlspecialchars($messageMail) .'  </p>
            <br>

            ' . $voucherSection . '

            <p> '.htmlspecialchars($closing) .'  </p>
            <br>
            <hr>
            <span> Unsubscribe </span>
          </body>
        </html>
      ';

      $mail->send();
      $success .= "Successfully sent to " .$email ."<br>";
      sleep(2);
    }
    catch(Exception $e){
      $fail .= "Error: " . $mail->ErrorInfo;
      sleep(2);
    }
  }
  if(!empty($success)){
    $_SESSION['success'] = $success. "<br>Message only sent to 1-2 emails only for testing purposes.";
  }
  if(!empty($fail)){
      $_SESSION['errors'] = $fail . "<br>Error: You have used your email limit.";
  }
?>