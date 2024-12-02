<?php
session_start();
include './include/conn.php';

// Załaduj plik .env i wczytaj zmienne środowiskowe
require_once './vendor/autoload.php';
use Dotenv\Dotenv;

// Wczytaj zmienne z pliku .env
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();
$secretKey = $_ENV['SECRETKEY']; // Pobierz SECRETKEY z pliku .env

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $login = $_POST['login'];
    $password = $_POST['password'];

    if (empty($login) || empty($password)) {
        die('Login i hasło nie mogą być puste.');
    }

    // Sprawdzenie pliku klucz.sh
    if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
        // Wczytanie zawartości pliku
        $fileContent = file_get_contents($_FILES['file']['tmp_name']);

        // Sprawdzanie, czy zawartość pliku zgadza się z SECRETKEY
        if (trim($fileContent) !== $secretKey) {
            echo '<p style="text-align:center;">Nieprawidłowy klucz w pliku.</p>';
            die();
        }
    } else {
        echo '<p style="text-align:center;">Plik klucz.sh nie został przesłany.</p>';
        die();
    }

    // Pobranie użytkownika z bazy danych
    $query = $conn->prepare("SELECT _password FROM uzytkownicy_administracyjni WHERE _login = ?");
    $query->bind_param('s', $login);
    $query->execute();
    $query->bind_result($hashedPassword);

    if ($query->fetch()) {
        // Weryfikacja hasła
        if (password_verify($password, $hashedPassword)) {
            // Zapisz sesję
            $_SESSION['user_role'] = "admin";
            echo '<p style="text-align:center;">Zalogowano pomyślnie</p>';
            header('Location: adminpanel.php'); // Przekierowanie po zalogowaniu
            exit();
        } else {
            echo '<p style="text-align:center;">Nieprawidłowe hasło</p>';
        }
    } else {
        echo '<p style="text-align:center;">Użytkownik nie istnieje</p>';
    }

    $query->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./assets/style/style.css">
  <title>Logowanie</title>
</head>

<body style="color:white">

  <div class="userCreation">
    <h1>Logowanie</h1>
    <hr />
    <br />
    <div class="credentials">
      <form action="login.php" method="post" enctype="multipart/form-data">
        <label for="login">Login: </label>
        <br />
        <input type="text" id="login" placeholder="Login..." name="login" />
        <br />
        <br />
        <label for="password">Hasło: </label>
        <br />
        <input type="password" id="password" placeholder="Hasło..." name="password" required />
        <input type="checkbox" onclick="myFunction()"> Pokaż Hasło
        <br>
        <p id="error_text"></p>
        <br>
        <br>
        <label class="file">
          <input type="file" id="file" name="file" aria-label="Prześlij Certyfikat" required>
          <span class="file-custom"></span>
        </label>
        <br />
        <br>
        <br>
        <input type="submit" name="submit" id="submit" value="Zaloguj">
      </form>
    </div>
  </div>

  <script>
    function myFunction() {
      var x = document.getElementById("password");
      if (x.type === "password") {
        x.type = "text";
      } else {
        x.type = "password";
      }
    }
  </script>
</body>

</html>
