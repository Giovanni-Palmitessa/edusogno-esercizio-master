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

if (!empty($events)) {
    echo '<h2>Your Events:</h2>';
    echo '<ul>';
    foreach ($events as $event) {
        echo '<li>' . $event['nome_evento'] . ' - ' . $event['data_evento'] . ' - ';
        echo '<a href="edit_event.php?id=' . $event['id'] . '">Edit</a> | ';
        echo '<a href="delete_event.php?id=' . $event['id'] . '">Delete</a>';
        echo '</li>';
    }
    echo '</ul>';
} else {
    echo '<p>You are not registered for any events.</p>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edusogno - Home</title>
</head>
<body>
    <h1>Welcome, <?php echo $first_name . ' ' . $last_name; ?></h1>

    <a href="newEvent.php">Aggiungi un evento</a>

</body>
</html>
