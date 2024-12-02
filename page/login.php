<!DOCTYPE html>
<html lang="pl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="./style/style.css">
  <title>Logowanie</title>
</head>

<body>

  <div class="loginPanel">
    <h1 id="h1">Logowanie</h1>
    <label for="h1">
      <hr>
    </label>
    <br>

    <form action="login.php" method="POST">
      <label for="login">Login: </label>
      <input type="text" required placeholder="Login..." id="login" name="login">

      <br>
      <br>

      <label for="password">Hasło: </label>
      <input type="password" required placeholder="Hasło..." id="password" name="password">
      <br>
      <label for="password"><input type="checkbox" onclick="myFunction()"> Pokaż Hasło</label>

      <br>
      <br>

      <label for="file">Prześlij Certyfikat</label>
      <input type="file" name="file" id="File" name="file">

      <br>
      <br>

      <input type="submit" value="Zaloguj" name="submit">
    </form>

    <?php
    session_start();
    include('./include/conn.php');

    function Login($login)
    {
      $_SESSION['isLogged'] = true;
      $_SESSION['logedAs'] = $login;
    }

    if (isset($_POST['submit'])) {
      $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_STRING);
      $password = $_POST['password'];

      // Prepare statement
      $stmt = $conn->prepare("SELECT _password FROM uzytkowicy_administracyjni WHERE _login = ?");
      $stmt->bind_param("s", $login);
      $stmt->execute();
      $result = $stmt->get_result();

      // Check if user exists and verify password
      $row = $result->fetch_assoc();
      if ($row && password_verify($password, $row['_password'])) {
        Login($login);
      } else {
        echo "Dane Logowania Są Niepoprawne";
      }

      $stmt->close();
    }
    ?>

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
  </div>

</body>

</html>