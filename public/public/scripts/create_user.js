function createUser() {
  var info = document.getElementById("info");
  
  const userData = {
    login: document.getElementById("login").value,
    password: document.getElementById("password").value,
    file: document.getElementById("file").files[0] // Pobierz przesłany plik
  };

  // Sprawdź, czy plik jest obecny
  if (!userData.file) {
    alert("Proszę przesłać plik.");
    return;
  }

  // Przygotowanie form-data do wysłania pliku i danych użytkownika
  const formData = new FormData();
  formData.append('login', userData.login);
  formData.append('password', userData.password);
  formData.append('file', userData.file);

  // Wysłanie danych do serwera
  fetch('/create-user', {
    method: 'POST',
    body: formData // FormData zawiera zarówno dane użytkownika, jak i plik
  })
  .then(response => response.json())
  .then(data => {
    console.log('Odpowiedź z serwera:', data);
    info.innerText = `Użytkownik Został Stworzony (${data})`
  })
  .catch(error => {
    console.error('Błąd:', error);
    info.innerText = `Wystąpił Błąd (${error})`
  });
}
