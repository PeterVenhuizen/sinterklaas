<?php 
    // include 'config/includes.php'; 
    include './config/includeFromTop.php';

    if (!$_SESSION['is_logged_in'] || $_SESSION['privileges'] < 1) {
        header("Location: /users/?redirectedFrom=sinterklaas/");
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <base href="/sinterklaas/">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="img/pakje.ico" >
    <title>Sinterklaas</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/wishlist.css">
    <script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous">
    </script>
    <script defer src="./js/functions.js"></script>
    <script defer src="./js/Wish.js"></script>
    <script type="text/javascript">
        const USER_ID = '<?php echo $_SESSION["user_id"]; ?>';
    </script>
    <script defer src="./js/list.js"></script>
</head>
<body>

    <div id="app">
        <nav><?php include 'components/nav.php'; ?></nav>
        <main>

            <div class="wishlist note-paper big">
                <header>
                    <h2>Mijn Lijstje</h2>
                </header>
                <ul id="my-wishlist"></ul>

                <form action="" id="form-insert-wish">
                    <h2>Voeg een cadeautje toe</h2>
                    <p>De velden met een <span class="required">*</span> zijn verplicht, 
                    de andere velden zijn optioneel. <b>Let op:</b> Het is niet 
                    mogelijk om cadeautjes van je lijstje te verwijderen, maar je kunt
                    later wel de beschrijving, prijs, winkel en de link aanpassen, door
                    op het <i class="fas fa-pen-square"></i> icoontje te klikken.
                    </p>
                    <div class="form-inline">
                        <label for="cadeau">Cadeau <span class="required">*</span></label>
                        <input type="text" name="cadeau" 
                            placeholder="Korte beschrijving of naam van het cadeautje"
                            pattern="^.{3,}"
                            title="De beschrijving moet tenminste drie tekens lang zijn."
                            required>
                    </div>

                    <div class="form-inline">
                        <label for="prijs">Prijs <span class="required">*</span></label>
                        <input type="text" name="prijs" 
                            placeholder="Prijs (bijvoorbeeld 9,99 of 15)" 
                            pattern="^[0-9]{1,2}(,[0-9]{0,2})?"
                            title="Prijs kan enkel bestaan uit maximaal twee getallen voor en na de comma, bijvoorbeeld 9,99 of 15"
                            required>
                    </div>

                    <div class="form-inline">
                        <label for="winkel">Winkel</label>
                        <input type="text" name="winkel" placeholder="(Optioneel) Naam van de (online) winkel">
                    </div>

                    <div class="form-inline">
                        <label for="link">Link</label>
                        <input type="url" name="link" placeholder="(Optioneel) Link naar het cadeautje">
                    </div>

                    <button type="submit" name="submit" class="btn-submit">Voeg toe</button>
                </form>

            </div>

        </main>
    </div>

    <template id="wishlist-line">
        <li>
            <i class="fas fa-pen-square"></i>
            <span class="description"></span> - &euro;<span class="price"></span>
        </li>
    </template>

    <div id="modal-wrapper">
        <div class="modal">
            <i class="fas fa-times modal-close"></i>
            <form id="form-update-wish">
                <h2>Wijzig je cadeautje</h2>
                <p>Het is niet mogelijk om cadeautjes te verwijderen, maar je 
                kunt hier de beschrijving, prijs, winkel en de link aanpassen.</p>

                <input type="text" name="wish_id" hidden>
                <input type="text" name="cadeau" 
                    placeholder="Korte beschrijving of naam van het cadeautje"
                    pattern="^.{3,}"
                    title="De beschrijving moet tenminste drie tekens lang zijn."
                    required>
                <input type="text" name="prijs"
                    placeholder="Prijs (bijvoorbeeld 9.99 of 15)" 
                    pattern="^[0-9]{1,2}(,[0-9]{0,2})?"
                    title="Prijs kan enkel bestaan uit maximaal twee getallen voor en na de comma, bijvoorbeeld 9.99 of 15"
                    required>
                <input type="text" name="winkel" 
                    placeholder="(Optioneel) Naam van de (online) winkel">
                <input type="url" name="link" 
                    placeholder="(Optioneel) Link naar het cadeautje">

                <button type="submit" name="submit" class="btn-submit">Wijzig</button>
            </form>
        </div>
    </div>

</body>
</html>