<?php
try {
    require_once "write.php";    // Daten aus write.php werden eingebunden

    // Alle Datensätze aus der Datenbank (personen) einmal abrufen und als Array speichern
    $personenQuery = "SELECT personen_id, name, passwort, is_admin, is_pool FROM personen";
    $stmt = $pdo->query($personenQuery);
    $userDB = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $poolArray = null;
    $peopleArray = [];

    foreach($userDB as $person) :
        if (intval($person['is_pool']) === 1) :
            $poolArray = $person; // Speichert Pool separat
        else :
            $peopleArray[] = $person;  // Alle anderen Nutzer
        endif;
    endforeach;

    usort($peopleArray, function ($a, $b) { // Nutzer alphabetisch nach name sortieren
        return strcmp(strtolower($a['name']), strtolower($b['name']));
    });

    $people = $poolArray ? array_merge([$poolArray], $peopleArray) : $peopleArray; // Pool an den Anfang des Arrays setzen

    // Alle Datensätze aus der Datenbank (jobs) einmal abrufen und als Array speichern
    $jobsQuery = "SELECT job_id, personen_id, day, job, time, status FROM jobs";
    $stmt = $pdo->query($jobsQuery);
    $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    // Fehlermeldung wird ausgegeben & nach 3 Sekunden (3000 Millisekunden) wird man auf die Startseite zurück geleitet
    echo 'Fehler beim Laden der Datenbank Inhalte: ' . 
        $e->getMessage() . 
        '<script>
            setTimeout(function() {
                 window.location.href = "' . $url . '";
            }, 3000);
        </script>';
}