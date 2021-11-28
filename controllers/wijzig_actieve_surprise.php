<?php
    include_once '../config/includeFromBottom.php';
    $params = json_decode(file_get_contents('php://input'), true);
    echo json_encode($params);
    
    try {
        $db->pdo->beginTransaction();
        $db->run("UPDATE `surprise` SET isActief = NULL WHERE isActief");
        $db->run("UPDATE `surprise` SET isActief = TRUE WHERE ID = ?", [$params['id']]);
        $db->pdo->commit();

    } catch (Exception $e) {
        $db->pdo->rollback();
    }

    exit;
?>