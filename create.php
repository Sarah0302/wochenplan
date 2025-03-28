<?php
require_once "helpers.php"; // Daten aus helpers.php werden eingebunden

try {
    require_once "write.php"; // Daten aus write.php werden eingebunden

    if (empty($_POST["time"])) :
        $_POST["time"] = 0;
    endif;

    if (!isset($_POST["personen_id"], $_POST["day"], $_POST["job"], $_POST["time"], $_POST["status"])) :
        echo 'Fehlende Formulardaten: ' . 
        '<script>
            setTimeout(function() {
                 window.location.href = "' . $url . '";
            }, 3000);
        </script>';
    endif;

    $personen_id = $_POST["personen_id"];
    $day = $_POST["day"];
    $job = $_POST["job"];
    $time = $_POST["time"];
    $status = $_POST["status"];

    // SQL-Query vorbereiten und ausführen
    $query = "INSERT INTO jobs (personen_id, day, job, time, status) VALUES (?, ?, ?, ?, ?)"; // jobs = Tabelle in welche die Daten geschrieben werden sollen & Werte müssen so heißen wie Spalten
    $stmt = $pdo->prepare($query); // stmt = statement
    $stmt->execute([$personen_id, $day, $job, $time, $status]); // stmt = statement

    // man wird auf die Startseite zurück geleitet
    header("Location: " . $url);
    exit;

} catch (PDOException $e) {
    // Fehlermeldung wird ausgegeben & nach 3 Sekunden (3000 Millisekunden) wird man auf die Startseite zurück geleitet
    echo 'Fehler beim Hinzufügen: ' . 
        $e->getMessage() . 
        '<script>
            setTimeout(function() {
                 window.location.href = "' . $url . '";
            }, 3000);
        </script>';
}
