const express = require('express');
const path = require('path');
const mysql = require('mysql2');
const bcrypt = require('bcryptjs');
const bodyParser = require('body-parser');
const multer = require('multer');
const fs = require('fs');
require('dotenv').config();

const app = express();

// Middleware do parsowania JSON w requestach
app.use(bodyParser.json());

// Middleware do parsowania plików
const upload = multer({ dest: 'uploads/' }); // Miejsce przechowywania przesyłanych plików

// Połączenie z bazą danych MySQL
const connection = mysql.createConnection({
  host: 'serwer1704623.home.pl',
  user: '25262152_duda',
  password: process.env.DB_PASSWORD,
  database: '25262152_duda',
  port: 3380
});

// Testowanie połączenia
connection.connect((err) => {
  if (err) {
    console.error('Błąd połączenia z bazą danych:', err.message);
    return;
  }
  console.log('Połączono z bazą danych na Home.pl!');
});

// Endpoint do tworzenia użytkownika z plikiem
app.post('/create-user', upload.single('file'), (req, res) => {
  const { login, password } = req.body;
  const uploadedFile = req.file;

  // Sprawdzenie, czy plik został przesłany
  if (!uploadedFile) {
    return res.status(400).json({ message: 'Proszę przesłać plik.' });
  }

  // Odczytanie zawartości przesłanego pliku
  fs.readFile(uploadedFile.path, 'utf8', (err, data) => {
    if (err) {
      return res.status(500).json({ message: 'Błąd odczytu pliku.' });
    }

    // Porównanie zawartości pliku z wartością KEY w .env
    const keyFromEnv = process.env.KEY; // Wartość KEY z pliku .env

    // Sprawdzenie, czy zawartość pliku jest identyczna z wartością KEY w .env
    if (data.trim() === keyFromEnv) {
      // Jeśli plik jest poprawny, przejdź do rejestracji użytkownika

      // Haszowanie hasła
      const hashedPassword = bcrypt.hashSync(password, 10);

      // Wstawianie użytkownika do bazy danych
      connection.query(
        'INSERT INTO uzytkownicy_administracyjni (_login, _password) VALUES (?, ?)',
        [login, hashedPassword],
        (error, results) => {
          if (error) {
            console.error('Błąd zapytania:', error.stack);
            return res.status(500).json({ message: "Błąd tworzenia użytkownika" });
          }
          console.log('Użytkownik utworzony:', results);
          res.status(200).json({ message: "Użytkownik utworzony pomyślnie", userId: results.insertId });
        }
      );
    } else {
      // Jeśli plik nie pasuje do KEY, zwróć błąd
      return res.status(400).json({ message: 'Zawartość pliku nie pasuje do wymaganego klucza.' });
    }

    // Usuwanie przesłanego pliku po zakończeniu
    fs.unlinkSync(uploadedFile.path);
  });
});

// Ścieżka do statycznych plików (np. HTML, JS)
app.use(express.static(path.join(__dirname, 'public')));

// Uruchomienie serwera
const PORT = 3000;
app.listen(PORT, () => {
  console.log(`Serwer działa na http://localhost:${PORT}/`);
});
