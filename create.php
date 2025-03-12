<?php
$person = $_POST["person"];
$day = $_POST["day"];
$job = $_POST["job"];
$time = $_POST["time"];
$status = $_POST["status"];

try {
    require_once "write.php";    // Daten aus write.php werden eingebunden

    if (!isset($_POST["person"], $_POST["day"], $_POST["job"], $_POST["time"], $_POST["status"])) :
        die("Fehlende Formulardaten!");
    endif;

    $query = "INSERT INTO jobs (person, day, job, time, status) VALUES (?, ?, ?, ?, ?);"; // jobs = Tabelle in welche die Daten geschrieben werden sollen & Werte müssen so heißen wie Spalten
    $stmt = $pdo->prepare($query);  // stmt = statement
    $stmt->execute([$person, $day, $job, $time, $status]);
    $pdo = null;
    $stmt = null;   // statement schließen

    // man wird auf die Startseite zurück geleitet
    echo '<script>window.location.href = "wochenplan.php";</script>';

} catch (PDOException $e) {
    // Fehlermeldung wird ausgegeben & nach 3 Sekunden (3000 Millisekunden) wird man auf die Startseite zurück geleitet
    echo 'Fehler beim Hinzufügen: ' . 
        $e->getMessage() . 
        '<script>
            setTimeout(function() {
                 window.location.href = "wochenplan.php";
            }, 3000);
        </script>';
}
