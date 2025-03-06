<?php
session_start();

// Daten aus .env abrufen
require __DIR__ . '/vendor/autoload.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Anzahl der Benutzer auslesen
$userCount = intval($_ENV['USER_COUNT']);
$people = ["Pool"]; // Standard-Eintrag
$users = [];

// Nutzer aus .env auslesen
for ($i = 1; $i <= $userCount; $i++) {
    $usernameKey = "USER_{$i}_USERNAME";
    $passwordKey = "USER_{$i}_PASSWORD";

    if (isset($_ENV[$usernameKey]) && !empty($_ENV[$usernameKey])) {
        $people[] = $_ENV[$usernameKey]; // Mitarbeiter in Liste hinzufügen
        $users[$_ENV[$usernameKey]] = $_ENV[$passwordKey] ?? ''; // Nutzer+Passwort speichern
    }
}

// Login-Überprüfung
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    if (isset($users[$username]) && $users[$username] === $password) {
        $_SESSION['user'] = $username; // Eingeloggten Benutzer speichern
        $_SESSION['people'] = $people; // Personenliste speichern

        // Erfolgreiche Anmeldung -> Weiterleitung
        header("Location: wochenplan.php");
        exit;
    } else { // Login fehlgeschlagen 
        echo "<script>alert('Anmeldung fehlgeschlagen! Bitte versuche es erneut.'); window.location.href='./index.php';</script>";
        exit;
    }
}
?>
