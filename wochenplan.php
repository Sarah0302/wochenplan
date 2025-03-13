<?php
session_start();

// Prüfen ob Benutzer angemeldet ist
if(!isset($_SESSION['user'])) :
    header("Location: index.php");
    exit;
endif;

require_once "helpers.php"; // Daten aus helpers.php werden eingebunden

?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./assets/js/jquery-3.7.1.min.js"></script>
    <script src="./assets/js/main.js"></script>
    <script src="./assets/js/functions.js"></script>
    <script src="./assets/js/add-job.js"></script>
    <script src="./assets/js/update-job.js"></script>
    <script src="./assets/js/delete-job.js"></script>
    <script src="./assets/js/jobs.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="./assets/css/main.css">
        <!-- favicon -->
        <link rel="icon" type="image/png" href="./assets/images/favicon/favicon-96x96.png" sizes="96x96" />
        <link rel="icon" type="image/svg+xml" href="./assets/images/favicon/favicon.svg" />
        <link rel="shortcut icon" href="./assets/images/favicon/favicon.ico" />
        <link rel="apple-touch-icon" sizes="180x180" href="./assets/images/favicon/apple-touch-icon.png" />
        <link rel="manifest" href="./assets/images/favicon/site.webmanifest" />
    <title>Wochenplan</title>
</head>
<body class="min-h-screen flex flex-col justify-between gap-5">
    <header class="bg-stone-200 p-4 flex flex-row justify-between items-center">
        <a class="cursor-pointer" href="./wochenplan.php?week=<?= $thisWeek; ?>">
            <img class="h-10 object-contain cursor-pointer" src="./assets/images/logo.png" alt="Logo SDV">
        </a>
        <button class="open_all bg-zinc-300 pt-2 pr-4 pb-2 pl-4 shadow-md shadow-gray-400/50">alle öffnen</button>
        <button class="close_all bg-zinc-300 pt-2 pr-4 pb-2 pl-4 shadow-md shadow-gray-400/50">alle schließen</button>
        <button class="saturday_button bg-zinc-300 pt-2 pr-4 pb-2 pl-4 shadow-md shadow-gray-400/50">Samstag anzeigen</button>
        <a href="logout.php">Abmelden</a>
    </header>
    <main class="p-4">
        <div class="flex justify-center items-center">
            <button class="week_before">
                <img class="object-contain h-7" src="./assets/images/arrow-left.png" alt="arrow-left">
            </button>
            <h1 class="pl-6 pr-6 text-5xl">Willkommen in KW <?= $week; ?> <?= $user; ?></h1>
            <button class="week_after">
                <img class="object-contain h-7" src="./assets/images/arrow-right.png" alt="arrow-right">
            </button>
        </div>
        <div class="border border-slate-600 mt-6">
            <table class="w-full mt-1 table-fixed">
                <!-- Tabellenkopf -->
                <tr class="saturday-col bg-slate-600 text-white grid grid-cols-[200px_repeat(5,1fr)] items-stretch">
                    <th class="p-2">Mitarbeiter</th>
                    <?php foreach ($weekdays as $day) : ?>
                        <?php 
                            $class = '';
                            if ($day === $weekday && $weekDates[$day] === $thisDay) {
                                $class = $classToday; 
                            }
                            if ($day === 'Samstag') {
                                $class .= ' saturday hidden'; 
                            }
                        ?>
                        <th class="p-2<?= $class; ?>"><?= $day; ?><br><span class="font-light"><?= $weekDates[$day]; ?></span></th>
                    <?php endforeach; ?>
                </tr>
                <!-- Spalte für jede Person -->
                <?php require_once "read.php"; ?>   <!-- Tabellen Inhalt oder Fehlermeldung wird eingefügt -->
            </table>
        </div>
    </main>
    <footer class="p-4">
        <div class="columns-5">
            <div class="bg-lime-300 p-4 text-center">Fahrt</div>
            <div class="bg-cyan-300 p-4 text-center">Homeoffice</div>
            <div class="bg-amber-300 p-4 text-center">Kurzarbeit</div>
            <div class="bg-orange-300 p-4 text-center">Halber Tag</div>
            <div class="bg-rose-300 p-4 text-center">Abwesend / Schule</div>
        </div>
        <div class="text-center mt-2">
            <p>SDV STUDIOS <?= date("Y"); ?></p>
        </div>
    </footer>
</body>
</html>