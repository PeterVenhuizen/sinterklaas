<?php
    include_once '../config/includeFromBottom.php';
    $params = json_decode(file_get_contents('php://input'), true);

    $status = $db->run("UPDATE `wish` SET 
        `description` = ?, `price` = ?, `store` = ?, `store_url` = ?
        WHERE `wishID` = ?",
        [
            $params['description'], $params['price'], $params['store'], 
            $params['store_url'], $params['wishID']
        ]);

    echo json_encode($status);
    exit;
?>