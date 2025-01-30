<?php
include 'cfg.php';

function PokazPodstrone($id) {
    global $conn;
    $id_clear = intval($id); // Oczyszczenie ID z GET
    $query = "SELECT * FROM page_list WHERE id='$id_clear' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        echo "<h1>" . htmlspecialchars($row['page_title']) . "</h1>";
        echo $row['page_content']; // Treść HTML
    } else {
        echo "Nie znaleziono strony.";
    }
}


?>
