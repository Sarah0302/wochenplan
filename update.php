<?php
require_once "helpers.php"; // Daten aus helpers.php werden eingebunden

$updateId = $_POST["updateid"];
$updatePersonen_id = $_POST["updatePerson"];
$updateDay = $_POST["updateDay"];
$updateJob = $_POST["updateJob"];
$updateTime = $_POST["updateTime"];
$updateStatus = $_POST["updateStatus"];

try {
    require_once "write.php";    // Daten aus write.php werden eingebunden

    $query = "UPDATE jobs SET personen_id = ?, day = ?, job = ?, time = ?, status = ? WHERE job_id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$updatePersonen_id, $updateDay, $updateJob, $updateTime, $updateStatus, $updateId]);
    $rowCount = $stmt->rowCount();

    if ($rowCount > 0) { 
        header("Location: " . $url);
        exit;
    } else {
        echo 'Kein Datensatz mit diesem Namen gefunden' .
            '<script>
                setTimeout(function() {
                    window.location.href = "' . $url . '";
                }, 3000);
            </script>';
    }
} catch (PDOException $e) {
        echo 'Fehler beim Ändern der Daten: ' . 
            $e->getMessage() . 
            '<script>
                setTimeout(function() {
                    window.location.href = "' . $url . '";
                }, 3000);
            </script>';
}
?>
