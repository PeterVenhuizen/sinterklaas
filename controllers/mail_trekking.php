<?php

    // PHPMailer requirements
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    
    require_once '../../config/vendor/PHPMailer/src/Exception.php';
    require_once '../../config/vendor/PHPMailer/src/PHPMailer.php';
    require_once '../../config/vendor/PHPMailer/src/SMTP.php';

    // include_once('../config/includes.php');
    include_once('../config/includeFromBottom.php');

    $stmt = $db->run("SELECT datum, prijsKlein, prijsGroot
        FROM sint_surprise
        WHERE isActief");
    $surprise = $stmt->fetch();
    $datum = date("d-m-Y", strtotime($surprise['datum']));

    $stmt = $db->run("SELECT 
            (SELECT username FROM users WHERE users.id = sint_surprise_to_user.userID) AS username,
            (SELECT username FROM users WHERE users.id = sint_surprise_to_user.getrokkenID) AS lootje,
            (SELECT email FROM users WHERE users.id = sint_surprise_to_user.userID) AS email
        FROM sint_surprise_to_user
        INNER JOIN (
            SELECT sint_surprise.ID FROM sint_surprise
            WHERE isActief
        ) sint_surprise ON sint_surprise.ID = sint_surprise_to_user.surpriseID");

    foreach ($stmt as $record) {

        $from = 'contact@petervenhuizen.nl';

        try {
            
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host       = 'mail.mijndomein.nl';
            $mail->SMTPAuth   = true;
            $mail->Username   = $from;
            $mail->Password   = 'EQ6p*RGt*u&LtaQP';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
            // $mail->SMTPDebug  = true;

            // recipients
            $mail->setFrom($from, 'petervenhuizen.nl');
            // $mail->addAddress($record['email'], $record['username']);
            $mail->addAddress($record['email'], $record['username']);

            // content
            $body = "<p>Beste ${record['username']},</p>";
            $body .= "<p>De lootjes zijn getrokken en jij hebt het lootje van <br/><br/> 
            >>> <span style='font-weight:bold';>${record['lootje']}</span> <<< </p>";

            $body .= "<p>We vieren het dit jaar op ${datum} en de prijs voor de kleine 
            cadeautjes is &euro;${surprise['prijsKlein']} en voor het grote cadeau is dit &euro;${surprise['prijsGroot']}.
            De spelregels zijn als volgt: 1) je schrijft een gedicht(je) en koopt een groot cadeau
            voor de persoon op jouw lootje en 2) je koopt een klein cadeautje voor iedereen die mee doet,
            dus ook nog een klein cadeautje voor de persoon op je lootje.</p>";

            $body .= '<p>Zoals vanouds kunnen de cadeautjes groot en klein worden doorgestreept op
            de <a href="https://petervenhuizen.nl/sinterklaas/">Sinterklaas website</a>, maar daarvoor
            moet je natuurlijk wel snel je <a href="https://petervenhuizen.nl/sinterklaas/mijn_lijstje/">lijstje</a> 
            samenstellen!</p>';

            $body .= '<p>De (digitale) bingoballen zijn gepoetst en zijn helemaal klaar voor 
            meerdere ronden veel te fanatiek bingo spelen!</p>';

            $body .= '<p>Tot snel!</p><p>De Website-Piet</p>';

            $subject = "Sinterklaas trekking ${datum}";
            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $body;
            // $mail->AltBody = $alt_body;

            $mail->send();

        } catch (Exception $e) {
            // print_r($e);
            exit;
        }

    }

?>