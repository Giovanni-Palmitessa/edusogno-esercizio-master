<?php
require 'assets/db/database.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Verifica se l'indirizzo email esiste nel database
    $query = "SELECT * FROM utenti WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        // Genera un token univoco per il reset della password
        $token = bin2hex(random_bytes(32));
        
        // Salva il token nel database per l'utente corrispondente
        $update_query = "UPDATE utenti SET reset_token = '$token' WHERE id = " . $user['id'];
        mysqli_query($conn, $update_query);

        // Invia l'email con il link di reset
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io'; // Imposta l'host Mailtrap
        $mail->SMTPAuth = true;
        $mail->Username = '82471efda1b5ae'; // Sostituisci con il tuo username Mailtrap
        $mail->Password = 'bdd6ad73dadde3'; // Sostituisci con la tua password Mailtrap
        $mail->SMTPSecure = 'tls';
        $mail->Port = 2525; // Porta Mailtrap
        
        $mail->setFrom('edusogno@email.com', 'Edusogno');
        $mail->addAddress($email, $user['nome']); // Aggiungi l'indirizzo email dell'utente
        $mail->Subject = 'Reset Password - Edusogno';
        $mail->isHTML(true);

        // Costruisci il corpo del messaggio con il link di reset
        $reset_link = "http://localhost/edusogno-esercizio-master/reset_password_confirm.php?token=$token";
        $message = "Clicca sul link seguente per resettare la tua password: <a href='$reset_link'>Reset Password</a>";
        $mail->Body = $message;

        if ($mail->send()) {
            // Email inviata con successo, reindirizza l'utente a una pagina di conferma
            header('Location: reset_password_confirmation.php');
            exit();
        } else {
            $error = "Errore nell'invio dell'email: " . $mail->ErrorInfo;
        }
    } else {
        $error = "Indirizzo email non trovato nel database.";
    }
}
?>
