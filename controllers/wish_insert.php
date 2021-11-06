<?php
    include_once '../config/includeFromBottom.php';
    $params = json_decode(file_get_contents('php://input'), true);

    // insert the new wish
    $status = $db->run("INSERT INTO `wish`
        (`userID`, `description`, `price`, `store`, `store_url`)
        VALUES (?, ?, ?, ?, ?)",
        [
            $params['userID'], $params['description'], $params['price'], 
            $params['store'], $params['store_url']
        ]);
    
    echo json_encode(array(
        "status" => $status,
        "id" => $db->pdo->lastInsertId()
    ));
    exit;
?>