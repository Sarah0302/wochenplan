<?php
session_start();

// Weiterleiten falls der Nutzer bereits eingeloggt ist
if (isset($_SESSION['user'])) {
    header("Location: wochenplan.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./assets/js/jquery-3.7.1.min.js"></script>
    <script src="./assets/js/main.js"></script>
    <script src="./assets/js/jobs.js"></script>
    <link href="./assets/css/tailwind.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/main.css">
        <!-- favicon -->
    <title>Wochenplan Login</title>
</head>
<body>
    <header>
        header
    </header>
    <main>
        <div>
            <h2>Login</h2>
            <form method="POST" action="login.php">
                <input type="text" name="username" id="username" placeholder="dein Benutzername">
                <input type="password" name="password" id="password" placeholder="dein Password">
                <input type="submit" value="anmelden">
            </form>
        </div>
    </main>
    <footer>
        footer
    </footer>
</body>
</html>