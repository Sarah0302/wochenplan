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
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./assets/js/jquery-3.7.1.min.js"></script>
    <script src="./assets/js/glide.min.js"></script>
    <script src="./assets/js/main.js"></script>
    <script src="./assets/js/jobs.js"></script>
    <script src="./assets/js/slider.js"></script>
    <link href="./assets/css/tailwind.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/main.css">
    <link rel="stylesheet" href="./assets/css/glide.core.min.css">
        <!-- favicon -->
        <link rel="icon" type="image/png" href="./assets/images/favicon/favicon-96x96.png" sizes="96x96" />
        <link rel="icon" type="image/svg+xml" href="./assets/images/favicon/favicon.svg" />
        <link rel="shortcut icon" href="./assets/images/favicon/favicon.ico" />
        <link rel="apple-touch-icon" sizes="180x180" href="./assets/images/favicon/apple-touch-icon.png" />
        <link rel="manifest" href="./assets/images/favicon/site.webmanifest" />
    <title>Wochenplan</title>
</head>
<body class="bg-blue-500 text-white text-center p-10">
    <header>
        <button class="open_all">OPEN ALL</button>
        <button class="close_all">CLOSE ALL</button>
        <button class="saturday_button">Samstag anzeigen</button>
        <a href="logout.php">Logout</a>
    </header>
    <main>

    
    <!-- slider -->
    <div class="glide">
        <div class="glide__arrows" data-glide-el="controls">
            <button class="glide__arrow glide__arrow--left" data-glide-dir="&lt;">prev</button>
            <h1 class="text-white bg-blue-500 !important">Willkommen <?= $user; ?></h1>
            <button class="glide__arrow glide__arrow--right" data-glide-dir="&gt;">next</button>
        </div>
        <div class="glide__track" data-glide-el="track">
            <ul class="glide__slides">
            <li class="glide__slide" style="border: 1px solid red;">0</li>
            <li class="glide__slide" style="border: 1px solid red;">1</li>
            <li class="glide__slide" style="border: 1px solid red;">2</li>
            </ul>
        </div>
    </div>


        <div style="border: 1px solid red">
            <table>
                <tr>
                    <th>Mitarbeiter</th>
                    <th>Montag<br><?= date("d.m") ?></th>
                    <th>Dienstag</th>
                    <th>Mittwoch</th>
                    <th>Donnerstag</th>
                    <th>Freitag</th>
                    <th class="saturday hide">Samstag</th>
                </tr>
                <?php for ($i = 0; $i < count($people); $i++) : ?>
                    <tr class="job_counter">
                        <td class="week"><?= $people[$i]; ?> <div class="personal_week">0</div></td>
                        <td><div class="week_time">0</div></td>
                        <td><div class="week_time">0</div></td>
                        <td><div class="week_time">0</div></td>
                        <td><div class="week_time">0</div></td>
                        <td><div class="week_time">0</div></td>
                        <td class="saturday hide"><div class="week_time">0</div></td>
                    </tr>
                    <?php if ($people[$i] === $user ) : ?>
                        <tr class="job_row-list">
                    <?php elseif ($people[$i] === 'Pool') : ?>
                        <tr class="job_row-list show_pool">
                    <?php else : ?>
                        <tr class="job_row-list hide">
                    <?php endif;  ?>
                        <td class="week"></td>
                        <?php for ($index = 0; $index < 6; $index++) : ?>
                            <?php if($index === 5) : ?>
                                <td class="saturday hide">
                            <?php else : ?>
                                <td>
                            <?php endif; ?>
                                <div class="job_container" style="border: 1px solid green;">
                                    <ul class="job_list" style="border: 1px solid blue; min-height: 50px;"></ul>
                                    <div style="border: 1px solid orange; display: flex; flex-direction: row;">
                                        <input class="job_name" type="text" placeholder="Neuer Job">
                                        <input class="job_time" type="number" placeholder="Zeit" min="0" max="24">
                                        <input class="job_add" type="submit" value="+">
                                    </div>
                                </div>
                            </td>
                        <?php endfor; ?>
                    </tr>
                <?php endfor; ?>
            </table>
        </div>
    </main>
    <footer>
        <div style="background: lightgreen;">Fahrt</div>
        <div style="background: lightblue;">Homeoffice</div>
        <div style="background: yellow;">Kurzarbeit</div>
        <div style="background: orange;">Halber Tag</div>
        <div style="background: red;">Abwesend / Schule</div>
    </footer>
</body>
</html>