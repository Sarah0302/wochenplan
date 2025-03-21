<?php
session_start();

// Prüfen ob Benutzer angemeldet ist
if(!isset($_SESSION['user'])) :
    header("Location: index.php");
    exit;
endif;

require_once "helpers.php"; // Daten aus helpers.php werden eingebunden
require_once "holiday.php";

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
        <a class="cursor-pointer" href="<?= $url; ?>">
            <img class="h-10 object-contain cursor-pointer" src="./assets/images/logo.png" alt="Logo SDV">
        </a>
        <button class="open_all bg-zinc-300 pt-2 pr-4 pb-2 pl-4 shadow-md shadow-gray-400/50">alle öffnen</button>
        <button class="close_all bg-zinc-300 pt-2 pr-4 pb-2 pl-4 shadow-md shadow-gray-400/50">alle schließen</button>
        <button class="saturday_button bg-zinc-300 pt-2 pr-4 pb-2 pl-4 shadow-md shadow-gray-400/50">Samstag anzeigen</button>
        <div>
            <label class="pr-2" for="selectKW">Kalenderwoche:</label>
            <select id="selectKW" name="selectKW" class="bg-zinc-300 p-2 shadow-md shadow-gray-400/50">
                <?php for($kw = 1; $kw <= $maxWeeks; $kw++) : ?>
                    <?php if($kw === $week) : ?>
                        <option selected value="<?= $kw; ?>"><?= $kw; ?></option>
                    <?php else : ?>
                        <option value="<?= $kw; ?>"><?= $kw; ?></option>
                    <?php endif; ?>
                <?php endfor; ?>
            </select>
        </div>
        <a href="logout.php">Abmelden</a>
    </header>
    <main class="p-4">
        <?php if($user === 'Admin') : ?> <!-- Nur für Admin sichtbar -->
            <div class="flex flex-row justify-evenly items-start gap-4 w-[50vw] m-auto">
                <div class="border border-slate-400 p-2 mb-10 w-full">
                    <h2 class="text-3xl pb-2 text-center">Person hinzufügen</h2>
                    <form method="POST" action="add-person.php">
                        <input class="w-full p-2 mt-2 border border-slate-300" type="text" id="addName" name="addName" placeholder="Namen der Person">
                        <input class="w-full p-2 mt-2 border border-slate-300" type="password" id="passwordPerson" name="passwordPerson" placeholder="Passwort der Person">
                        <input class="w-full p-2 mt-2 border border-slate-300 bg-slate-300 cursor-pointer duration-300 ease-in-out hover:bg-slate-500 hover:text-white" type="submit" id="submitPerson" value="Person hinzufügen">
                    </form>
                </div>
                <div class="border border-slate-400 p-2 mb-10 w-full">
                    <?php require_once "user.php"; 
                        // Admin und Pool aus dem Array löschen, da sie nicht gelöscht werden dürfen
                        $filteredPeople = array_filter($people, function($person) {
                            return $person['name'] !== 'Admin' && $person['name'] !== 'Pool';
                        });
                        $filteredPeople = array_values($filteredPeople); // Neu indexieren um Lücken zu vermeiden
                    ?>
                    <h2 class="text-3xl pb-2 text-center">Person(en) löschen</h2>
                    <form method="POST" action="delete-person.php" class="flex flex-col justify-center">
                        <?php foreach($filteredPeople as $person) : ?>
                            <div class="flex flex-row gap-2">
                                <input type="checkbox" name="persons[]" value="<?= $person['id']; ?>" id="person_<?= $person['id']; ?>">
                                <label for="person_<?= $person['id']; ?>"><?= $person['name']; ?></label>
                            </div>
                        <?php endforeach; ?>
                        <input type="submit" value="Person(en) aus Datenbank löschen" class="w-full p-2 mt-2 border border-slate-300 bg-slate-300 cursor-pointer duration-300 ease-in-out hover:bg-slate-500 hover:text-white">
                    </form>
                </div>
            </div>
        <?php endif; ?>
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
                            $date = '';
                            if ($day === $weekday && $weekDates[$day] === $thisDay) :
                                $class = $classToday; 
                            endif;
                            if ($day === 'Samstag') :
                                $class .= ' saturday hidden'; 
                            endif;
                            if (isset($feiertage[$weekDates[$day]])) :
                                $class .= $classHoliday;
                                $date .= '<br><span class="font-extralight">' . $feiertage[$weekDates[$day]] . '</span>';
                            endif;
                        ?>
                        <th class="p-2<?= $class; ?>"><?= $day; ?><br><span class="date font-light"><?= $weekDates[$day]; ?></span><?= $date; ?></th>
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