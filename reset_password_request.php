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
    <nav>
        <img src="assets/logo-black.svg" alt="Edusogno">
    </nav>

    <main>
        <h1>Reimposta la tua password</h1>
        
        <div class="content">
            <div class="card">
                <form method="POST" action="process_reset_request.php">
                    <div class="inputs">
                        <div class="input">
                            <label for="email">Indirizzo Email:</label>
                            <input type="email" id="email" name="email" placeholder="name@example.com" required>
                        </div>

                        <input type="submit" value="invia Richiesta" class="submit">
                    </div>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
