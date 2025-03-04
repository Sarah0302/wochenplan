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
        header
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
                    <th>Samstag</th>
                </tr>
                <?php $people = ["Pool", "Alina", "Sarah", "Emily"]; ?>
                <?php for ($i = 0; $i < count($people); $i++) : ?>
                    <tr class="job_counter_<?php $i; ?>">
                        <td><?= $people[$i]; ?> <div class="personal_week">0</div></td>
                        <td><div>0</div></td>
                        <td><div>0</div></td>
                        <td><div>0</div></td>
                        <td><div>0</div></td>
                        <td><div>0</div></td>
                        <td><div>0</div></td>
                    </tr>
                    <tr>
                        <td></td>
                        <?php for ($index = 0; $index < 6; $index++) : ?>
                            <td>
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
        footer
    </footer>
</body>
</html>