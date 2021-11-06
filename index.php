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
    <script defer src="./js/Wishlist.js"></script>
</head>
<body>

    <div id="app">
        <nav><?php include 'components/nav.php'; ?></nav>
        <main>

            <div class="wishlist note-paper bg-pinkish">
                <span class="top-tape"></span>
                <header>
                    <h2>Peter</h2>
                    <i class="fas fa-bell"></i>
                </header>
                <ul>
                    <li><i class="far fa-square"></i><a href="">Lucky Luke, een cowboy tussen het katoen.</a> - €7,95</li>
                    <li class="bought"><i class="far fa-check-square"></i>Book #2</li>
                    <li><i class="far fa-check-square"></i>Book #2</li>
                    <li><i class="far fa-check-square"></i>Book #3</li>
                    <li><i class="far fa-check-square"></i>Book #4</li>
                    <li><i class="far fa-check-square"></i>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Harum sed incidunt debitis quibusdam quos esse. Porro, distinctio amet? Excepturi qui esse tempore, molestiae sit placeat assumenda? A vel temporibus eius.</li>
                </ul>
            </div>
        
            <div class="wishlist holed-paper bg-greenish">
                <span class="top-tape"></span>
                <header>
                    <h2>Gertjan</h2>
                    <i class="far fa-bell-slash"></i>
                </header>
                <ul>
                    <li><i class="far fa-square"></i>Book #1</li>
                    <li><i class="far fa-square"></i>Book #2</li>
                    <li><i class="far fa-square"></i>Book #3</li>
                    <li><i class="far fa-square"></i>Book #4</li>
                </ul>
            </div>
        
            <div class="wishlist squared-paper bg-blueish">
                <span class="top-tape"></span>
                <header>
                    <h2>Willem</h2>
                    <i class="far fa-bell-slash"></i>
                </header>
                <ul>
                    <li><i class="far fa-square"></i>Book #1</li>
                    <li><i class="far fa-square"></i><a href="">Lucky Luke, een cowboy tussen het katoen.</a> - €7,95</li>
                    <li class="bought"><i class="far fa-check-square"></i>Book #2</li>
                    <li><i class="far fa-square"></i>Book #4</li>
                    <li><i class="far fa-square"></i>Book #1</li>
                    <li><i class="far fa-square"></i>Book #2</li>
                    <li><i class="far fa-square"></i>Book #3</li>
                    <li class="bought"><i class="far fa-check-square"></i>Book #4</li>
                </ul>
            </div>

            <div class="wishlist holed-paper bg-blueish">
                <span class="top-tape"></span>
                <header>
                    <h2>Gertjan</h2>
                    <i class="far fa-bell-slash"></i>
                </header>
                <ul>
                    <li><i class="far fa-square"></i>Book #1</li>
                    <li><i class="far fa-square"></i>Book #2</li>
                    <li><i class="far fa-square"></i>Book #3</li>
                    <li><i class="far fa-square"></i>Book #4</li>
                </ul>
            </div>

            <div class="wishlist note-paper bg-yellowish">
                <span class="top-tape"></span>
                <header>
                    <h2>Peter</h2>
                    <i class="fas fa-bell"></i>
                </header>
                <ul>
                    <li><i class="far fa-square"></i><a href="">Lucky Luke, een cowboy tussen het katoen.</a> - €7,95</li>
                    <li class="bought"><i class="far fa-check-square"></i>Book #2</li>
                    <li><i class="far fa-square"></i>Book #3</li>
                    <li><i class="far fa-square"></i>Book #4</li>
                    <li class="bought"><i class="far fa-check-square"></i>Book #1</li>
                    <li><i class="far fa-square"></i>Book #2</li>
                    <li><i class="far fa-square"></i>Book #3</li>
                </ul>
            </div>

        </main>
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

    <template id="wishlist-line-template">
        <li>
            <i class="far"></li>
            <span class="description"></span> - &euro;<span class="price"></span>
        </li>
    </template>

</body>
</html>