require('dotenv').config();
const mysql = require('mysql2');

// server.js
const connection = mysql.createConnection({
  host: 'serwer1704623.home.pl',
  user: '25262152_duda',
  password: process.env.DB_PASSWORD,
  database: '25262152_duda',
  port: 3380
});

// Test connection
connection.connect((err) => {
  if (err) {
    console.error('Błąd połączenia z bazą danych:', err.message);
    return;
  }
  console.log('Połączono z bazą danych na Home.pl!');
});

module.exports = {connection};
