<?php

$dsn = "mysql:host=localhost;dbname=wochenplan"; // um auf entsprechende Datenbank zugreifen zu können
$dbusername = "root";
$dbpassword = "root";

try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword); // Datenbank verbinden  --> Würde auch außerhalb von try catch funktionieren, dann aber keine Möglichkeit auf Fehler zu reagieren
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // Fehlercode setzen
} catch (PDOException $e) { // e = placeholder
    echo "Verbindung fehlgschlagen: " . $e->getMessage(); // e = PDOException
}