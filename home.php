<?php
session_start();

// Verifica se l'utente è autenticato
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Includi il file di connessione al database
require_once 'assets/db/database.php';

// Recupera il nome e il cognome dell'utente
$user_id = $_SESSION['user_id'];
$query_user = "SELECT nome, cognome FROM utenti WHERE id = $user_id";
$result_user = mysqli_query($conn, $query_user);

if ($result_user) {
    $user = mysqli_fetch_assoc($result_user);
    $first_name = $user['nome'];
    $last_name = $user['cognome'];
} else {
    $error = "Errore nella query dell'utente: " . mysqli_error($conn);
}

// Recupera gli eventi ai quali partecipa l'utente
$email = $_SESSION['user_email']; // Recupera l'email dell'utente
$query_events = "SELECT id, nome_evento, data_evento FROM eventi WHERE FIND_IN_SET('$email', attendees)";
$result_events = mysqli_query($conn, $query_events);

$events = array();
while ($row = mysqli_fetch_assoc($result_events)) {
    $events[] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edusogno - Home</title>
    <link rel="stylesheet" href="assets/styles/style.css">
    <link rel="stylesheet" href="assets/styles/homeStyle.css">
</head>
<body>
    <nav>
        <img src="assets/logo-black.svg" alt="Edusogno">
    </nav>

    <main>
        <h1>Ciao, <?php echo $first_name; ?> ecco i tuoi eventi</h1>

        <div class="event-cards">
            <?php
            if (!empty($events)) {
                foreach ($events as $event) {
                    echo '<div class="event-card">';
                    echo '<h2>' . $event['nome_evento'] . '</h2>';
                    echo '<p>' . $event['data_evento'] . '</p>';
                    echo '<div class="btns">';
                    echo '<a class="edit-button" href="edit_event.php?id=' . $event['id'] . '">Modifica</a>';
                    echo '<a class="delete-button" href="delete_event.php?id=' . $event['id'] . '">Cancella</a>';
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo '<p class="message">Non sei registrato per nessun evento. Creane uno nuovo!</p>';
            }
            ?>
        </div>

        <div class="link">
            <a href="newEvent.php" class="addEvent">Aggiungi un evento</a>
        </div>
    </main>

    
</body>
</html>
