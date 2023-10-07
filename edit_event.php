<?php
require_once 'assets/db/database.php';
// Verifica se l'ID dell'evento è fornito nella query string
if (isset($_GET['id'])) {
    $event_id = $_GET['id'];

    // Esegui una query per recuperare i dettagli dell'evento in base all'ID
    $query_event_details = "SELECT nome_evento, data_evento FROM eventi WHERE id = $event_id";
    $result_event_details = mysqli_query($conn, $query_event_details);

    if ($result_event_details) {
        $event_details = mysqli_fetch_assoc($result_event_details);
        $nome_evento = $event_details['nome_evento'];
        $data_evento = $event_details['data_evento'];
    } else {
        echo 'Errore nella query per recuperare i dettagli dell\'evento: ' . mysqli_error($conn);
        exit();
    }

    // Se il modulo è stato inviato, elabora le modifiche
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $new_nome_evento = $_POST['nome_evento'];
        $new_data_evento = $_POST['data_evento'];

        // Esegui una query per aggiornare i dettagli dell'evento
        $update_query = "UPDATE eventi SET nome_evento = '$new_nome_evento', data_evento = '$new_data_evento' WHERE id = $event_id";
        $result_update = mysqli_query($conn, $update_query);

        if ($result_update) {
            echo 'Modifica effettuata con successo.';
            
            header('Refresh: 0.5; URL=home.php');
            exit();
        } else {
            echo 'Errore nella modifica dell\'evento: ' . mysqli_error($conn);
        }
    }
} else {
    echo 'ID not provided';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edusogno - Modifica</title>
    <link rel="stylesheet" href="assets/styles/style.css">
    <link rel="stylesheet" href="assets/styles/registerLoginStyle.css">
</head>
<body>
    <nav>
        <img src="assets/logo-black.svg" alt="Edusogno">
    </nav>

    <main>
        <h1>Modifica Evento</h1>
        <div class="content">
            <div class="card">
            <div id="error" style="color: red; font-size: 1.3rem; font-weight: 600; margin-bottom: 1rem;"></div>
                <form method="POST" id="editForm" novalidate>
                    <div class="inputs">
                        <div class="input">
                            <label for="nome_evento">Nome dell'evento:</label>
                            <input type="text" id="nome_evento" name="nome_evento" value="<?php echo $nome_evento; ?>" required>
                        </div>

                        <div class="input">
                            <label for="data_evento">Data dell'evento:</label>
                            <input type="datetime-local" id="data_evento" name="data_evento" value="<?php echo date('Y-m-d\TH:i', strtotime($data_evento)); ?>" required>
                        </div>

                        <input type="submit" value="Salva Modifiche" class="submit">

                        <a href="home.php">Torna alla Home</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script src="assets/js/edit.js"></script>
</body>
</html>
