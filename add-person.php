<?php
require_once "helpers.php"; // Daten aus helpers.php werden eingebunden

if ($_SERVER['REQUEST_METHOD'] === 'POST') :
    $newUsername = $_POST['addName'] ?? '';
    $newPassword = $_POST['passwordPerson'] ?? '';
    $is_admin = 0; // Kein Admin Status

    $hash = password_hash($newPassword, PASSWORD_DEFAULT);

    try {
        require_once "write.php"; // Daten aus write.php werden eingebunden

        if (empty($newUsername) || empty($newPassword)) :
            echo 'Fehlende Formulardaten: ' . 
            '<script>
                setTimeout(function() {
                    window.location.href = "' . $url . '";
                }, 3000);
            </script>';
        endif;

        $hash = password_hash($newPassword, PASSWORD_DEFAULT); // Passwort gehased in Datenbank schreiben

        // SQL-Query vorbereiten und ausführen
        $query = "INSERT INTO personen (name, passwort, is_admin) VALUES (?, ?, ?)"; // jobs = Tabelle in welche die Daten geschrieben werden sollen & Werte müssen so heißen wie Spalten
        $stmt = $pdo->prepare($query); // stmt = statement
        $stmt->execute([$newUsername, $hash, $is_admin]);

        // man wird auf die Startseite zurück geleitet
        header("Location: " . $url);
        exit;

    } catch (PDOException $e) {
        // Fehlermeldung wird ausgegeben & nach 3 Sekunden (3000 Millisekunden) wird man auf die Startseite zurück geleitet
        echo 'Fehler beim Hinzufügen einer neuen Person: ' . 
            $e->getMessage();
            '<script>
                setTimeout(function() {
                    window.location.href = "' . $url . '";
                }, 3000);
            </script>';
    }    

endif;