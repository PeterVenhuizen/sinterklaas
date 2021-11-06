<?php
    include_once '../config/includeFromBottom.php';

    $stmt = $db->run("SELECT wish.*, users.username FROM wish, users
        WHERE wish.userID != ? AND wish.userID = users.id
        ORDER BY wish.userID DESC", 
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