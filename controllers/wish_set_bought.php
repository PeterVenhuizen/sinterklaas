<?php
    include_once '../config/includeFromBottom.php';
    $params = json_decode(file_get_contents('php://input'), true);

    $status = $db->run("UPDATE `lijstje` SET `isGekocht` = TRUE 
        WHERE `ID` = ?",
        [$params['ID']]
    );

    echo json_encode($status);
    exit;
?>