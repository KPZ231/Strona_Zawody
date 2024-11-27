require('dotenv').config();
const mysql = require('mysql2');

// Konfiguracja połączenia z serwerem MySQL na Home.pl
const connection = mysql.createConnection({
    host: 'serwer1704623.home.pl', // Adres serwera
    user: '25262152_duda',         // Nazwa użytkownika
    password: process.env.DB_PASSWORD, // Hasło (trzymaj w pliku .env)
    database: '25262152_duda',     // Nazwa bazy danych
    port: 3301                    // Port MySQL (sprawdź, czy 3306 jest prawidłowy)
});

// Testowanie połączenia
connection.connect((err) => {
    if (err) {
        console.error('Błąd połączenia z bazą danych:', err.message);
        return;
    }
    console.log('Połączono z bazą danych na Home.pl!');
});

// Eksport połączenia
module.exports = connection;
