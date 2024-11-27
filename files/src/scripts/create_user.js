const conn = require('./login_backend'); // Import połączenia z login_backend.js
const bcrypt = require('bcrypt');

// Zapytanie do bazy o użytkowników
const query = 'SELECT _id, _password FROM uzytkownicy_administracyjni';
conn.query(query, async (err, results) => {
    if (err) {
        console.error('Błąd zapytania:', err);
        return;
    }

    for (const user of results) {
        try {
            // Hashowanie hasła
            const hashedPassword = await bcrypt.hash(user._password, 10);
            const updateQuery = 'UPDATE uzytkownicy_administracyjni SET _password = ? WHERE _id = ?';

            // Aktualizacja hasła w bazie
            conn.query(updateQuery, [hashedPassword, user._id], (updateErr) => {
                if (updateErr) {
                    console.error(`Błąd aktualizacji hasła dla użytkownika ${user._id}:`, updateErr);
                }
            });
        } catch (hashErr) {
            console.error(`Błąd podczas hashowania hasła dla użytkownika ${user._id}:`, hashErr);
        }
    }

    console.log('Hasła zostały zaszyfrowane.');
    conn.end(); // Zamknięcie połączenia po wykonaniu
});
