<?php
require_once 'assets/db/database.php';

$migrationsFile = 'assets/db/Migrations.sql';
$migrationStatusFile = 'migration_completed.txt'; // Il tuo file di controllo

// Verifica se la migrazione è stata completata in precedenza
if (!file_exists($migrationStatusFile)) {
    $migrationsSql = file_get_contents($migrationsFile);

    if (mysqli_multi_query($conn, $migrationsSql)) {
        do {
            // Processa i risultati di ogni query (se necessario)
        } while (mysqli_next_result($conn));
        
        // Crea il file di controllo
        file_put_contents($migrationStatusFile, 'Migration completed');
    } else {
        echo 'Errore nella migrazione: ' . mysqli_error($conn);
    }
}

// Query per eliminare tutti i dati dalla tabella "eventi"
// $query = "DELETE FROM eventi";
// $result = mysqli_query($conn, $query);

// if ($result) {
//     echo 'Dati eliminati con successo dalla tabella "eventi"';
// } else {
//     echo 'Errore nell\'eliminazione dei dati: ' . mysqli_error($conn);
// }

// $migrationStatusFile = 'migration_completed.txt';

// Rimuovi il file di controllo (oppure sovrascrivilo con un contenuto vuoto)
// if (file_exists($migrationStatusFile)) {
//     unlink($migrationStatusFile);
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edusogno</title>
</head>

<body>

</body>

</html>
