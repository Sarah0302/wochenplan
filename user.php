<?php
require_once "helpers.php"; // Daten aus helpers.php werden eingebunden

try {
    require_once "write.php";    // Daten aus write.php werden eingebunden

    $query = "SELECT id, name, passwort FROM personen";
    $stmt = $pdo->query($query);
    $people = $stmt->fetchAll(PDO::FETCH_ASSOC); // Alle Datensätze aus der Datenbank einmal abrufen und als Array speichern

} catch (PDOException $e) {
    // Fehlermeldung wird ausgegeben & nach 3 Sekunden (3000 Millisekunden) wird man auf die Startseite zurück geleitet
    echo 'Fehler beim Laden der Personen: ' . 
        $e->getMessage() . 
        '<script>
            setTimeout(function() {
                 window.location.href = "wochenplan.php?week=' . $week . '";
            }, 3000);
        </script>';
}