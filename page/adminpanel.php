<?php
include './include/check.php'; // Sprawdzenie, czy użytkownik jest zalogowany i ma odpowiednią rolę
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/style/style.css">
    <title>Panel Administracyjny</title>
</head>

<body>
    <div class="baner">
        <h1 style="text-align: center;">Panel Administracyjny</h1>
        <hr>
    </div>

    <div class="adminpanel_glowny">
        <h2>Co Chesz Zrobic?</h2>

        <br><br>
        <button onclick="sendToPage('adminpanel_createnew.php')">Stworz Nową Rozgrywkę</button>
        <button onclick="sendToPage('adminpanel_modify.php')">Zaakutalizuj Rozgrywkę</button>
    </div>
    
    <script>

        function sendToPage(location){
            window.location.assign(location);
        }
    </script>

</body>

</html>