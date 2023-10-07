<?php
require_once 'assets/db/database.php';

$table_check_query = "SHOW TABLES LIKE 'utenti'";
$table_check_result = mysqli_query($conn, $table_check_query);

if (!$table_check_result) {
    die("Errore nella verifica delle tabelle: " . mysqli_error($conn));
}

// Migrazione e creazione tabelle
if (mysqli_num_rows($table_check_result) == 0) {
    // tabella 'utenti'
    $create_utenti_table = "CREATE TABLE utenti (
        id INT NOT NULL AUTO_INCREMENT,
        nome VARCHAR(45),
        cognome VARCHAR(45),
        email VARCHAR(255),
        password VARCHAR(255),
        reset_token VARCHAR(255) NULL,
        PRIMARY KEY (id)
    )";

    if (!mysqli_query($conn, $create_utenti_table)) {
        die("Errore durante la creazione della tabella 'utenti': " . mysqli_error($conn));
    }

    // tabella 'eventi'
    $create_eventi_table = "CREATE TABLE eventi (
        id INT NOT NULL AUTO_INCREMENT,
        attendees TEXT,
        nome_evento VARCHAR(255),
        data_evento DATETIME,
        PRIMARY KEY (id)
    )";

    if (!mysqli_query($conn, $create_eventi_table)) {
        die("Errore durante la creazione della tabella 'eventi': " . mysqli_error($conn));
    }

    // dati iniziali nella tabella 'eventi'
    $insert_eventi_data = "INSERT INTO eventi (attendees, nome_evento, data_evento) VALUES
        ('ulysses200915@varen8.com,qmonkey14@falixiao.com,mavbafpcmq@hitbase.net', 'Test Edusogno 1', '2022-10-13 14:00'),
        ('dgipolga@edume.me,qmonkey14@falixiao.com,mavbafpcmq@hitbase.net', 'Test Edusogno 2', '2022-10-15 19:00'),
        ('dgipolga@edume.me,ulysses200915@varen8.com,mavbafpcmq@hitbase.net', 'Test Edusogno 3', '2022-10-15 19:00'),";

    if (!mysqli_query($conn, $insert_eventi_data)) {
        die("Errore durante l'inserimento dei dati nella tabella 'eventi': " . mysqli_error($conn));
    }
}
?>
