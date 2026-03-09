<?php
    // Backend: PHP + MySQL code
    session_start();
    require_once '../../connect.php';

    header('Content-Type: application/json');

    $action = $_POST['action'] ?? '';
    $mailType = $_POST['mailType'] ?? 'general';
    $acceptedGeneralRecipient = ['All', 'Newsletter'];
    $recipients = $_POST['recipients'] ?? [];

    $response = ["success" => false];

    switch($action){
        case 'selectType' :
             $response = [
                "success" => true,
                "mailType" => $mailType,
            ];

            switch($mailType){
                case 'others' :
                    break;
                    
                case 'newsletter' : 
                     //Prepares an SQL statement to be executed by the execute() method
                    $statement = $DB->prepare("SELECT COALESCE(u.email, n.email) AS email
                        FROM newsletter n
                        JOIN userlogin u ON n.id = u.id
                        WHERE n.newsletter_status = :subscribed");
                    $statement->bindValue( 'subscribed', 'subscribed', PDO::PARAM_STR);
                    $statement->execute();

                    //Returns an array containing all of the remaining rows in the result set
                    $subscribers = $statement->fetchAll(PDO::FETCH_COLUMN);
                    $response["recipients"] = $subscribers;
                    break;

                case 'general':
                    //Prepares an SQL statement to be executed by the execute() method
                    $statement = $DB->prepare("SELECT email FROM userlogin 
                       WHERE user_type NOT IN (?, ?)");
                    $statement->bindValue(1, 'admin', PDO::PARAM_STR);
                    $statement->bindValue(2, 'staff', PDO::PARAM_STR);
                    $statement->execute();

                    //Returns an array containing all of the remaining rows in the result set
                    $allUsers = $statement->fetchAll(PDO::FETCH_ASSOC);
                    $response["recipients"] = $allUsers;
                    break;
            }
            break;
            
        case 'selectRecipient' :
            $emails = []; 
            
            if(!is_array($recipients)){
                $recipients = explode(',', $recipients);
            }
            if(count($recipients) > 0){
                $placeholders = implode(',', array_fill(0, count($recipients), '?'));

                //Prepares an SQL statement to be executed by the execute() method
                $statement = $DB->prepare("SELECT email FROM userlogin WHERE id IN ($placeholders)");
                $statement->execute($recipients);

                //Returns an array containing all of the remaining rows in the result set
                $emails = $statement->fetchAll(PDO::FETCH_COLUMN);
            }
            else{
                $response = [
                "success" => false,
                "message" => "Failed to fetch email"
                ];
                echo json_encode($response);
                exit;
            }

            $response = [
                "success" => true,
                "message" => "Type", 
                "mailType" => $mailType,
                "recipients" => $emails
            ];
            break;
    }
    echo json_encode($response);
    exit;
?>