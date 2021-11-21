<?php 
    // include 'config/includes.php'; 
    include './config/includeFromTop.php';

    if (!$_SESSION['is_logged_in']) {
        header("Location: /users/?redirectedFrom=sinterklaas/");
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sinterklaas</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/wishlist.css">
    <script
        src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous">
    </script>
    <script defer src="./js/functions.js"></script>
    <!-- <script defer src="./js/Wishlist.js"></script> -->
    <script defer src="./js/Wish.js"></script>
    <script defer src="./js/index.js"></script>
</head>
<body>

    <div id="app">
        <nav><?php include 'components/nav.php'; ?></nav>
        <main></main>
    </div>
    
    <template id="wishlist-template">
        <div class="wishlist">
            <span class="top-tape"></span>
            <header>
                <h2></h2>
                <i></i>
            </header>
            <ul></ul>
        </div>
    </template>

    <template id="wishlist-item-template">
        <li>
            <i class="far"></i>
            <span class="description"></span> - &euro;<span class="price"></span>
        </li>
    </template>

    <div id="modal-wrapper">
        <div class="modal">
            <i class="fas fa-times modal-close"></i>
            <form>
                <h2>Bevestig aankoop</h2>
                <p>Heb je dit cadeautje <em>echt</em> gekocht? Een aankoop kan
                niet ongedaan worden gemaakt!</p>
                <div class="form-inline">
                    <button class="btn-annuleer btn-medium btn-error">Annuleren</button>
                    <button class="btn-bevestig btn-medium btn-success">Bevestigen</button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>