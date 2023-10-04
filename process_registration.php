<?php
require_once 'assets/db/database.php';

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
</head>
<body>
    <h1>Registration</h1>
    <?php if (isset($error)) { ?>
        <p style="color: red;"><?php echo $error; ?></p>
    <?php } ?>

    <form method="POST" action="process_registration.php">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required><br><br>

        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Register">
    </form>
</body>
</html>
