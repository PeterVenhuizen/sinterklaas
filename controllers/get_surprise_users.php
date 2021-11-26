<?php
    include_once '../config/includeFromBottom.php';

    $stmt = $db->run("SELECT `id`, `username` FROM `users` WHERE `privileges` >= 1");

    if ($stmt->rowCount() > 0) {
        $records = array_map(function($row) { return $row; }, $stmt->fetchAll());

        $stmt2 = $db->run("SELECT `userID` FROM `surprise_to_user` 
            WHERE `surpriseID` = (SELECT `ID` FROM `surprise` WHERE `isActief`)");
        $selected = $stmt2->fetchAll(PDO::FETCH_COLUMN, 0);

        echo json_encode(array(
            "success" => true,
            "records" => $records,
            "selected" => $selected
        ));
        exit;
    }

    echo json_encode(array("success" => false));
    exit;
?>