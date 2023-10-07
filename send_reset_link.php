<?php
require 'assets/db/database.php';
require 'vendor/phpmailer/phpmailer/src/PHPMailer.php';
require 'vendor/phpmailer/phpmailer/src/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // token univoco per il reset della password
    $token = bin2hex(random_bytes(32));
    
    // Salvare il token nel database per l'utente corrispondente
    $query = "UPDATE utenti SET reset_token = '$token' WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $reset_link = "http://localhost/edusogno-esercizio-master/reset_password.php?token=$token";

        // Mail
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->Host = 'sandbox.smtp.mailtrap.io';
        $mail->SMTPAuth = true;
        $mail->Username = '82471efda1b5ae'; 
        $mail->Password = 'bdd6ad73dadde3';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 2525;
        
        $mail->setFrom('edusogno@email.com', 'Edusogno');
        $mail->addAddress($email);
        $mail->Subject = 'Reset Password - Edusogno';
        $mail->isHTML(true);

        // Corpo Mail
        $message = "Clicca sul link seguente per resettare la tua password: <a href='$reset_link'>Reset Password</a>";
        $mail->Body = $message;

        if ($mail->send()) {
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
