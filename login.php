<?php
require_once "user.php";

session_start();

// Aktuelle Kalenderwoche abrufen
$week = date("W");

// Login-Überprüfung
if ($_SERVER['REQUEST_METHOD'] === 'POST') :
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $userIndex = array_search($username, array_column($people, 'name')); // Prüfen ob es den Benutzernamen in der Datenbank gibt

    if( $userIndex !== false ) :
        $hashedPassword = $people[$userIndex]['passwort']; // Das passende Passwort aus der Datenbank abrufen

        if( password_verify($password, $hashedPassword) ) : // Prüfen ob Passwort stimmt
            $_SESSION['user'] = $username; // Eingeloggten Benutzer speichern
        endif;

        // Erfolgreiche Anmeldung -> Weiterleitung
        header("Location: wochenplan.php?week=" . $week);
        
    else : // Login fehlgeschlagen
        echo "<script>alert('Anmeldung fehlgeschlagen! Bitte versuche es erneut.'); window.location.href='./index.php';</script>";
        exit;
    endif;
endif;
?>
