<?php
    include_once '../config/includeFromBottom.php';

    function trekking($ids, $lootjes = array()) {

        // neem het eerste id als de volgende. array_shift verwijdert dit
        // id van het begin van de array
        $next = array_shift($ids);

        // selecteer een willekeurig ander id
        $lootje = $ids[array_rand($ids)];
        $lootjes[$next] = $lootje;

        // verwijder gekozen id als het zelf al een lootje toegewezen heeft gekregen
        if (isset($lootjes[$lootje])) {
            if (($key = array_search($lootje, $ids)) !== false) {
                unset($ids[$key]);
            }
        }

        // voeg eerste id weer toe aan de mogelijke ids, indien deze nog niet is 
        // gekozen
        if (!in_array($next, array_values($lootjes))) {
            array_push($ids, $next);
        }
        
        // ga door tot er geen ids meer over zijn
        if (count($ids) == 0) {
            return $lootjes;
        }

        return trekking($ids, $lootjes);
    }

    try {

        $db->pdo->beginTransaction();

        $stmt = $db->run("SELECT userID FROM surprise_to_user
            WHERE surpriseID = (SELECT ID FROM surprise WHERE isActief)");

        $ids = $stmt->fetchAll(PDO::FETCH_COLUMN, 0);
        $lootjes = trekking($ids);

        foreach($lootjes as $userID => $getrokkenID) {
            $db->run("UPDATE `surprise_to_user` SET `getrokkenID` = ? 
                WHERE `surpriseID` = (SELECT `ID` FROM `surprise` WHERE `isActief`) 
                AND `userID` = ?",
                [$getrokkenID, $userID]);
        }

        $db->run("UPDATE `surprise` SET `isGesloten` = TRUE WHERE `isActief`");

        $db->pdo->commit();

    } catch (Exception $e) {
        $db->pdo->rollBack();
    }
    exit;
?>