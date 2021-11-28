<?php
    include_once '../config/includeFromBottom.php';

    $stmt = $db->run("SELECT lijstje.*, 
        (SELECT username FROM users WHERE users.id = lijstje.userID) AS username 
        FROM lijstje
        INNER JOIN (
            SELECT ID FROM surprise
            WHERE isActief
        ) surprise ON surprise.ID = lijstje.surpriseID
        WHERE lijstje.userID != ?
        ORDER BY lijstje.userID DESC", 
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