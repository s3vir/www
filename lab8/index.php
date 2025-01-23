<?php
    error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

    
    if ($_GET['idp'] == '') {
        $strona = 'html/glowna.html';
    } elseif ($_GET['idp'] == 'about') {
        $strona = 'html/about.html';
    } elseif ($_GET['idp'] == 'gallery') {
        $strona = 'html/gallery.html';
    } elseif ($_GET['idp'] == 'services') {
        $strona = 'html/services.html';
    } elseif ($_GET['idp'] == 'future') {
        $strona = 'html/future.html';
    } elseif ($_GET['idp'] == 'contact') {
        $strona = 'html/contact.html';
    } 
    elseif ($_GET['idp'] == 'films') {
    $strona = 'html/films.html';
}
    else {
        
        $strona = 'html/blad.html';
    }

    
    if (!file_exists($strona)) {
        $strona = 'html/blad.html';
    }
    

include 'cfg.php';
echo "Połączenie z bazą danych jest aktywne.";

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historia</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/kolorujtlo.js" defer></script>
    <script src="timedate.js" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body onload="startclock()">
    <div id="zegarek"></div>
    <div id="data"></div>
    <header>
        <h1>Historia Komputerow</h1>
    </header>

    <nav>
        <ul>
            <li class="active"><a href="index.php">Home</a></li>
            <li><a href="index.php?idp=about">Historia</a></li>
            <li><a href="index.php?idp=gallery">Galeria Komputerow</a></li>
            <li><a href="index.php?idp=services">Programy Komputerowe</a></li>
            <li><a href="index.php?idp=future">Przyszłość</a></li>
            <li><a href="index.php?idp=contact">Kontakt</a></li>
            <li><a href="index.php?idp=films">Filmy</a></li>
        </ul>
    </nav>

    <main>
    <?php include($strona); ?>

    </main>

    <footer>
        <p>&copy; Bartosz Koperski</p>
    </footer>
    <script>
        
        $("#animacjal").on("click", function() {
            $(this).animate({
                width: "500px",
                opacity: 0.4,
                fontSize: "3em",
                borderWidth: "10px"
            }, 1500);
        });

        
        $("#animacja2").on({
            "mouseover": function() {
                $(this).animate({
                    width: "300px"
                }, 800);
            },
            "mouseout": function() {
                $(this).animate({
                    width: "200px"
                }, 800);
            }
        });
        $("#animacja3").on("click", function() {
            if (!$(this).is(":animated")) {
                $(this).animate({
                    width: "+=50",
                    height: "+=50", 
                    opacity: 0.1
                }, 3000); 
            }
        });
    </script>

</body>
</html>
