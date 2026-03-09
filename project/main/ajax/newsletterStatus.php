<?php
    session_start();
    require_once '../../connect.php';

    header('Content-Type: application/json');

    $userId = $_SESSION['userId'] ?? null; 

    $value = (int)$_POST['newsletter_status'];

    $statusValue = ($value === 1) ? 'subscribed' : 'unsubscribed';

    $statement = $DB->prepare("INSERT INTO newsletter (id, newsletter_status)
    VALUES (:userId, :statusValue)
    ON DUPLICATE KEY UPDATE newsletter_status = :statusValue ");

    $statement->bindValue(':userId', (int)$userId, PDO::PARAM_INT);
    $statement->bindValue(':statusValue', $statusValue, PDO::PARAM_STR);
    $statement->execute();
?>