<?php
session_start();
require_once 'assets/db/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verifica le credenziali nel database
    $query = "SELECT * FROM utenti WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $user = mysqli_fetch_assoc($result);
        if ($user) {
            // L'indirizzo email è presente nel database, verifica la password
            if (password_verify($password, $user['password'])) {
                // Credenziali corrette, effettua il login
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                header('Location: home.php');
                exit();
            } else {
                $error = "Password errata. Riprova.";
            }
        } else {
            $error = "Indirizzo email non trovato nel database.";
        }
    } else {
        $error = "Errore nella query: " . mysqli_error($conn);
    }    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edusogno - Login</title>
    <link rel="stylesheet" href="assets/styles/style.css">
    <link rel="stylesheet" href="assets/styles/registerLoginStyle.css">
</head>
<body>
    <nav>
        <img src="assets/logo-black.svg" alt="Edusogno">
    </nav>

    <main>
        <h1>Login</h1>
        <div class="content">
            <div class="card">
                <?php if (isset($error)) { ?>
                <p style="color: red; font-size: 1.3rem; font-weight: 600; margin-bottom: 1rem;"><?php echo $error; ?></p>
                <?php } ?>

                <form method="POST">
                    <div class="inputs">
                        <div class="input">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" placeholder="name@example.com" required value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">

                        </div>

                        <div class="input">
                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password" placeholder="Scrivila qui" required>

                        </div>

                        <input type="submit" value="LOGIN" class="submit">

                        <a href="register.php">Non Hai un account? Registrati</a>
                    </div>                 
                </form>
            </div>
        </div>
    </main>
</body>
</html>
