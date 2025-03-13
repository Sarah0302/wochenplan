<?php
require_once "helpers.php"; // Daten aus helpers.php werden eingebunden

$updateId = $_POST["updateid"];
$updatePerson = $_POST["updatePerson"];
$updateDay = $_POST["updateDay"];
$updateJob = $_POST["updateJob"];
$updateTime = $_POST["updateTime"];
$updateStatus = $_POST["updateStatus"];

try {
    require_once "write.php";    // Daten aus write.php werden eingebunden

    $query = "UPDATE jobs SET person = ?, day = ?, job = ?, time = ?, status = ? WHERE id = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$updatePerson, $updateDay, $updateJob, $updateTime, $updateStatus, $updateId]);
    $rowCount = $stmt->rowCount();

    if ($rowCount > 0) { 
        header("Location: wochenplan.php?week=" . $week);
        exit;
    } else {
        echo 'Kein Datensatz mit diesem Namen gefunden' .
            '<script>
                setTimeout(function() {
                    window.location.href = "wochenplan.php?week=' . $week . '";
                }, 3000);
            </script>';
    }
} catch (PDOException $e) {
        echo 'Fehler beim Ändern der Daten: ' . 
            $e->getMessage() . 
            '<script>
                setTimeout(function() {
                    window.location.href = "wochenplan.php?week=' . $week . '";
                }, 3000);
            </script>';
}
?>
