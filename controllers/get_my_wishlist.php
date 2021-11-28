<?php
    // include_once('../config/includes.php');
    include_once '../config/includeFromBottom.php';

    // insert the new wish
    $stmt = $db->run("SELECT sint_lijstje.* FROM `sint_lijstje` 
        INNER JOIN (
            SELECT ID FROM `sint_surprise`
            WHERE `isActief`
        ) sint_surprise ON sint_surprise.ID = sint_lijstje.surpriseID
        WHERE `userID` = ?", 
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