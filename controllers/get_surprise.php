<?php
    include_once '../config/includeFromBottom.php';

    $stmt = $db->run("SELECT * FROM `surprise` ORDER BY `datum`");

    if ($stmt->rowCount() > 0) {
        $records = array_map(function($row) { return $row; }, $stmt->fetchAll());
        echo json_encode(array(
            "success" => $stmt == true,
            "records" => $records
        ));
        exit;
    }

    echo json_encode(array("success" => false));
    exit;
?>