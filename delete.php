<?php
require_once "helpers.php"; // Daten aus helpers.php werden eingebunden

$deleteid = $_POST["deleteid"];

try {
    require_once "write.php";    // Daten aus write.php werden eingebunden

    $query = "DELETE FROM jobs WHERE job_id = ?";
    $stmt = $pdo->prepare($query);  // stmt = statement
    $stmt->execute([$deleteid]);
    $rowCount = $stmt->rowCount(); // Anzahl der gelöschten Datensätze abrufen

    if ($rowCount > 0) { 
        echo '<script>window.location.href = "' . $url . '";</script>';
    } else {
        echo 'Fehler' . 
            $e->getMessage() . 
            '<script>
                setTimeout(function() {
                    window.location.href = "' . $url . '";
                }, 3000);
            </script>';
    }
} catch (PDOException $e) {
        echo 'Fehler beim Löschen der Daten: ' . 
            $e->getMessage() . 
            '<script>
                setTimeout(function() {
                    window.location.href = "' . $url . '";
                }, 3000);
            </script>';
}
?>
