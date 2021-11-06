<?php
    include_once '../config/includeFromBottom.php';
    $params = json_decode(file_get_contents('php://input'), true);

    $status = $db->run("UPDATE `wish` SET `bought` = TRUE 
        WHERE `wishID` = ?",
        [$params['wishID']]);

    echo json_encode($status);
    exit;
?>