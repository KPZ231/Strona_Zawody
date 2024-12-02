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
        <form action="create_user.php" method="post"><label for="login">Login: </label>
          <br />
          <input type="text" id="login" placeholder="Login..." name="login" oninput="checkPassword()"/>
          <br />
          <br />
          <label for="password">Hasło: </label>
          <br />
          <input type="password" id="password" placeholder="Hasło..." required name="passsword" oninput="checkPassword()" />
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

    <?php

    include('./include/conn.php');


    if (isset($_POST['submit'])) {
      $login = $_POST['login'];
      $password = $_POST['password'];

      // Sprawdzanie, czy użytkownik o takim loginie już istnieje
      $search = mysqli_query($conn, "SELECT _login FROM uzytkownicy_administracyjni WHERE _login = '$login'");
      if (mysqli_fetch_row($search) == NULL) {
        // Jeśli nie istnieje, tworzymy hasz
        $hash = password_hash($password, PASSWORD_BCRYPT);

        // Dodawanie nowego użytkownika do bazy
        $queryText = "INSERT INTO uzytkownicy_administracyjni(_login, _password) VALUES('$login', '$hash')";
        $query = mysqli_query($conn, $queryText);
      } else {
        echo "Uzytkownik w bazie o takim loginie juz istnieje";
      }
    }
    ?>

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


  </body>

  </html>