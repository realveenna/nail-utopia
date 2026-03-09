<?php
    session_start();
    require_once '../../connect.php';
    
    $setId = ($_POST['set_id']);
    $userId = $_SESSION['userId'] ?? null; 

    // Make preference default to 0
    $statement = $DB->prepare("DELETE FROM user_custom_set WHERE set_id = :setId AND id = :userId "); 
    $statement ->bindValue(':setId', $setId, PDO::PARAM_INT);
    $statement ->bindValue(':userId', $userId, PDO::PARAM_INT);
    $statement ->execute();
    
    // Set default 1 in setId row
    $makeDefault = $DB->prepare("UPDATE user_custom_set SET is_default = 1 
        WHERE id = :userId ORDER BY RAND() LIMIT 1"); 

    $makeDefault ->bindValue(':userId', $userId, PDO::PARAM_INT);
    $makeDefault ->execute();

?>