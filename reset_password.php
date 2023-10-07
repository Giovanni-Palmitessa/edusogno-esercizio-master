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
