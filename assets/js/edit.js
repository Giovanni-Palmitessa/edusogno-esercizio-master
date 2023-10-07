document.addEventListener("DOMContentLoaded", function () {
  const editForm = document.getElementById("editForm");
  const nomeEventoField = document.getElementById("nome_evento");
  const dataEventoField = document.getElementById("data_evento");
  const errorField = document.getElementById("error");

  editForm.addEventListener("submit", function (event) {
    let valid = true;
    errorField.innerHTML = "";

    // Validazione del nome dell'evento
    if (nomeEventoField.value.trim() === "") {
      errorField.innerHTML += "Inserisci il nome dell'evento.<br>";
      valid = false;
    }

    // Validazione della data dell'evento
    if (dataEventoField.value.trim() === "") {
      errorField.innerHTML += "Inserisci la data dell'evento.<br>";
      valid = false;
    }

    if (!valid) {
      event.preventDefault();
    }
  });
});
