<?php
// Ustawienia bazy danych
include '../cfg.php';

// Funkcja sprawdzająca login
function verifyLogin($username, $password, $conn) {
    $stmt = $conn->prepare("SELECT * FROM admin_users WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $stmt->close();
    return $result->num_rows > 0;
}

// Funkcja resetowania hasła
function sendPasswordResetEmail($email, $conn) {
    $stmt = $conn->prepare("SELECT password FROM admin_users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $password = $row['password'];

        $to = $email;
        $subject = "Resetowanie hasła - Panel Administracyjny";
        $message = "Twoje hasło to: " . $password;
        $headers = "From: no-reply@mojprojekt.pl\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        if (mail($to, $subject, $message, $headers)) {
            return "Hasło zostało wysłane na podany adres email.";
        } else {
            return "Nie udało się wysłać wiadomości e-mail.";
        }
    } else {
        return "Błąd autoryzacji: Podany adres email nie istnieje w bazie danych.";
    }
}

// Obsługa formularza logowania
$conn_status = "<p style='color: green;'>Połączenie z bazą danych nawiązane pomyślnie!</p>";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        $conn_status = "<p style='color: red;'>Błąd połączenia z bazą danych: " . $conn->connect_error . "</p>";
    } else {
        if (isset($_POST['reset_email'])) {
            $reset_email = $_POST['reset_email'];
            $reset_message = sendPasswordResetEmail($reset_email, $conn);
        } else {
            $username = $_POST['username'];
            $password = $_POST['password'];

            if (verifyLogin($username, $password, $conn)) {
                session_start();
                $_SESSION['logged_in'] = true;
                header("Location: admin_dashboard.php");
                exit;
            } else {
                $login_error = "Niepoprawna nazwa użytkownika lub hasło.";
            }
        }
        $conn->close();
    }
}
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logowanie - Panel Administracyjny</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .login-container {
            background-color: #ffffff;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 300px;
            margin-bottom: 20px;
        }
        .login-container h1 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 24px;
            color: #343a40;
        }
        .login-container form {
            display: flex;
            flex-direction: column;
        }
        .login-container input[type="text"],
        .login-container input[type="password"],
        .login-container input[type="email"] {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            outline: none;
        }
        .login-container button {
            padding: 10px;
            background-color: #007bff;
            color: #ffffff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .login-container button:hover {
            background-color: #0056b3;
        }
        .login-container .error {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
        .connection-status {
            text-align: center;
            margin-bottom: 20px;
            font-size: 14px;
        }
        .reset-message {
            text-align: center;
            color: green;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="connection-status">
        <?php if (isset($conn_status)) { echo $conn_status; } ?>
    </div>
    <div class="login-container">
        <h1>Logowanie</h1>
        <?php if (isset($login_error)) { echo "<p class='error'>$login_error</p>"; } ?>
        <?php if (isset($reset_message)) { echo "<p class='reset-message'>$reset_message</p>"; } ?>
        <form method="post">
            <input type="text" name="username" placeholder="Nazwa użytkownika" required>
            <input type="password" name="password" placeholder="Hasło" required>
            <button type="submit">Zaloguj się</button>
        </form>
        <form method="post">
            <h1>Resetowanie hasła</h1>
            <input type="email" name="reset_email" placeholder="Adres email" required>
            <button type="submit">Resetuj hasło</button>
        </form>
    </div>
</body>
</html>
