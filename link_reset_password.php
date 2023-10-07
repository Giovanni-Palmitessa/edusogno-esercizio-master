<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edusogno - Reset Password</title>
    <link rel="stylesheet" href="assets/styles/style.css">
    <link rel="stylesheet" href="assets/styles/registerLoginStyle.css">
</head>
<body>
    <!-- navbar -->
    <nav>
        <img src="assets/logo-black.svg" alt="Edusogno">
    </nav>

    <!-- main content -->
    <main>
        <h1>Reset Password</h1>
        <div class="content">
            <div class="card">
                <form method="POST" action="send_reset_link.php">
                    <div class="inputs">
                        <div class="input">
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" placeholder="Inserisci il tuo indirizzo email" required>
                        </div>

                        <input type="submit" value="Invia Link Reset" class="submit">
                    </div>                 
                </form>
            </div>
        </div>
    </main>
</body>
</html>