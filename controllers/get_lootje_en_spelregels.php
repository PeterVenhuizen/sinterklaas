<?php
    // include_once('../config/includes.php');
    include_once '../config/includeFromBottom.php';

    $stmt = $db->run("SELECT 
            IFNULL(
                (SELECT username FROM users WHERE users.id = sint_surprise_to_user.getrokkenID), ''
            ) AS lootje
        FROM sint_surprise_to_user
        INNER JOIN (
            SELECT ID FROM sint_surprise
            WHERE isActief
        ) sint_surprise ON sint_surprise.ID = sint_surprise_to_user.surpriseID
        WHERE sint_surprise_to_user.userID = ?",
        [$_SESSION['user_id']]);

    $lootje = $stmt->fetchColumn();

    $stmt = $db->run("SELECT *
        FROM sint_surprise
        WHERE isActief");
    $surprise = $stmt->fetch();

    echo json_encode(array(
        "lootje" => $lootje,
        "surprise" => $surprise
    ));
    exit;

    // if ($stmt->rowCount() > 0) {
    //     $records = array_map(function($row) { return $row; }, $stmt->fetchAll());
    //     echo json_encode(array(
    //         "success" => true,
    //         "records" => $records
    //     ));
    //     exit;
    // }

    // echo json_encode(array("success" => false));
    // exit;
?>