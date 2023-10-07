<?php
require 'assets/db/database.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Genera un token univoco per il reset della password
    $token = bin2hex(random_bytes(32));
    
    // Salva il token nel database per l'utente corrispondente
    $query = "UPDATE utenti SET reset_token = '$token' WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Costruisci il link di reset con il token
        $reset_link = "http://localhost/edusogno-esercizio-master/reset_password.php?token=$token";

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
        $mail->addAddress($email); // Aggiungi l'indirizzo email dell'utente
        $mail->Subject = 'Reset Password - Edusogno';
        $mail->isHTML(true);

        // Costruisci il corpo del messaggio con il link di reset
        $message = "Clicca sul link seguente per resettare la tua password: <a href='$reset_link'>Reset Password</a>";
        $mail->Body = $message;

        if ($mail->send()) {
            // Email inviata con successo, reindirizza l'utente a una pagina di conferma
            header('Location: reset_password_confirm.php');
            exit();
        } else {
            $error = "Errore nell'invio dell'email: " . $mail->ErrorInfo;
        }
    } else {
        $error = "Errore nell'aggiornamento del token nel database.";
    }
}
?>
