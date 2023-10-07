<?php
session_start();

// Verifica se l'utente è autenticato
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Includi il file di connessione al database
require_once 'assets/db/database.php';

// Inizializza le variabili per i dati dell'evento
$nome_evento = $data_evento = '';
$error = '';

// Verifica se il modulo è stato inviato
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validazione dei dati
    $nome_evento = $_POST['nome_evento'];
    $data_evento = $_POST['data_evento'];

    // Esegui una query per inserire il nuovo evento nel database
    $email = $_SESSION['user_email'];
    $insert_query = "INSERT INTO eventi (attendees, nome_evento, data_evento) VALUES ('$email', '$nome_evento', '$data_evento')";
    $result_insert = mysqli_query($conn, $insert_query);

    if ($result_insert) {
        $nome_evento = $data_evento = ''; // Resetta i campi del modulo dopo l'inserimento
        // Effettua il reindirizzamento alla home
        echo 'Evento inserito con successo.';

        header('Refresh: 0.5; URL=home.php');
        exit();
    } else {
        $error = 'Errore durante l\'inserimento dell\'evento: ' . mysqli_error($conn);
    }
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aggiungi un Evento</title>
    <link rel="stylesheet" href="assets/styles/style.css">
    <link rel="stylesheet" href="assets/styles/registerLoginStyle.css">
</head>
<body>
    <nav>
        <img src="assets/logo-black.svg" alt="Edusogno">
    </nav>

    <main>
        <h1>Aggiungi un Evento</h1>

        <div class="content">
            <div class="card">
                <?php if (!empty($error)) { echo '<p>' . $error . '</p>'; } ?>
                <div id="error" style="color: red; font-size: 1.3rem; font-weight: 600; margin-bottom: 1rem;"></div>
                    <form method="POST" id="newEventForm" novalidate>
                        <div class="inputs">
                            <div class="input">
                                <label for="nome_evento">Nome dell'evento:</label>
                                <input type="text" id="nome_evento" name="nome_evento" value="<?php echo $nome_evento; ?>" required>
                            </div>

                            <div class="input">
                                <label for="data_evento">Data dell'evento:</label>
                                <input type="datetime-local" id="data_evento" name="data_evento" value="<?php echo $data_evento; ?>" required>
                            </div>

                            <input type="submit" value="Aggiungi Evento" class="submit">

                            <a href="home.php">Torna alla Home</a>
                        </div>
                    </form>
            </div>
        </div>
    </main>
    <script src="assets/js/newEvent.js"></script>
</body>
</html>
