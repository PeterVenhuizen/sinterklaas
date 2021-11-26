<?php
    include_once '../config/includeFromBottom.php';
    $params = json_decode(file_get_contents('php://input'), true);

    try {

        $db->pdo->beginTransaction();

        $db->run("DELETE FROM `surprise_to_user` 
            WHERE `surpriseID` = (SELECT `ID` FROM `surprise` WHERE `isActief`)");

        foreach ($params['ids'] as $id) {
            $db->run("INSERT INTO `surprise_to_user` (`surpriseID`, `userID`)
                VALUES ((SELECT `ID` FROM `surprise` WHERE `isActief`), ?)",
                [$id]);
        }

        $db->pdo->commit();

    } catch (Exception $e) {
        $db->pdo->rollBack();
    }
    exit;
?>