<?php 
    // include 'config/includes.php'; 
    include './config/includeFromTop.php';

    if (!$_SESSION['is_logged_in'] || $_SESSION['privileges'] < 3) {
        http_response_code(404);
        include '404.php';
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/sinterklaas/">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoofdpiet</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <!-- <link rel="stylesheet" href="./css/style.css"> -->
    <link rel="stylesheet" href="./css/hoofdpiet.css">
    <script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous">
    </script>
    <script defer src="./js/functions.js"></script>
    <script defer src="./js/hoofdpiet.js"></script>
</head>
<body>

    <div id="app">
        <nav><?php include 'components/nav.php'; ?></nav>
        <main>

            <div class="center-column">
                <div id="surprise-planner">
                    <h2>Surprise planner</h2>
                    <p>
                        Het kalender symbooltje met een vinkje (<i class="far fa-calendar-check"></i>) 
                        geeft aan welke surprise geselecteerd is. De lijstje voor de actieve surprise
                        worden weergegeven. 
                    </p>
                    <p>
                        Zolang een surprise nog "open" staat (<i class="fas fa-lock-open"></i>) kunnen
                        deelnemers worden geselecteerd en kan er een trekking worden gedaan met de geselecteerde
                        deelnemers. Hierna gaat de surprise "op slot" (<i class="fas fa-lock"></i>) en is 
                        het niet meer mogelijk om de deelnemers te wijzigen.  
                    </p>
                </div>
                <button id="show-insert-form" class="btn-primary btn-small">Plan nieuwe surprise</button>

                <div>
                    <h2>Selecteer deelnemers</h2>
                    <p>
                        Selecteer de deelnemers voor de surprise. In de linker kolom staan alle geregistreerde
                        gebruikers en in de rechter kolom de deelnemers reeds geselecteerd voor de actieve surprise.
                        Gebruikers kunnen tussen de twee kolommen gesleept worden en deelnemers kunnen worden
                        vastgelegd door op de "Opslaan" knop te klikken.
                    </p>
                    <div id="selecteer-deelnemers">
                        <div id="alle-gebruikers" data-drop-target="true">
                            <h3>Alle gebruikers</h3>
                        </div>
                        <i class="fas fa-exchange-alt"></i>
                        <div id="gekozen-gebruikers" data-drop-target="true">
                            <h3>Surprise deelnemers</h3>
                        </div>
                    </div>
                </div>
                <button id="save-surprise-deelnemers" class="btn-primary btn-small">Opslaan</button>
            </div>

        </main>
    </div>

    <template id="surprise-template">
        <div class="surprise">
            <time></time>
            <span>
                &euro;<span class="prijs"></span>
            </span>
            <span>
                &euro;<span class="prijs"></span>
            </span>
            <i class="far"></i>
            <i class="fas"></i>
            <!-- <i class="fas fa-trash"></i> -->
            <!-- <i class="fas fa-chevron-down"></i>   -->
        </div>
    </template>

    <div id="modal-wrapper">
        <div class="modal">
            <i class="fas fa-times modal-close"></i>
            <form id="insert-surprise">
                <h2>Voeg nieuwe surprise toe</h2>
                <p>Alle velden zijn verplicht</p>
                
                <label for="datum">Datum: </label>
                <input type="date" name="datum" placeholder="Surprise datum" required>
                
                <label for="prijs-klein">Prijs klein cadeautje: </label>
                <input type="number" name="prijs-klein" placeholder="Prijs kleine cadeautjes" min="0", step=".5" required>
                
                <label for="prijs-groot">Prijs groot cadeau: </label>
                <input type="number" name="prijs-groot" placeholder="Prijs grote cadeau" min="0", step=".5" required>

                <button type="submit" class="btn-submit">Voeg toe</button>
            </form>
        </div>
    </div>

</body>
</html>