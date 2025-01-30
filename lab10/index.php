<?php
include('cfg.php');
error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING);

// Domyślna strona ładowana na start
$strona = 'html/about.html';

// Obsługa przekierowań na podstawie parametru idp
if (isset($_GET['idp'])) {
    switch ($_GET['idp']) {
        case 'about':
            $strona = 'html/about.html';
            break;
        case 'contact':
            $strona = 'html/contact.html';
            break;
        case 'gallery':
            $strona = 'html/gallery.html';
            break;
        case 'future':
            $strona = 'html/future.html';
            break;
        case 'films':
            $strona = 'html/films.html';
            break;
        default:
            $strona = 'html/about.html'; // Strona domyślna, jeśli podano błędny parametr
    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dynamiczna Strona</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/kolorujtlo.js" defer></script>
    <script src="js/timedate.js" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
        }
        nav {
            background-color: #007bff;
            padding: 15px;
            display: flex;
            justify-content: center;
            gap: 20px;
        }
        nav a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            padding: 10px 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        nav a:hover {
            background-color: #0056b3;
        }
        main {
            padding: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <!-- Nawigacja -->
    <nav>
        <ul class="menu">
            <li><a href="index.php?idp=about">Historia</a></li>
            <li><a href="index.php?idp=contact">Kontakt</a></li>
            <li><a href="index.php?idp=gallery">Galeria Komputerów</a></li>
            <li><a href="index.php?idp=future">Przyszłość</a></li>
            <li><a href="index.php?idp=films">Filmy</a></li>
            <li><a href="admin/admin.php">Admin</a></li>
            <li><a href="sklep.php">Sklep</a></li>
        </ul>
    </nav>

    <!-- Dynamiczna zawartość strony -->
    <main>
        <?php include($strona); ?>
    </main>
</body>
</html>
