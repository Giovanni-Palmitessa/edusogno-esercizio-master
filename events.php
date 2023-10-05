<?php
session_start();

require_once 'assets/db/database.php';

class Event {
    public $eventName;
    public $eventDate;
    public $attendees;

    public function __construct($eventName, $eventDate, $attendees) {
        $this->eventName = $eventName;
        $this->eventDate = $eventDate;
        $this->attendees = $attendees;
    }
}

class EventController {
    private $events = []; // Array per conservare gli eventi

    public function addEvent(Event $event) {
        $this->events[] = $event;
    }

    public function editEvent($index, Event $event) {
        if (isset($this->events[$index])) {
            $this->events[$index] = $event;
        }
    }

    public function deleteEvent($index) {
        if (isset($this->events[$index])) {
            unset($this->events[$index]);
        }
    }

    public function getEvents() {
        return $this->events;
    }

    public function isAdmin($user) {
        return $user->isAdmin();
    }
}

$eventController = new EventController();
$events = $eventController->getEvents(); // Recupera tutti gli eventi

// Verifica se l'utente è un amministratore (esempio)
$isAdmin = true; // Dovrai implementare la logica di autenticazione dell'utente

if (!$isAdmin) {
    // Reindirizza o mostra un messaggio di errore se l'utente non è un amministratore
    echo "Solo gli amministratori possono accedere a questa pagina.";
    exit;
}

// Query per recuperare gli eventi dal database
$query_events = "SELECT nome_evento, attendees, data_evento FROM eventi";
$result_events = mysqli_query($conn, $query_events);

if ($result_events) {
    while ($row = mysqli_fetch_assoc($result_events)) {
        // Estrai le informazioni dal database
        $nomeEvento = $row['nome_evento'];
        $dataEvento = $row['data_evento'];
        $attendees = $row['attendees'];
    
        // Creare un'istanza di Event con i dati corretti
        $event = new Event($nomeEvento, $dataEvento, $attendees);
        $eventController->addEvent($event);
    }
    
} else {
    echo "Errore nella query degli eventi: " . mysqli_error($conn);
}


// Recupera gli eventi dell'utente attuale basati sulla sua email
$email = $_SESSION['user_email']; // Recupera l'email dell'utente
$query_events = "SELECT nome_evento FROM eventi WHERE FIND_IN_SET('$email', attendees)";
$result_events = mysqli_query($conn, $query_events);

$events = array();
while ($row = mysqli_fetch_assoc($result_events)) {
    $events[] = $row['nome_evento'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Admin Dashboard</h1>

    <!-- Visualizza la lista degli eventi -->
    <h2>Eventi</h2>
<ul>
    <?php foreach ($events as $index => $event): ?>
        <?php if ($event instanceof Event): ?>
            <li>
                <strong><?= $event->eventName ?></strong> - <?= $event->eventDate ?> (Partecipanti: <?= $event->attendees ?>)
                <a href="edit_event.php?index=<?= $index ?>">Modifica</a> | <a href="delete_event.php?index=<?= $index ?>">Elimina</a>
            </li>
        <?php endif; ?>
    <?php endforeach; ?>
</ul>

    <!-- Aggiungi un nuovo evento -->
    <h2>Aggiungi un nuovo evento</h2>
    <form method="POST" action="add_event.php">
        <label for="title">Titolo:</label>
        <input type="text" id="title" name="title" required><br><br>

        <label for="description">Descrizione:</label>
        <textarea id="description" name="description" required></textarea><br><br>

        <label for="attendees">Partecipanti:</label>
        <input type="number" id="attendees" name="attendees" required><br><br>

        <input type="submit" value="Aggiungi Evento">
    </form>
</body>
</html>

