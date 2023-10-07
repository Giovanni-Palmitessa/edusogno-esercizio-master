<?php
require_once 'assets/db/database.php';

if (isset($_GET['id'])) {
    $event_id = $_GET['id'];

    // query per eliminare l'evento in base all'ID
    $delete_query = "DELETE FROM eventi WHERE id = $event_id";
    $result_delete = mysqli_query($conn, $delete_query);

    if ($result_delete) {
        header('Location: home.php');
        exit();
    } else {
        echo 'Errore nella cancellazione dell\'evento: ' . mysqli_error($conn);
    }
} else {
    echo 'ID not provided';
}
