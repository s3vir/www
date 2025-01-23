<?php
// Włączanie wyświetlania błędów dla debugowania
error_reporting(E_ALL);
ini_set('display_errors', 1);

/**
 * Funkcja wyświetlająca formularz kontaktowy
 */
function PokazKontakt() {
    echo '<h2>Skontaktuj się z nami</h2>
    <form action="index.php?idp=contact" method="post">
        <label for="name">Imię:</label><br>
        <input type="text" id="name" name="name"><br>
        
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br>
        
        <label for="subject">Temat:</label><br>
        <input type="text" id="subject" name="subject"><br>
        
        <label for="message">Wiadomość:</label><br>
        <textarea id="message" name="message"></textarea><br>
        
        <input type="submit" name="sendMail" value="Wyślij">
        <input type="submit" name="remindPassword" value="Przypomnij hasło">
    </form>';
}

/**
 * Funkcja wysyłająca wiadomość e-mail z formularza
 */
function WyslijMailKontakt() {
    $name = htmlspecialchars($_POST['name'] ?? '');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $subject = htmlspecialchars($_POST['subject'] ?? '');
    $message = htmlspecialchars($_POST['message'] ?? '');

    // Walidacja danych dla wysyłania wiadomości
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        echo "<p>Wszystkie pola formularza są wymagane do wysłania wiadomości.</p>";
        return;
    }

    // Konfiguracja maila
    $to = "bartektidal2137@gmail.com"; // Twój adres e-mail
    $fullMessage = "Od: $name\nEmail: $email\nTemat: $subject\n\nWiadomość:\n$message";
    $headers = "From: test@example.com\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    if (mail($to, $subject, $fullMessage, $headers)) {
        echo "<p>Wiadomość została wysłana pomyślnie!</p>";
    } else {
        echo "<p>Błąd wysyłania wiadomości. Spróbuj ponownie później.</p>";
    }
}

/**
 * Funkcja wysyłająca przypomnienie hasła
 */
function PrzypomnijHaslo() {
    $email = htmlspecialchars($_POST['email'] ?? '');

    // Walidacja e-maila
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<p>Proszę podać poprawny adres e-mail.</p>";
        return;
    }

    $subject = "Przypomnienie hasła";
    $message = "Twoje hasło do panelu to: admin123"; // Przykładowe hasło
    $headers = "From: bartektidal2137@gmail.com\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

    if (mail($email, $subject, $message, $headers)) {
        echo "<p>Hasło zostało wysłane na adres: $email</p>";
    } else {
        echo "<p>Błąd wysyłania przypomnienia hasła. Spróbuj ponownie później.</p>";
    }
}

// Obsługa formularza
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['sendMail'])) {
        WyslijMailKontakt();
    } elseif (isset($_POST['remindPassword'])) {
        PrzypomnijHaslo();
    }
} else {
    PokazKontakt();
}
?>
