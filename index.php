<?php
session_start();

// Aktuelle Kalenderwoche abrufen
$week = date("W");

// Weiterleiten falls der Nutzer bereits eingeloggt ist
if (isset($_SESSION['user'])) {
    header("Location: wochenplan.php?week=" . $week);
    exit;
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./assets/css/main.css">
        <!-- favicon -->
        <link rel="icon" type="image/png" href="./assets/images/favicon/favicon-96x96.png" sizes="96x96" />
        <link rel="icon" type="image/svg+xml" href="./assets/images/favicon/favicon.svg" />
        <link rel="shortcut icon" href="./assets/images/favicon/favicon.ico" />
        <link rel="apple-touch-icon" sizes="180x180" href="./assets/images/favicon/apple-touch-icon.png" />
        <link rel="manifest" href="./assets/images/favicon/site.webmanifest" />
    <title>Wochenplan Login</title>
</head>
<body class="min-h-screen p-4 flex flex-col justify-between gap-10">
    <header>
        <a class="cursor-pointer" href="./wochenplan.php?week=<?= $week; ?>">
            <img class="h-10 object-contain cursor-pointer" src="./assets/images/logo.png" alt="Logo SDV">
        </a>
    </header>
    <main class="flex justify-center items-center">
        <div class="flex flex-col max-w-80">
            <h2 class="text-3xl pb-4 text-center">Login Wochenplan SDV</h2>
            <form method="POST" action="login.php">
                <input class="w-full p-2 mt-2 border border-slate-300" type="text" name="username" id="username" placeholder="dein Benutzername">
                <input class="w-full p-2 mt-2 border border-slate-300" type="password" name="password" id="password" placeholder="dein Password">
                <input class="w-full p-2 mt-2 border border-slate-300 bg-slate-300 cursor-pointer duration-300 ease-in-out hover:bg-slate-500 hover:text-white" type="submit" value="anmelden">
            </form>
        </div>
    </main>
    <footer class="text-center">
        <p>SDV STUDIOS <?= date("Y"); ?></p>
    </footer>
</body>
</html>