<?php
    include_once '../config/includeFromBottom.php';

    // insert the new wish
    $stmt = $db->run("SELECT lijstje.* FROM `lijstje` 
        INNER JOIN (
            SELECT ID FROM `surprise`
            WHERE `isActief`
        ) surprise ON surpriseID = lijstje.surpriseID
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