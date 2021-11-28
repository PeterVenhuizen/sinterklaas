<?php
    // include_once('../config/includes.php');
    include_once '../config/includeFromBottom.php';
    $params = json_decode(file_get_contents('php://input'), true);

    // insert the new wish
    $status = $db->run("INSERT INTO `sint_lijstje`
        (`userID`, `surpriseID`, `beschrijving`, `prijs`, `winkel`, `url`)
        VALUES (?, (SELECT ID FROM `sint_surprise` WHERE `isActief`), ?, ?, ?, ?)",
        [
            $params['userID'], $params['beschrijving'], $params['prijs'], 
            $params['winkel'], $params['url']
        ]
    );
    
    echo json_encode(array(
        "status" => $status,
        "id" => $db->pdo->lastInsertId()
    ));
    exit;
?>