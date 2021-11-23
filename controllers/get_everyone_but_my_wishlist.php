<?php
    include_once '../config/includeFromBottom.php';

    $stmt = $db->run("SELECT lijstje.*, users.username FROM lijstje, users
        WHERE lijstje.userID != ? AND lijstje.userID = users.id 
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