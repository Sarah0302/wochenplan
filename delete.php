<?php

$deleteid = $_POST["deleteid"];

try {
    require_once "write.php";    // Daten aus write.php werden eingebunden

    $query = "DELETE FROM jobs WHERE id = ?";
    $stmt = $pdo->prepare($query);  // stmt = statement
    $stmt->execute([$deleteid]);
    $rowCount = $stmt->rowCount(); // Anzahl der gelöschten Datensätze abrufen

    if ($rowCount > 0) { 
        echo '<script>window.location.href = "wochenplan.php";</script>';
    } else {
        echo 'Fehler' . 
            $e->getMessage() . 
            '<script>
                setTimeout(function() {
                    window.location.href = "wochenplan.php";
                }, 3000);
            </script>';
    }
} catch (PDOException $e) {
        echo 'Fehler beim Löschen der Daten: ' . 
            $e->getMessage() . 
            '<script>
                setTimeout(function() {
                    window.location.href = "wochenplan.php";
                }, 3000);
            </script>';
}
?>
