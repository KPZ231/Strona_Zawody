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
    <link rel="stylesheet" href="./style/style.css"/>
    <title>Tworzenie Uzytkownika</title>
  </head>

  <body>
    <div class="userCreation">
      <h1>Tworzenie Uzytkownika</h1>
      <hr />
      <br />
      <div class="credentials">
        <form action="create_user.php" method="post"><label for="login">Login: </label>
          <br />
          <input type="text" id="login" placeholder="Login..." name="login" />
          <br />
          <br />
          <label for="password">Hasło: </label>
          <br />
          <input type="password" id="password" placeholder="Hasło..." required name="passsword" />
          <input type="checkbox" onclick="myFunction()"> Pokaż Hasło
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