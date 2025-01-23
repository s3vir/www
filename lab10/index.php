<?php
// Połączenie z bazą danych
$mysqli = new mysqli("localhost", "root", "", "moja_strona");

if ($mysqli->connect_error) {
    die("Połączenie nieudane: " . $mysqli->connect_error);
}

// Pobranie wartości idp z URL
$idp = $_GET['idp'] ?? 'about';

// Przygotowanie zapytania SQL
$query = "SELECT page_content, page_image FROM page_list WHERE page_title = ? AND status = 1";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("s", $idp);
$stmt->execute();
$result = $stmt->get_result();

// Sprawdzenie, czy zapytanie zwróciło wyniki
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $page_content = $row['page_content'];
    $page_image = $row['page_image'];
} else {
    $page_content = "<h2>Błąd 404: Strona nie została znaleziona</h2>";
    $page_image = "img/404.png"; // Opcjonalnie dodaj obraz błędu
}

// Zamknięcie połączenia z bazą danych
$stmt->close();
$mysqli->close();
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historia Komputerów</title>
    <link rel="stylesheet" href="css/styles.css">
    <script src="js/kolorujtlo.js" defer></script>
    <script src="js/timedate.js" defer></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    <header>
        <h1>Historia Komputerów</h1>
    </header>

    <nav>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="index.php?idp=about">Historia</a></li>
            <li><a href="index.php?idp=gallery">Galeria Komputerów</a></li>
            <li><a href="index.php?idp=services">Programy Komputerowe</a></li>
            <li><a href="index.php?idp=future">Przyszłość</a></li>
            <li><a href="index.php?idp=contact">Kontakt</a></li>
            <li><a href="index.php?idp=films">Filmy</a></li>
        </ul>
    </nav>

    <main>
        <!-- Wyświetlanie treści i obrazu -->
        <?php
        echo $page_content;
        if (!empty($page_image)) {
            echo '<img src="' . htmlspecialchars($page_image) . '" alt="Obraz strony" style="max-width:100%; height:auto;">';
        }
        ?>
    </main>

    <footer>
        <p>&copy; Bartosz Koperski</p>
    </footer>
</body>
</html>
