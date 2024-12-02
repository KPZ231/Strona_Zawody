  <style>
    @import url("https://fonts.googleapis.com/css2?family=Istok+Web:ital,wght@0,400;0,700;1,400;1,700&family=PT+Sans+Narrow&family=Quicksand:wght@300..700&family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap");

    *,
    *:before,
    *:after {
      -webkit-box-sizing: border-box;
      -moz-box-sizing: border-box;
      box-sizing: border-box;
    }
  </style>

  <html lang="pl">

  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./assets/style/style.css" />
    <title>Tworzenie Uzytkownika</title>
  </head>

  <body onload="checkPassword()">
    <div class="userCreation">
      <h1>Tworzenie Uzytkownika</h1>
      <hr />
      <br />
      <div class="credentials">
        <form action="create_user.php" method="post">
          <label for="login">Login: </label>
          <br />
          <input type="text" id="login" placeholder="Login..." name="login" oninput="checkPassword()" />
          <br />
          <br />
          <label for="password">Hasło: </label>
          <br />
          <input type="password" id="password" placeholder="Hasło..." name="password" required oninput="checkPassword()" />
          <input type="checkbox" onclick="myFunction()"> Pokaż Hasło
          <br>
          <p id="error_text"></p>
          <br>
          <br>
          <label class="file">
            <input type="file" id="file" name="file" aria-label="Przeslij Certifikat">
            <span class="file-custom"></span>
          </label>
          <br />
          <br>
          <p id="info"></p>
          <br>
          <input type="submit" name="submit" id="submit" value="Zarejstruj">


      </div>
    </div>

    <script>
      // Pobieranie elementów z DOM
      let error_text = document.getElementById("error_text");
      let submit = document.getElementById("submit");

      // Funkcja sprawdzająca login i hasło
      function checkPassword() {
        let login = document.getElementById("login").value; // Pobieramy aktualną wartość loginu
        let password = document.getElementById("password").value; // Pobieramy aktualną wartość hasła

        // Sprawdzamy, czy login i hasło nie są puste
        if (login === "") {
          error_text.innerText = "Login nie może być pusty.";
          submit.setAttribute('disabled', 'true'); // Wyłączamy przycisk
          return; // Kończymy funkcję, jeśli login jest pusty
        }

        // Sprawdzamy, czy hasło nie jest puste
        if (password === "") {
          error_text.innerText = "Hasło nie może być puste.";
          submit.setAttribute('disabled', 'true'); // Wyłączamy przycisk
          return; // Kończymy funkcję, jeśli hasło jest puste
        }

        // Sprawdzamy, czy hasło ma więcej niż 8 znaków
        if (password.length < 8) {
          error_text.innerText = "Hasło musi mieć więcej niż 8 znaków.";
          submit.setAttribute('disabled', 'true'); // Wyłączamy przycisk
        } else {
          error_text.innerText = ""; // Usuwamy komunikat błędu
          submit.removeAttribute('disabled'); // Włączamy przycisk
        }
      }

      // Funkcja do pokazywania/ukrywania hasła
      function myFunction() {
        var x = document.getElementById("password");
        if (x.type === "password") {
          x.type = "text"; // Pokaż hasło
        } else {
          x.type = "password"; // Ukryj hasło
        }
      }
    </script>


    <?php
    include './include/conn.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
      $login = $_POST['login'];
      $password = $_POST['password'];

      // Sprawdzenie, czy użytkownik o podanym loginie już istnieje
      $query = $conn->prepare("SELECT COUNT(*) FROM uzytkownicy_administracyjni WHERE _login = ?");
      $query->bind_param('s', $login);
      $query->execute();
      $query->bind_result($count);
      $query->fetch();
      $query->close();

      if ($count > 0) {
        die('Użytkownik o takim loginie już istnieje.');
      }

      // Hashowanie hasła
      $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

      // Dodanie użytkownika do bazy danych
      $insert = $conn->prepare("INSERT INTO uzytkownicy_administracyjni (_login, _password) VALUES (?, ?)");
      $insert->bind_param('ss', $login, $hashedPassword);
      if ($insert->execute()) {
        echo '<p style="text-align:center;">Rejstracja Zakończona Sukcesem</p>';
      } else {
        echo '<p style="text-align:center;">Wystąpił Błąd</p>';
      }
      $insert->close();
    }

    $conn->close();
    ?>







  </body>

  </html>