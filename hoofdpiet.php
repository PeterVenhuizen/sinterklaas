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
    <link rel="stylesheet" href="./css/style.css">
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
        <main></main>
    </div>

    <div id="modal-wrapper">
        <div class="modal">
            <i class="fas fa-times modal-close"></i>
            <form></form>
        </div>
    </div>

</body>
</html>