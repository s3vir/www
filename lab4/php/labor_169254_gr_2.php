<?php
    $nr_indexu = '169254';
    $nr_grupy = '2';
    echo 'Bartosz Koperski ' . $nr_indexu . ' grupa ' . $nr_grupy . '<br /><br />';
    echo 'Zastosowanie metody include() <br />';

    
    echo 'Metoda include() i require_once() <br />';
   
    if (file_exists('dodatkowy_plik.php')) {
        include('dodatkowy_plik.php'); 
        echo 'Zawartość po include() <br />';
        require_once('dodatkowy_plik.php'); 
        echo 'Zawartość po require_once() <br /><br />';
    } else {
        echo 'Plik dodatkowy_plik.php nie istnieje<br /><br />';
    }

    echo 'Warunki if, else, elseif, switch <br />';
    $liczba = 10;

    if ($liczba < 5) {
        echo 'Liczba jest mniejsza niż 5<br />';
    } elseif ($liczba < 15) {
        echo 'Liczba jest mniejsza niż 15, ale większa lub równa 5<br />';
    } else {
        echo 'Liczba jest większa lub równa 15<br />';
    }

    $kolor = 'czerwony';
    switch ($kolor) {
        case 'czerwony':
            echo 'Kolor czerwony<br />';
            break;
        case 'zielony':
            echo 'Kolor zielony<br />';
            break;
        case 'niebieski':
            echo 'Kolor niebieski<br />';
            break;
        default:
            echo 'Nieznany kolor<br />';
            break;
    }
    echo '<br />';


    echo 'Pętla while() i for() <br />';
  
    $i = 0;
    while ($i < 5) {
        echo 'Pętla while - licznik: ' . $i . '<br />';
        $i++;
    }
    echo '<br />';

    for ($j = 0; $j < 5; $j++) {
        echo 'Pętla for - licznik: ' . $j . '<br />';
    }
    echo '<br />';

    echo 'Typy zmiennych $_GET, $_POST, $_SESSION <br />';

    echo 'Metoda GET - wartość parametru "nazwa": ' . (isset($_GET['nazwa']) ? $_GET['nazwa'] : 'Brak parametru') . '<br />';
    echo 'Metoda POST - wartość parametru "email": ' . (isset($_POST['email']) ? $_POST['email'] : 'Brak parametru') . '<br />';

    
    session_start(); 
    if (!isset($_SESSION['odwiedziny'])) {
        $_SESSION['odwiedziny'] = 1;
    } else {
        $_SESSION['odwiedziny']++;
    }
    echo 'Liczba odwiedzin w tej sesji: ' . $_SESSION['odwiedziny'] . '<br />';
?>
