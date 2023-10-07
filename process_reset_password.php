<?php
require 'assets/db/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $token = $_POST['token'];

    // Validazione nuova password
    if ($password !== $confirm_password) {
        $error = "Le password non corrispondono. Riprova.";
    } else {
        // Validazione del token
        $token = mysqli_real_escape_string($conn, $token);
        $query = "SELECT * FROM utenti WHERE reset_token = '$token'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);

            // Hash della nuova password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $update_query = "UPDATE utenti SET password = '$hashed_password', reset_token = NULL WHERE id = " . $user['id'];
            if (mysqli_query($conn, $update_query)) {

                header('Location: login.php');
                exit();
            } else {
                $error = "Errore durante l'aggiornamento della password: " . mysqli_error($conn);
            }
        } else {
            $error = "Token di reset non valido. Assicurati di utilizzare il link corretto dalla tua email.";
        }
    }
}
?>
