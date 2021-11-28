<?php
    // include_once('../config/includes.php');
    include_once '../config/includeFromBottom.php';
    $params = json_decode(file_get_contents('php://input'), true);

    $status = $db->run("UPDATE `sint_lijstje` SET 
        `beschrijving` = ?, `prijs` = ?, `winkel` = ?, `url` = ?
        WHERE `ID` = ?",
        [
            $params['beschrijving'], $params['prijs'], $params['winkel'], 
            $params['url'], $params['ID']
        ]
    );

    echo json_encode($status);
    exit;
?>