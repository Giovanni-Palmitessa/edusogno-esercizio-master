<?php
$db_host = 'localhost';
$db_username = 'root';
$db_password = 'root';
$db_name = 'edusogno';

$conn = mysqli_connect($db_host, $db_username, $db_password, $db_name);

if (!$conn) {
    die('Errore di connessione al database: ' . mysqli_connect_error());
} else {
    echo 'Connessione al database stabilita con successo!';
}


?>


