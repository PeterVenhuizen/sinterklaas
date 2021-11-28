<?php
    include_once '../config/includeFromBottom.php';
    $params = json_decode(file_get_contents('php://input'), true);

    try {

        $db->pdo->beginTransaction();

        $db->run("UPDATE `surprise` SET isActief = NULL WHERE isActief");

        $status = $db->run("INSERT INTO `surprise`
        (`datum`, `prijsKlein`, `prijsGroot`)
        VALUES (?, ?, ?)",
        [
            $params['datum'], $params['prijs-klein'], $params['prijs-groot']
        ]);

        $db->pdo->commit();

    } catch (Exception $e) {
        $db->pdo->rollBack();
    }
    exit;
?>