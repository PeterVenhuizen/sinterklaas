<?php
    // include_once('../config/includes.php');
    include_once '../config/includeFromBottom.php';

    $stmt = $db->run("SELECT 
            (SELECT username FROM users WHERE users.id = sint_surprise_to_user.userID) AS username,
            (SELECT username FROM users WHERE users.id = sint_surprise_to_user.getrokkenID) AS lootje
        FROM sint_surprise_to_user
        INNER JOIN (
            SELECT ID FROM sint_surprise
            WHERE isActief AND isGesloten
        ) sint_surprise ON sint_surprise.ID = sint_surprise_to_user.surpriseID");

    if ($stmt->rowCount() > 0) {
        $records = array_map(function($row) { return $row; }, $stmt->fetchAll());
        echo json_encode(array(
            "success" => true,
            "records" => $records
        ));
        exit;
    }

    echo json_encode(array("success" => false));
    exit;
?>