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