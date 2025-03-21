<?php
require_once "helpers.php"; // Daten aus helpers.php werden eingebunden

if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Nur starten, wenn keine Session aktiv ist
}

// Prüfen, ob `openUser` im POST existiert und ein Array ist
if (isset($_POST['openUser']) && is_array($_POST['openUser'])) {
    $_SESSION['people_list'] = $_POST['openUser']; // Session-Variable setzen

    // Zurück zur Wochenplan-Seite
    header("Location: " . $url);
    exit;
} else {
    echo "<script>alert('Keine Daten gefunden! Bitte versuche es erneut.'); window.location.href = '" . $url . "';</script>";
    exit;
}
?>
