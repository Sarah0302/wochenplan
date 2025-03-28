<?php
$week = isset($_GET['week']) ? intval($_GET['week']) : date("W");  // week in URL vorhanden? -> Wenn ja Wert abrufen -> Wenn nein aktuelle Woche 
$url = "./wochenplan.php?week=";
$url .= $week;
$url .= "#user";

try {
    require_once "write.php";    // Daten aus write.php werden eingebunden

    $query = "SELECT personen_id, name, passwort, is_admin FROM personen";
    $stmt = $pdo->query($query);
    $userDB = $stmt->fetchAll(PDO::FETCH_ASSOC); // Alle Datensätze aus der Datenbank einmal abrufen und als Array speichern

    // Pool an den Anfang des Arrays setzen
    $poolArray = null;
    $peopleArray = [];

    foreach($userDB as $person) :
        if ($person['name'] === 'Pool') :
            $poolArray = $person; // Speichert Pool separat
        else :
            $peopleArray[] = $person;  // Alle anderen Nutzer
        endif;
    endforeach;

    // Nutzer alphabetisch nach name sortieren
    usort($peopleArray, function ($a, $b) {
        return strcmp(strtolower($a['name']), strtolower($b['name']));
    });
    
    // Array zur Weiterverarbeitung speichern
    $people = $poolArray ? array_merge([$poolArray], $peopleArray) : $peopleArray;

} catch (PDOException $e) {
    // Fehlermeldung wird ausgegeben & nach 3 Sekunden (3000 Millisekunden) wird man auf die Startseite zurück geleitet
    echo 'Fehler beim Laden der Personen: ' . 
        $e->getMessage() . 
        '<script>
            setTimeout(function() {
                 window.location.href = "' . $url . '";
            }, 3000);
        </script>';
}