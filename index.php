<?php
require_once 'assets/db/database.php';

$migrationsFile = 'assets/db/Migrations.sql';  

$migrationsSql = file_get_contents($migrationsFile);

if (mysqli_multi_query($conn, $migrationsSql)) {
    do {
        // Processa i risultati di ogni query (se necessario)
    } while (mysqli_next_result($conn));
} else {
    echo 'Errore nella migrazione: ' . mysqli_error($conn);
}

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
