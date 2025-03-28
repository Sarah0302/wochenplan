<?php
require_once 'helpers.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['persons'])) :
    $personIds = $_POST['persons']; // Array mit IDs der ausgewählten Personen

    // IDs sicher in Platzhalter umwandeln (SQL Injection verhindern)
    $placeholders = implode(',', array_fill(0, count($personIds), '?'));

    try {
        require_once "write.php";    // Daten aus write.php werden eingebunden

        $pdo->beginTransaction(); // Transaktion starten (damit beide DELETE-Operationen sicher ausgeführt werden)

        // // Personen aus jobs löschen
        // $queryJobs = "DELETE FROM jobs WHERE personen_id IN ($placeholders)";
        // $stmtJobs = $pdo->prepare($queryJobs);
        // $stmtJobs->execute($personIds);

        // Personen aus personen löschen
        $queryPersons = "DELETE FROM personen WHERE personen_id IN ($placeholders)";
        $stmtPersons = $pdo->prepare($queryPersons);
        $stmtPersons->execute($personIds);

        // Transaktion abschließen
        $pdo->commit();

        // Erfolgreiche Weiterleitung
        header("Location: " . $url);
        exit;

    } catch (PDOException $e) {
            echo 'Fehler beim Löschen der Daten: ' .
                '<script>
                    setTimeout(function() {
                        window.location.href = "' . $url . '";
                    }, 3000);
                </script>';
    }

else :
    echo 'Kein Name zum löschen ausgewählt! ' .
        '<script>
            setTimeout(function() {
                 window.location.href = "' . $url . '";
            }, 3000);
        </script>';
endif;
?>
