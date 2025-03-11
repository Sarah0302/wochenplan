<?php
session_start();

// Prüfen ob Benutzer angemeldet ist
if(!isset($_SESSION['user'])) :
    header("Location: index.php");
    exit;
endif;

// Eingeloggten Benutzer und People-Array abrufen
$user = $_SESSION['user'];
$people = $_SESSION['people'] ?? ["Pool"];

// Aktuells Datum und aus URL Kalenderwoche abrufen
$today = date("d.m.y");
$thisWeek = date("W"); // Aktuelle Kalenderwoche
$week = isset($_GET['week']) ? intval($_GET['week']) : date("W");  // week in URL vorhanden? -> Wenn ja Wert abrufen -> Wenn nein aktuelle Woche 

// echo '<br><br>';
// echo 'heute: ' . $today;
// echo '<br>';
// echo 'woche: ' . $week;
// echo '<br><br>';
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./assets/js/jquery-3.7.1.min.js"></script>
    <script src="./assets/js/main.js"></script>
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
                <tr class="saturday-col bg-slate-600 text-white grid grid-cols-[200px_repeat(5,1fr)] items-stretch">
                    <th class="p-2">Mitarbeiter</th>
                    <th class="p-2">Montag<br><span class="font-light"><?= date("d.m") ?></span></th>
                    <th class="p-2">Dienstag<br><span class="font-light"><?= date("d.m") ?></span></th>
                    <th class="p-2">Mittwoch<br><span class="font-light"><?= date("d.m") ?></span></th>
                    <th class="p-2">Donnerstag<br><span class="font-light"><?= date("d.m") ?></span></th>
                    <th class="p-2">Freitag<br><span class="font-light"><?= date("d.m") ?></span></th>
                    <th class="p-2 saturday hidden">Samstag<br><span class="font-light"><?= date("d.m") ?></span></th>
                </tr>
                <?php for ($i = 0; $i < count($people); $i++) : ?>
                    <tr class="saturday-col job_counter bg-zinc-100 border-8 border-white grid grid-cols-[200px_repeat(5,1fr)] items-stretch">
                        <td class="week p-2 flex flex-row justify-between items-center gap-2"><?= $people[$i]; ?> <div class="personal_week p-2 shadow-md shadow-gray-400/50">0</div></td>
                        <?php for ($index = 0; $index <= 4; $index++) : ?>
                            <td class="p-2 relative flex h-full">
                                <div class="week_time text-end p-2 w-fit absolute right-2 top-2 bottom-2 shadow-md shadow-gray-400/50">0</div>
                            </td>
                        <?php endfor; ?>
                        <td class="saturday hidden p-2 relative flex h-full">
                            <div class="week_time text-end p-2 w-fit absolute right-2 top-2 bottom-2 shadow-md shadow-gray-400/50">0</div>
                        </td>
                    </tr>
                    <?php if ($people[$i] === $user ) : ?>
                        <tr class="saturday-col job_row-list grid grid-cols-[200px_repeat(5,1fr)] items-stretch">
                    <?php elseif ($people[$i] === 'Pool') : ?>
                        <tr class="saturday-col job_row-list grid grid-cols-[200px_repeat(5,1fr)] items-stretch show_pool">
                    <?php else : ?>
                        <tr class="saturday-col job_row-list grid grid-cols-[200px_repeat(5,1fr)] items-stretch hidden">
                    <?php endif;  ?>
                        <td class="week pb-4"></td>
                        <?php for ($index = 0; $index < 6; $index++) : ?>
                            <?php if($index === 5) : ?>
                                <td class="saturday hidden pb-4 flex h-full">
                            <?php else : ?>
                                <td class="pb-4 flex h-full">
                            <?php endif; ?>
                                <div class="job_container p-2 ml-2 border border-stone-300 flex flex-col justify-between h-full">
                                    <div class="job_list h-full"></div>
                                    <div class="mt-6 flex flex-row justify-between items-center gap-2">
                                        <input class="job_name p-2 border border-slate-200 w-3/6" type="text" placeholder="Neuer Job">
                                        <input class="job_time p-2 border border-slate-200 w-2/6" type="number" placeholder="Zeit" min="0" max="24">
                                        <input class="job_add p-2 w-1/6" type="submit" value="+">
                                    </div>
                                </div>
                            </td>
                        <?php endfor; ?>
                    </tr>
                <?php endfor; ?>
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