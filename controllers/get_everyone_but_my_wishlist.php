<?php
    // include_once('../config/includes.php');
    include_once '../config/includeFromBottom.php';

    $stmt = $db->run("SELECT sint_lijstje.*, 
        (SELECT username FROM users WHERE users.id = sint_lijstje.userID) AS username 
        FROM sint_lijstje
        INNER JOIN (
            SELECT ID FROM sint_surprise
            WHERE isActief
        ) sint_surprise ON sint_surprise.ID = sint_lijstje.surpriseID
        WHERE sint_lijstje.userID != ?
        ORDER BY sint_lijstje.userID DESC", 
        [$_SESSION['user_id']]);

    if ($stmt->rowCount() > 0) {
        $records = array_map(function($row) { return $row; }, $stmt->fetchAll());
        echo json_encode(array(
            "success" => $stmt == true,
            "wishes" => $records
        ));
        exit;
    }

    echo json_encode(array("success" => false));
    exit;
?>