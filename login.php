<?php
require_once "user.php";

session_start();

// Aktuelle Kalenderwoche abrufen
$week = date("W");
$url = "./wochenplan.php?week=";
$url .= $week;
$url .= "#user";

// Login-Überprüfung
if ($_SERVER['REQUEST_METHOD'] === 'POST') :
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    $userIndex = array_search($username, array_column($people, 'name')); // Prüfen ob es den Benutzernamen in der Datenbank gibt

    if( $userIndex !== false ) :
        $hashedPassword = $people[$userIndex]['passwort']; // Das passende Passwort aus der Datenbank abrufen
        $admin = $people[$userIndex]['is_admin'];
        $userid = $people[$userIndex] ['personen_id'];

        if( password_verify($password, $hashedPassword) ) : // Prüfen ob Passwort stimmt
            $_SESSION['user'] = $username; // Eingeloggten Benutzer speichern
            $_SESSION['userId'] = $userid; // Eingeloggte Benutzer ID speichern
            $_SESSION['is_admin'] = $admin; // Speichern ob Admin
        endif;

        // Erfolgreiche Anmeldung -> Weiterleitung
        header("Location: " . $url);
        
    else : // Login fehlgeschlagen
        echo "<script>alert('Anmeldung fehlgeschlagen! Bitte versuche es erneut.'); window.location.href='./index.php';</script>";
        exit;
    endif;
endif;
?>
