<?php

include('./include/conn.php'); // Poprawiona składnia z dodanym średnikiem

?>

<!DOCTYPE html>

<!-- Importowanie Czcionek -->
<style>
  @import url("https://fonts.googleapis.com/css2?family=Istok+Web:ital,wght@0,400;0,700;1,400;1,700&family=PT+Sans+Narrow&family=Quicksand:wght@300..700&family=Roboto+Condensed:ital,wght@0,100..900;1,100..900&display=swap");
</style>

<html lang="pl">

<head>
  <!-- Metadane strony -->
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="description" content="Strona Poświęcona Tabelą Sportowym Dla Szkół" />
  <meta name="author" content="KPZsProductions" />

  <!-- CSS -->
  <link rel="stylesheet" href="./assets/style/style.css" />
  <link rel="stylesheet" href="./assets/scss/table.css">

  <title>Zawody Sportowe - ZSCL</title>
</head>

<body>
  <!-- Baner Z Nagłowkiem -->
  <div class="baner">
    <h1>NAZWA SZKOŁY: TYP SZKOŁY</h1>
  </div>

  <!-- Breaki zeby dodac troche miejsca nie chce mi sie bawic w CSSa ;> -->
  <br />
  <br />
  <br />

  <?php
  // Zapytanie, by sprawdzić, czy którykolwiek zespół przegrał
  $sql = 'SELECT _czyKtosPrzegral FROM tabela_ogolna';

  if ($res = mysqli_query($conn, $sql)) {
    if ($row = mysqli_fetch_row($res)) {
      if ($row[0] == 0) {
        $teams = "SELECT _klasa FROM druzyna";

        echo '
            <h2 style="text-align: center">Tabela Zespołów</h2>
            <div class="tournament-container">
              <div class="tournament-headers">
                <h3>1/8 Rozgrywek</h3>
                <h3>Ćwierćfinał</h3>
                <h3>Półfinał</h3>
                <h3>Final</h3>
                <h3>Zwycięsca</h3>
              </div>

              <div class="tournament-brackets">
                <ul class="bracket bracket-1">';

        if ($result = mysqli_query($conn, $teams)) {
          while ($teamsRow = mysqli_fetch_row($result)) {
            echo '<li class="team-item">' . htmlspecialchars($teamsRow[0]) . '</li>';
          }
          mysqli_free_result($result);
        } else {
          echo "Error in executing the teams query: " . mysqli_error($conn);
        }

        echo '
                </ul>
              </div>
            </div>';
      } else {
        echo '
          <!-- Tabela Wygranych -->
            <h2 style="text-align: center">Tabela Wygranych</h2>
  
            <!-- Rozpoczęcie -->
            <div class="tournament-container">
              <div class="tournament-headers">
                <h3>1/8 Rozgrywek</h3>
                <h3>Ćwierćfinał</h3>
                <h3>Półfinał</h3>
                <h3>Final</h3>
                <h3>Zwycięzca</h3>
              </div>
  
              <div class="tournament-brackets">
                <ul class="bracket bracket-1">';

        // Zapytanie SQL dla 1 miejsca
        $sql = "SELECT _id, _klasa, _miejsce, _tabela FROM druzyna WHERE _miejsce = 1 OR _miejsce = 2 OR _miejsce = 3 AND _tabela = 'wygrana'";
        if($result = mysqli_query($conn, $sql)){
          while($row = mysqli_fetch_row($result)){
            echo "<li class='team-item'>" . htmlspecialchars($row[1]) . "</li>";
          }
        }

        echo ' </ul>
                <ul class="bracket bracket-2">';

        // Zapytanie SQL dla 2 miejsca
        $sql = "SELECT _id, _klasa, _miejsce, _tabela FROM druzyna WHERE _miejsce = 2 OR _miejsce = 3 AND _tabela = 'wygrana'";
        if($result = mysqli_query($conn, $sql)){
          while($row = mysqli_fetch_row($result)){
            echo "<li class='team-item'>" . htmlspecialchars($row[1]) . "</li>";
          }
        }

        echo ' </ul>
                <ul class="bracket bracket-3">';

        // Zapytanie SQL dla 3 miejsca
        $sql = "SELECT _id, _klasa, _miejsce, _tabela FROM druzyna WHERE _miejsce = 3 OR _miejsce = 4 AND _tabela = 'wygrana'";
        if($result = mysqli_query($conn, $sql)){
          while($row = mysqli_fetch_row($result)){
            echo "<li class='team-item'>" . htmlspecialchars($row[1]) . "</li>";
          }
        }

        echo ' </ul>
                <ul class="bracket bracket-4">';

        // Zapytanie SQL dla 4 miejsca
        $sql = "SELECT _id, _klasa, _miejsce, _tabela FROM druzyna WHERE _miejsce = 4 OR _miejsce = 5 AND _tabela = 'wygrana'";
        if($result = mysqli_query($conn, $sql)){
          while($row = mysqli_fetch_row($result)){
            echo "<li class='team-item'>" . htmlspecialchars($row[1]) . "</li>";
          }
        }

        echo ' </ul>
                <ul class="bracket bracket-5">';

        // Zapytanie SQL dla 5 miejsca
        $sql = "SELECT _id, _klasa, _miejsce, _tabela FROM druzyna WHERE _miejsce = 5 AND _tabela = 'wygrana'";
        if($result = mysqli_query($conn, $sql)){
          while($row = mysqli_fetch_row($result)){
            echo "<li class='team-item'>" . htmlspecialchars($row[1]) . "</li>";
          }
        }

        echo ' </ul>
              </div>
            </div>';
      }
    }
  } 

  ?>

  <!-- Stopka strony -->
  <footer>
    <br />
    <br />
    <p>TEKST STOPKI</p>
  </footer>
</body>

</html>
