<?php
include './include/check.php'; // Sprawdzenie, czy użytkownik jest zalogowany i ma odpowiednią rolę
include './include/conn.php'; // Połączenie z bazą danych

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $errors = [];

    // Obsługa dodawania klasy
    if (!empty($_POST['klasa'])) {
        $klasa = trim($_POST['klasa']);
        $tabela = 'ogolna';
        if (strlen($klasa) > 0) {
            $stmt = $conn->prepare("INSERT INTO druzyna (_klasa, _tabela) VALUES (?, ?)");
            $stmt->bind_param("ss", $klasa, $tabela);
            if ($stmt->execute()) {
                echo "<p>Dodano klasę: $klasa</p>";
            } else {
                $errors[] = "Błąd podczas dodawania klasy: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $errors[] = "Pole klasy nie może być puste.";
        }
    }

    // Obsługa dodawania zawodów
    if (!empty($_POST['forma']) && !empty($_POST['sport']) && !empty($_POST['nazwa'])) {
        $forma = trim($_POST['forma']);
        $nazwa = trim($_POST['nazwa']);
        $sport = trim($_POST['sport']);
        if (strlen($forma) > 0 && strlen($sport) > 0) {
            $stmt = $conn->prepare("INSERT INTO zawody (_metoda_tabeli, _sport, _nazwa) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $forma, $sport, $nazwa);
            if ($stmt->execute()) {
                echo "<p>Dodano zawody: Forma - $forma, Sport - $sport</p>";
            } else {
                $errors[] = "Błąd podczas dodawania zawodów: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $errors[] = "Pole forma i sport nie mogą być puste.";
        }
    }

    // Wyświetlanie błędów
    if (!empty($errors)) {
        foreach ($errors as $error) {
            echo "<p style='color:red;'>$error</p>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/style/style.css">
    <title>Panel Administracyjny - Tworzenie Rozgrywek</title>
</head>

<body>
<div class="baner">
    <h1>Panel Administracyjny - Tworzenie Rozgrywek</h1>
    <hr>
</div>

<div class="tworzenieRozgrywekContainer">
    <form action="adminpanel_createnew.php" method="post">

        <label for="forma">W jakiej formie będą organizowane zawody?</label>
        <input type="text" name="forma" id="forma" placeholder="brazyliskiej">

        <label for="nazwa">Nazwa Zawodów?</label>
        <input type="text" name="nazwa" id="nazwa" placeholder="Nazwa zawodów..">

        <label for="sport">Z czego będą odbywać się zawody?</label>
        <select name="sport" id="sport">
            <option value="siatkowka">Siatkówka</option>
            <option value="halowka">Piłka Nożna - Halowa</option>
            <option value="boiskowa">Piłka Nożna - Na Boisku</option>
            <option value="reczna">Piłka Ręczna</option>
        </select>

        <label for="klasa">Dodaj klasę: </label>
        <input type="text" name="klasa" id="klasa" placeholder="Klasa...">
        <input type="submit" value="Dodaj Klase" name="dodajKlase">

        <br>
        <h3>Klasy</h3>
        <div id="klasy" name="klasy" class="klasy">
            <?php
            // Wyświetlenie dodanych klas z bazy danych
            $result = $conn->query("SELECT _klasa FROM druzyna");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<p>" . htmlspecialchars($row['_klasa']) . "</p>";
                }
            }
            ?>
        </div>

        <br>
        <input type="submit" value="Zatwierdź" name="submit">

    </form>
</div>
</body>
</html>
