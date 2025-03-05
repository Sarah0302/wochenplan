<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="./assets/js/jquery-3.7.1.min.js"></script>
    <script src="./assets/js/main.js"></script>
    <link href="./assets/css/tailwind.css" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/main.css">
        <!-- favicon -->
    <title>Wochenplan</title>
</head>
<body class="bg-blue-500 text-white text-center p-10">
    <header>
        <button class="open_all">OPEN ALL</button>
        <button class="close_all">CLOSE ALL</button>
        <button class="saturday_button">Samstag anzeigen</button>
    </header>
    <main>
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
                <?php $people = ["Pool", "Alina", "Sarah", "Emily"]; ?>
                <?php for ($i = 0; $i < count($people); $i++) : ?>
                    <tr class="job_counter">
                        <td><?= $people[$i]; ?> <div class="personal_week">0</div></td>
                        <td><div class="week_time">0</div></td>
                        <td><div class="week_time">0</div></td>
                        <td><div class="week_time">0</div></td>
                        <td><div class="week_time">0</div></td>
                        <td><div class="week_time">0</div></td>
                        <td class="saturday hide"><div class="week_time">0</div></td>
                    </tr>
                    <tr class="job_row-list hide">
                        <td></td>
                        <?php for ($index = 0; $index < 6; $index++) : ?>
                            <?php if($index === 5) : ?>
                                <td class="saturday hide">
                            <?php else : ?>
                                <td>
                            <?php endif; ?>
                                <div class="job_container" style="border: 1px solid green; margin: 100px 0;">
                                    <ul class="job_list"></ul>
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