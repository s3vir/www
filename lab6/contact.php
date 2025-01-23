<?php
function PokazKontakt() {
    echo '
    <form method="POST" action="contact.php?action=send">
        <label for="email">Twój e-mail:</label><br>
        <input type="email" name="email" id="email" required><br><br>
        <label for="message">Wiadomość:</label><br>
        <textarea name="message" id="message" rows="5" required></textarea><br><br>
        <input type="submit" value="Wyślij">
    </form>';
}

function WyslijMailKontakt() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $to = "admin@example.com"; // Zmień na swój adres e-mail
        $subject = "Wiadomość kontaktowa";
        $message = htmlspecialchars($_POST['message']);
        $headers = "From: " . htmlspecialchars($_POST['email']) . "\r\n";

        if (mail($to, $subject, $message, $headers)) {
            echo "Wiadomość została wysłana.";
        } else {
            echo "Wystąpił błąd podczas wysyłania wiadomości.";
        }
    }
}

function PrzypomnijHaslo() {
    $to = "admin@example.com"; // Zmień na swój adres e-mail
    $subject = "Przypomnienie hasła";
    $message = "Twoje hasło do panelu admina to: 12345"; // Hasło można pobierać dynamicznie
    $headers = "From: no-reply@example.com\r\n";

    if (mail($to, $subject, $message, $headers)) {
        echo "Hasło zostało wysłane na Twój adres e-mail.";
    } else {
        echo "Wystąpił błąd podczas wysyłania przypomnienia hasła.";
    }
}


if (isset($_GET['action']) && $_GET['action'] === 'send') {
    WyslijMailKontakt();
} elseif (isset($_GET['action']) && $_GET['action'] === 'remind') {
    PrzypomnijHaslo();
} else {
    PokazKontakt();
}
?>
