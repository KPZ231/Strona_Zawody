<?php
include './include/check.php'; // Sprawdzenie, czy użytkownik jest zalogowany i ma odpowiednią rolę
include './include/conn.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/style/style.css">

    <title>Panel Administracyjny - Modyfikacja Rozgrywek</title>
</head>

<body>
    <div class="baner">
        <h1>Panel Administracyjny - Modyfikacja Rozgrywek</h1>
        <hr>
    </div>
    <div class="tworzenieRozgrywekContainer">
        <form action="adminpanel_modify.php" method="post">

            <label for="zespol">Wybierz Zespol: </label>
            <select name="zespoly" id="zespoly">
                <?php
                $sql = 'SELECT _id, _klasa FROM druzyna';

                if ($result = mysqli_query($conn, $sql)) {
                    while ($row = mysqli_fetch_row($result)) {
                        echo "<option value=" . $row[0] . ">" . $row[1] . "</option>";
                    }
                }
                ?>

            </select>

            <label for="czyWygral">Czy Zespoł Wygrał? </label>
            <input type="submit" value="Wygrał" name="czyWygral">

            <label for="czyWygral">Przegrał?</label>
            <input type="submit" value="Przegrał" name="loss">

            <label for="czyWygral">Dyskwalifikacja</label>
            <input type="submit" value="Dyskwalifikacja" name="dyskfa">
            <br>
        </form>


        <?php
        if(!empty($_POST['zespoly'])){
            $selectedTeam = $_POST['zespoly'];
        }

        
        function Loss($selectedTeam)
        {
            global $conn; // Ensure the global $conn variable is used for the database connection
            
            // Sanitize the input to prevent SQL injection
            $selectedTeam = intval($selectedTeam);
        
            // Corrected SQL query
            $miejsceSQL = "SELECT _miejsce FROM druzyna WHERE _id = $selectedTeam";
            $result = mysqli_query($conn, $miejsceSQL);
        
            if ($result) {
                $row = mysqli_fetch_row($result);
                if ($row) {
                    $miejsce = $row[0];
        
                    $miejsce--;
        
                    $miejsce = intval($miejsce);
        
                    // Form the query string
                    $sql = "UPDATE `druzyna` SET `_miejsce` = $miejsce, `_tabela` = 'przegrana' WHERE `druzyna`.`_id` = $selectedTeam;";
        
                    // Execute the query
                    if (mysqli_query($conn, $sql)) {
                        echo "Team updated successfully!";
                    } else {
                        echo "Error updating team: " . mysqli_error($conn);
                    }
                } else {
                    echo "No team found with the given ID.";
                }
            } else {
                echo "Error fetching team: " . mysqli_error($conn);
            }
        }
        
        function Win($selectedTeam)
        {
            global $conn; // Make sure to use the global $conn variable for the database connection

            // Sanitize the input to prevent SQL injection
            $selectedTeam = intval($selectedTeam);

            // Corrected SQL query
            $miejsceSQL = "SELECT _miejsce FROM druzyna WHERE _id = $selectedTeam";
            $result = mysqli_query($conn, $miejsceSQL);
        
            if ($result) {
                $row = mysqli_fetch_row($result);
                if ($row) {
                    $miejsce = $row[0];
        
                    $miejsce++;
        
                    $miejsce = intval($miejsce);
        
                    // Form the query string
                    $sql = "UPDATE `druzyna` SET `_miejsce` = $miejsce, `_tabela` = 'wygrana' WHERE `druzyna`.`_id` = $selectedTeam;";
        
                    // Execute the query
                    if (mysqli_query($conn, $sql)) {
                        echo "Team updated successfully!";
                    } else {
                        echo "Error updating team: " . mysqli_error($conn);
                    }
                } else {
                    echo "No team found with the given ID.";
                }
            } else {
                echo "Error fetching team: " . mysqli_error($conn);
            }
        }
        

        function Disqualify($selectedTeam) {
            global $conn; // Make sure to use the global $conn variable for the database connection
        
            // Sanitize the input to prevent SQL injection
            $selectedTeam = intval($selectedTeam);
        
            // Form the query string
            $sql = "DELETE FROM druzyna WHERE `druzyna`.`_id` = $selectedTeam";
        
            // Execute the query
            if (mysqli_query($conn, $sql)) {
                echo "Team updated successfully!";
            } else {
                echo "Error updating team: " . mysqli_error($conn);
            }
        }
        
        if(isset($_POST['czyWygral'])){
            Win($selectedTeam);
        }

        if(isset($_POST['loss'])){
            Loss($selectedTeam);
        }

        if(isset($_POST['dyskfa'])){
            Disqualify($selectedTeam);
        }
        ?>
</body>

</html>