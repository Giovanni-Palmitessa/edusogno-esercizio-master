document.addEventListener("DOMContentLoaded", function () {
  const registrationForm = document.getElementById("registrationForm");
  const emailField = document.getElementById("email");
  const passwordField = document.getElementById("password");
  const errorField = document.getElementById("error");

  registrationForm.addEventListener("submit", function (event) {
    let valid = true;
    errorField.innerHTML = "";

    // Validazione dell'email
    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
    if (!emailPattern.test(emailField.value)) {
      errorField.innerHTML += "Inserisci un indirizzo email valido.<br>";
      valid = false;
    }

    // Validazione della lunghezza della password
    if (passwordField.value.length < 8) {
      errorField.innerHTML +=
        "La password deve essere di almeno 8 caratteri.<br>";
      valid = false;
    }

    if (!valid) {
      event.preventDefault();
    }
  });
});
