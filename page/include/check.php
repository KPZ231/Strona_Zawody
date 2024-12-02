<?php
session_start();

// Sprawdzenie, czy użytkownik jest zalogowany jako admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
  echo '<h1>Brak dostępu. Musisz być zalogowany jako administrator.</h1>';
  header('Location: login.php'); // Przekierowanie na stronę logowania, jeśli użytkownik nie jest zalogowany
  exit();
}
?>
