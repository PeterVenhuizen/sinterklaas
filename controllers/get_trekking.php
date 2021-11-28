<?php
    include_once '../config/includeFromBottom.php';

    $stmt = $db->run("SELECT 
            (SELECT username FROM users WHERE users.id = surprise_to_user.userID) AS username,
            (SELECT username FROM users WHERE users.id = surprise_to_user.getrokkenID) AS lootje
        FROM surprise_to_user
        INNER JOIN (
            SELECT ID FROM surprise
            WHERE isActief AND isGesloten
        ) surprise ON surprise.ID = surprise_to_user.surpriseID");

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