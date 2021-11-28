<?php
    // include_once('../config/includes.php');
    include_once '../config/includeFromBottom.php';
    $params = json_decode(file_get_contents('php://input'), true);

    // insert the new wish
    $status = $db->run("INSERT INTO `sint_follower`
        (`userID`, `followerID`) VALUES (?, ?)",
        [$params['userID'], $params['followerID']]);
    
    echo json_encode($status);
    exit;
?>