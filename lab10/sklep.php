<?php
// Ustawienia bazy danych (dodaj odpowiednie wartości dla swojego projektu)
define('DB_HOST', 'localhost'); // Nazwa hosta (np. localhost)
define('DB_USER', 'root'); // Użytkownik bazy danych
define('DB_PASS', ''); // Hasło bazy danych
define('DB_NAME', 'moja_strona'); // Nazwa bazy danych

session_start();

// Połączenie z bazą danych
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Pobieranie produktów z bazy danych
$sql = "SELECT id, title, price_net, vat AS vat_rate, stock, image FROM products WHERE stock > 0";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<h1 style='text-align: center; font-family: Arial, sans-serif; margin-bottom: 20px;'>Produkty</h1><div style='display: flex; flex-wrap: wrap; justify-content: center; gap: 40px; align-items: flex-start;'>";
    while ($row = $result->fetch_assoc()) {
        $imagePath = $row['image'];
        $price_brutto = $row['price_net'] * (1 + $row['vat_rate'] / 100);

        echo "<div style='box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); padding: 20px; border-radius: 10px; width: 220px; text-align: center; font-family: Arial, sans-serif; background-color: #f9f9f9;'>";
        echo "<img src='$imagePath' alt='{$row['title']}' style='width: 100%; height: auto; border-radius: 10px; margin-bottom: 10px;'>";
        echo "<h2 style='font-size: 1.2em; margin: 10px 0;'>{$row['title']}</h2>";
        echo "<p style='margin: 5px 0;'>Cena netto: <strong>{$row['price_net']} zł</strong></p>";
        echo "<p style='margin: 5px 0;'>VAT: <strong>{$row['vat_rate']}%</strong></p>";
        echo "<p style='margin: 5px 0;'>Cena brutto: <strong>{$price_brutto} zł</strong></p>";
        echo "<form method='POST' style='margin-top: 10px;'>";
        echo "<input type='hidden' name='productId' value='{$row['id']}'>";
        echo "<input type='hidden' name='price' value='{$price_brutto}'>";
        echo "<label style='display: block; margin-bottom: 10px;'>Ilość: <input type='number' name='quantity' value='1' min='1' max='{$row['stock']}' style='width: 60px; text-align: center;'></label>";
        echo "<button type='submit' name='action' value='add' style='padding: 10px 20px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;'>Dodaj do koszyka</button>";
        echo "</form>";
        echo "</div>";
    }
    echo "</div>";
} else {
    echo "<h1 style='text-align: center; font-family: Arial, sans-serif;'>Brak dostępnych produktów</h1>";
}


// Obsługa akcji koszyka
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    $action = $_POST['action'];
    $productId = $_POST['productId'];
    if ($action === 'add') {
        $quantity = (int)$_POST['quantity'];
        $price = (float)$_POST['price'];
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId]['quantity'] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = ['quantity' => $quantity, 'price' => $price];
        }
    } elseif ($action === 'remove') {
        unset($_SESSION['cart'][$productId]);
    } elseif ($action === 'update') {
        $quantity = (int)$_POST['quantity'];
        if ($quantity > 0) {
            $_SESSION['cart'][$productId]['quantity'] = $quantity;
        } else {
            unset($_SESSION['cart'][$productId]);
        }
    }
}

// Wyświetlenie koszyka na dole strony
if (!empty($_SESSION['cart'])) {
    echo "<h2 style='text-align: center; font-family: Arial, sans-serif;'>Twój koszyk</h2><div style='border: 1px solid #ccc; padding: 20px; border-radius: 10px; font-family: Arial, sans-serif; margin: 20px auto; width: 80%; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); background-color: #fff;'>";
    $total = 0;
    echo "<table style='width: 100%; border-collapse: collapse;'>";
    echo "<tr style='background-color: #f1f1f1;'>
            <th style='padding: 10px; border-bottom: 1px solid #ddd;'>Produkt</th>
            <th style='padding: 10px; border-bottom: 1px solid #ddd;'>Ilość</th>
            <th style='padding: 10px; border-bottom: 1px solid #ddd;'>Cena jednostkowa</th>
            <th style='padding: 10px; border-bottom: 1px solid #ddd;'>Łączna cena</th>
            <th style='padding: 10px; border-bottom: 1px solid #ddd;'>Akcje</th>
          </tr>";

    foreach ($_SESSION['cart'] as $productId => $details) {
        // Pobranie nazwy produktu z bazy danych
        $productQuery = $conn->prepare("SELECT title FROM products WHERE id = ?");
        $productQuery->bind_param("i", $productId);
        $productQuery->execute();
        $productResult = $productQuery->get_result();

        // Sprawdzenie, czy produkt istnieje
        if ($productResult->num_rows > 0) {
            $productName = $productResult->fetch_assoc()['title'];
        } else {
            $productName = "Nieznany produkt"; // Domyślna nazwa w przypadku braku wyniku
        }

        $subtotal = $details['quantity'] * $details['price'];
        $total += $subtotal;

        echo "<tr>";
        echo "<td style='padding: 10px; border-bottom: 1px solid #ddd; text-align: center;'>$productName</td>";
        echo "<td style='padding: 10px; border-bottom: 1px solid #ddd; text-align: center;'>
                <form method='POST'>
                  <input type='number' name='quantity' value='{$details['quantity']}' min='1' style='width: 60px; text-align: center;'>
                  <input type='hidden' name='productId' value='$productId'>
                  <button type='submit' name='action' value='update' style='margin-left: 10px; padding: 5px 10px; background-color: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;'>Zmień</button>
                </form>
              </td>";
        echo "<td style='padding: 10px; border-bottom: 1px solid #ddd; text-align: center;'>{$details['price']} zł</td>";
        echo "<td style='padding: 10px; border-bottom: 1px solid #ddd; text-align: center;'>$subtotal zł</td>";
        echo "<td style='padding: 10px; border-bottom: 1px solid #ddd; text-align: center;'>
                <form method='POST'>
                  <input type='hidden' name='productId' value='$productId'>
                  <button type='submit' name='action' value='remove' style='padding: 5px 10px; background-color: #dc3545; color: white; border: none; border-radius: 5px; cursor: pointer;'>Usuń</button>
                </form>
              </td>";
        echo "</tr>";
    }

    echo "<tr>
            <td colspan='3' style='padding: 10px; text-align: right;'><strong>Razem:</strong></td>
            <td colspan='2' style='padding: 10px; text-align: center;'><strong>$total zł</strong></td>
          </tr>";
    echo "</table>";
    echo "</div>";
} else {
    echo "<h2 style='text-align: center; font-family: Arial, sans-serif;'>Koszyk jest pusty</h2>";
}



$conn->close();
?>