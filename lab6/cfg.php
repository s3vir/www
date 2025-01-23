<?php
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'moja_strona';

$conn = mysqli_connect($host, $user, $password, $database);

if (!$conn) {
    die("Błąd połączenia z bazą danych: " . mysqli_connect_error());
}
?>
