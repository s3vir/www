<?php
// Ustawienia bazy danych
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'moja_strona');

// Połączenie z bazą danych
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Zarządzanie kategoriami
function fetchCategories($conn) {
    $sql = "SELECT * FROM categories ORDER BY parent_id, id";
    return $conn->query($sql);
}

function addCategory($conn, $name, $parentId = 0) {
    $stmt = $conn->prepare("INSERT INTO categories (name, parent_id) VALUES (?, ?)");
    $stmt->bind_param("si", $name, $parentId);
    $stmt->execute();
    $stmt->close();
}

function deleteCategory($conn, $categoryId) {
    $stmt = $conn->prepare("DELETE FROM categories WHERE id = ?");
    $stmt->bind_param("i", $categoryId);
    $stmt->execute();
    $stmt->close();
}

function editCategory($conn, $categoryId, $name, $parentId = 0) {
    $stmt = $conn->prepare("UPDATE categories SET name = ?, parent_id = ? WHERE id = ?");
    $stmt->bind_param("sii", $name, $parentId, $categoryId);
    $stmt->execute();
    $stmt->close();
}

// Zarządzanie produktami
function fetchProducts($conn) {
    $sql = "SELECT p.*, c.name AS category_name FROM products p LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.id";
    return $conn->query($sql);
}

function addProduct($conn, $title, $description, $priceNet, $vat, $stock, $categoryId, $image) {
    $stmt = $conn->prepare("INSERT INTO products (title, description, price_net, vat, stock, category_id, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssddiis", $title, $description, $priceNet, $vat, $stock, $categoryId, $image);
    $stmt->execute();
    $stmt->close();
    
}

function deleteProduct($conn, $productId) {
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $stmt->close();
    
}

function editProduct($conn, $productId, $title, $description, $priceNet, $vat, $stock, $categoryId, $image) {
    $stmt = $conn->prepare("UPDATE products SET title = ?, description = ?, price_net = ?, vat = ?, stock = ?, category_id = ?, image = ? WHERE id = ?");
    $stmt->bind_param("ssddiisi", $title, $description, $priceNet, $vat, $stock, $categoryId, $image, $productId);
    $stmt->execute();
    $stmt->close();
    
}
// Zarządzanie podstronami
function fetchSubpages($conn) {
    $sql = "SELECT * FROM subpages ORDER BY id";
    $result = $conn->query($sql);
    if (!$result) {
        die("Error fetching subpages: " . $conn->error);
    }
    return $result;
}

function addSubpage($conn, $title, $filename) {
    $stmt = $conn->prepare("INSERT INTO subpages (title, filename) VALUES (?, ?)");
    if (!$stmt) {
        die("Błąd podczas przygotowania zapytania: " . $conn->error);
    }
    $stmt->bind_param("ss", $title, $filename);
    if (!$stmt->execute()) {
        die("Błąd podczas wykonywania zapytania: " . $stmt->error);
    }
    $stmt->close();
}


function deletepage($conn, $pageId) {
    $stmt = $conn->prepare("DELETE FROM pages WHERE id = ?");
    if (!$stmt) {
        die("Prepare failed for deletepage: " . $conn->error);
    }
    $stmt->bind_param("i", $pageId);
    $stmt->execute();
    if ($stmt->error) {
        die("Execution failed for deletepage: " . $stmt->error);
    }
    $stmt->close();
}

function editpage($conn, $pageId, $title, $filename) {
    $stmt = $conn->prepare("UPDATE pages SET title = ?, filename = ? WHERE id = ?");
    if (!$stmt) {
        die("Prepare failed for editpage: " . $conn->error);
    }
    $stmt->bind_param("ssi", $title, $filename, $pageId);
    $stmt->execute();
    if ($stmt->error) {
        die("Execution failed for editpage: " . $stmt->error);
    }
    $stmt->close();
}

function addStyles() {
    echo "<style>
        body {
            font-family: 'Roboto', Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
            color: #333;
        }
        h1, h2 {
            text-align: center;
            margin-top: 20px;
            color: #d32f2f;
        }
        h2 {
            margin-top: 40px;
            font-size: 20px;
            border-bottom: 2px solid #d32f2f;
            padding-bottom: 10px;
            width: fit-content;
            margin-left: auto;
            margin-right: auto;
        }
        form {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 15px;
            padding: 15px;
            margin-bottom: 20px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        input[type=text], input[type=number], input[type=file] {
            padding: 10px;
            width: 200px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            color: #333;
            outline: none;
        }
        input[type=text]:focus, input[type=number]:focus {
            border-color: #d32f2f;
        }
        button {
            padding: 10px 20px;
            background-color: #d32f2f;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #b71c1c;
        }
        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }
        th, td {
            padding: 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #d32f2f;
            color: #fff;
            font-size: 16px;
            text-transform: uppercase;
        }
        tr:hover {
            background-color: #fbe9e7;
        }
        tr:last-child td {
            border-bottom: none;
        }
        a {
            text-decoration: none;
            color: #d32f2f;
            font-weight: bold;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>";
}



// Panel administracyjny
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    if ($action === 'add_category') {
        addCategory($conn, $_POST['name'], $_POST['parent_id']);
    } elseif ($action === 'delete_category') {
        deleteCategory($conn, $_POST['id']);
    } elseif ($action === 'edit_category') {
        editCategory($conn, $_POST['id'], $_POST['name'], $_POST['parent_id']);
    } elseif ($action === 'add_product') {
        addProduct($conn, $_POST['title'], $_POST['description'], $_POST['price_net'], $_POST['vat'], $_POST['stock'], $_POST['category_id'], $_POST['image']);
    } elseif ($action === 'delete_product') {
        deleteProduct($conn, $_POST['id']);
    } elseif ($action === 'edit_product') {
        editProduct($conn, $_POST['id'], $_POST['title'], $_POST['description'], $_POST['price_net'], $_POST['vat'], $_POST['stock'], $_POST['category_id'], $_POST['image']);
    }
}

// Wyświetlanie panelu
addStyles();
echo "<h1>Panel Administracyjny</h1>";

// Kategorie
echo "<h2>Zarządzanie kategoriami</h2>";
$categories = fetchCategories($conn);
echo "<form method='post'><input type='hidden' name='action' value='add_category'>
      Nazwa: <input type='text' name='name'> Matka: <input type='number' name='parent_id'>
      <button type='submit'>Dodaj kategorię</button></form>";
echo "<table><tr><th>ID</th><th>Nazwa</th><th>Matka</th><th>Akcje</th></tr>";
while ($category = $categories->fetch_assoc()) {
    echo "<tr>
          <td>{$category['id']}</td>
          <td><form method='post'><input type='text' name='name' value='{$category['name']}'></td>
          <td><input type='number' name='parent_id' value='{$category['parent_id']}'></td>
          <td>
              <input type='hidden' name='id' value='{$category['id']}'>
              <button type='submit' name='action' value='edit_category'>Edytuj</button>
              <button type='submit' name='action' value='delete_category'>Usuń</button>
          </form></td>
          </tr>";
}
echo "</table>";

// Produkty
echo "<h2>Zarządzanie produktami</h2>";
$products = fetchProducts($conn);
echo "<form method='post'><input type='hidden' name='action' value='add_product'>
      Tytuł: <input type='text' name='title'> Opis: <input type='text' name='description'> Cena netto: <input type='number' step='0.01' name='price_net'>
      VAT: <input type='number' step='0.01' name='vat'> Stan: <input type='number' name='stock'> Kategoria: <input type='number' name='category_id'>
      Obraz: <input type='text' name='image'> <button type='submit'>Dodaj produkt</button></form>";
echo "<table><tr><th>ID</th><th>Tytuł</th><th>Opis</th><th>Cena Netto</th><th>VAT</th><th>Stan</th><th>Kategoria</th><th>Obraz</th><th>Akcje</th></tr>";
while ($product = $products->fetch_assoc()) {
    echo "<tr>
          <td>{$product['id']}</td>
          <td><form method='post'><input type='text' name='title' value='{$product['title']}'></td>
          <td><input type='text' name='description' value='{$product['description']}'></td>
          <td><input type='number' step='0.01' name='price_net' value='{$product['price_net']}'></td>
          <td><input type='number' step='0.01' name='vat' value='{$product['vat']}'></td>
          <td><input type='number' name='stock' value='{$product['stock']}'></td>
          <td><input type='number' name='category_id' value='{$product['category_id']}'></td>
          <td><input type='text' name='image' value='{$product['image']}'></td>
          <td>
              <input type='hidden' name='id' value='{$product['id']}'>
              <button type='submit' name='action' value='edit_product'>Edytuj</button>
              <button type='submit' name='action' value='delete_product'>Usuń</button>
          </form></td>
          </tr>";
}
echo "</table>";

// Podstrony
echo "<h2>Zarządzanie podstronami</h2>";
$pages = fetchsubpages($conn);
echo "<form method='post'><input type='hidden' name='action' value='add_page'>
      Tytuł: <input type='text' name='title'> Plik: <input type='text' name='filename'>
      <button type='submit'>Dodaj podstronę</button></form>";
echo "<table><tr><th>ID</th><th>Tytuł</th><th>Plik</th><th>Akcje</th></tr>";
while ($subpage = $pages->fetch_assoc()) {
    echo "<tr>
        <td>{$subpage['id']}</td>
        <td><form method='post'><input type='text' name='title' value='{$subpage['title']}'></td>
        <td><input type='text' name='filename' value='{$subpage['filename']}'></td>
        <td>
            <input type='hidden' name='id' value='{$subpage['id']}'>
            <button type='submit' name='action' value='edit_subpage'>Edytuj</button>
            <button type='submit' name='action' value='delete_subpage'>Usuń</button>
        </form></td>
    </tr>";
}
echo "</table>";

$conn->close();
?>
