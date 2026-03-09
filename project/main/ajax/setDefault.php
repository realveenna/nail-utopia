<?php
    session_start();
    require_once '../../connect.php';
    
    $setId = ($_POST['set_id']);
    $userId = $_SESSION['userId'] ?? null; 

    // Make each preference default to 0
    $deleteDefault = $DB->prepare("UPDATE user_custom_set SET is_default = 0 
        WHERE id = :userId"); 

    $deleteDefault ->bindValue(':userId', $userId, PDO::PARAM_INT);
    $deleteDefault ->execute();

    // Set default 1 in setId row
    $makeDefault = $DB->prepare("UPDATE user_custom_set SET is_default = 1 
        WHERE set_id = :setId AND id = :userId"); 

    $makeDefault ->bindValue(':setId', $setId, PDO::PARAM_INT);
    $makeDefault ->bindValue(':userId', $userId, PDO::PARAM_INT);
    $makeDefault ->execute();
?>