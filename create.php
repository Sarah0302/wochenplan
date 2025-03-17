<?php
require_once "helpers.php"; // Daten aus helpers.php werden eingebunden

try {
    require_once "write.php"; // Daten aus write.php werden eingebunden

    if ($_POST["time"] === '') :
        $_POST["time"] = 0;
    endif;

    if (!isset($_POST["person"], $_POST["day"], $_POST["job"], $_POST["time"], $_POST["status"])) :
        echo "Fehlende Formulardaten!";
        exit;
    endif;

    $person = $_POST["person"];
    $day = $_POST["day"];
    $job = $_POST["job"];
    $time = $_POST["time"];
    $status = $_POST["status"];

    // SQL-Query vorbereiten und ausführen
    $query = "INSERT INTO jobs (person, day, job, time, status) VALUES (?, ?, ?, ?, ?)"; // jobs = Tabelle in welche die Daten geschrieben werden sollen & Werte müssen so heißen wie Spalten
    $stmt = $pdo->prepare($query); // stmt = statement
    $stmt->execute([$person, $day, $job, $time, $status]);

    // man wird auf die Startseite zurück geleitet
    header("Location: wochenplan.php?week=" . $week);
    exit;

} catch (PDOException $e) {
    // Fehlermeldung wird ausgegeben & nach 3 Sekunden (3000 Millisekunden) wird man auf die Startseite zurück geleitet
    echo 'Fehler beim Hinzufügen: ' . 
        $e->getMessage() . 
        '<script>
            setTimeout(function() {
                 window.location.href = "wochenplan.php?week=' . $week . '";
            }, 3000);
        </script>';
}
