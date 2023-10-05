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
        $success_message = 'Evento aggiunto con successo.';
        $nome_evento = $data_evento = ''; // Resetta i campi del modulo dopo l'inserimento
    
        // Effettua il reindirizzamento alla home dopo un breve ritardo (ad esempio, 2 secondi)
        header('Refresh: 2; URL=home.php');
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
</head>
<body>
    <h1>Aggiungi un Evento</h1>
    
    <!-- Mostra eventuali messaggi di errore o successo -->
    <?php if (!empty($error)) { echo '<p>' . $error . '</p>'; } ?>
    <?php if (!empty($success_message)) { echo '<p>' . $success_message . '</p>'; } ?>

    <form method="POST">
        <label for="nome_evento">Nome dell'evento:</label>
        <input type="text" id="nome_evento" name="nome_evento" value="<?php echo $nome_evento; ?>" required><br>

        <label for="data_evento">Data dell'evento:</label>
        <input type="datetime-local" id="data_evento" name="data_evento" value="<?php echo $data_evento; ?>" required><br>

        <input type="submit" value="Aggiungi Evento">
    </form>

    <a href="home.php">Torna alla Home</a>
</body>
</html>
