<?php
require_once 'assets/db/database.php';
include 'migrate_database.php';

// Verifica se il modulo è stato inviato
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verifica se l'utente esiste già nel database
    $query = "SELECT * FROM utenti WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $error = "Questo indirizzo email è già stato registrato.";
    } else {
        // Hash della password prima di salvarla nel database
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Inserisci l'utente nel database
        $insert_query = "INSERT INTO utenti (nome, cognome, email, password) VALUES ('$first_name', '$last_name', '$email', '$hashed_password')";
        $insert_result = mysqli_query($conn, $insert_query);

        if ($insert_result) {
            // Registrazione riuscita
            header('Location: login.php'); // Reindirizza alla pagina di login
            exit();
        } else {
            $error = "Errore durante la registrazione: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edusogno - Registration</title>
    <link rel="stylesheet" href="assets/styles/style.css">
    <link rel="stylesheet" href="assets/styles/registerLoginStyle.css">
</head>

<body>
    <!-- NAVBAR -->
    <nav>
        <img src="assets/logo-black.svg" alt="Edusogno">
    </nav>

    <!-- MAIN CONTENT -->
    <main>
        <h1>Registrati</h1>
        
        <div class="content">
            <div class="card">
                <?php if (isset($error)) { ?>
                    <p id="error" style="color: red; font-size: 1.3rem; font-weight: 600; margin-bottom: 1rem;"><?php echo $error; ?></p>
                <?php } ?>

                <form method="POST" id="registrationForm" novalidate>
                    <div class="inputs">
                        <div class="input">
                            <label for="first_name">Nome:</label>
                            <input type="text" id="first_name" name="first_name" placeholder="Mario" required>
                        </div>

                        <div class="input">
                            <label for="last_name">Cognome:</label>
                            <input type="text" id="last_name" name="last_name" placeholder="Rossi" required>
                        </div>

                        <div class="input">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" placeholder="name@example.com" required>
                        </div>

                        <div class="input">
                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password" placeholder="Scrivila qui" required>
                        </div>  

                        <input type="submit" value="REGISTRATI" class="submit">

                        <a href="login.php">Sei già registrato? Vai al Login!</a>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <script src="assets/js/registration.js"></script>
</body>
</html>
