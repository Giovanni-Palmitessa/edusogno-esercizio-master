<?php
require 'assets/db/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $token = $_POST['token'];

    // Valida la nuova password
    if ($password !== $confirm_password) {
        $error = "Le password non corrispondono. Riprova.";
    } else {
        // Verifica la validità del token
        $token = mysqli_real_escape_string($conn, $token);
        $query = "SELECT * FROM utenti WHERE reset_token = '$token'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) === 1) {
            $user = mysqli_fetch_assoc($result);

            // Hash della nuova password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Aggiorna la password e cancella il token di reset
            $update_query = "UPDATE utenti SET password = '$hashed_password', reset_token = NULL WHERE id = " . $user['id'];
            if (mysqli_query($conn, $update_query)) {
                // Password reimpostata con successo, reindirizza l'utente alla pagina di login
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edusogno - Reset Password</title>
    <link rel="stylesheet" href="assets/styles/style.css">
    <link rel="stylesheet" href="assets/styles/registerLoginStyle.css">
</head>
<body>
    <nav>
        <img src="assets/logo-black.svg" alt="Edusogno">
    </nav>

    <main>
        <h1>Reimposta Password</h1>
        <div class="content">
            <div class="card">
                <form method="POST" action="process_reset_password.php">
                    <div class="inputs">
                        <div class="input">
                            <label for="password">Nuova Password:</label>
                            <input type="password" id="password" name="password" placeholder="Inserisci la nuova password" required>
                        </div>

                        <div class="input">
                            <label for="confirm_password">Conferma Password:</label>
                            <input type="password" id="confirm_password" name="confirm_password" placeholder="Conferma la nuova password" required>
                        </div>

                        <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
                        <!-- Includi il token di reset come campo nascosto -->

                        <input type="submit" value="Reimposta Password" class="submit">
                    </div>                 
                </form>
            </div>
        </div>
    </main>
</body>
</html>
