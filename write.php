<?php
// Daten aus .env abrufen
require __DIR__ . '/vendor/autoload.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dsn = $_ENV['DB_DSN']; // um auf entsprechende Datenbank zugreifen zu können
$dbusername = $_ENV['DB_USERNAME'];
$dbpassword = $_ENV['DB_PASSWORD'];

try {
    $pdo = new PDO($dsn, $dbusername, $dbpassword); // Datenbank verbinden  --> Würde auch außerhalb von try catch funktionieren, dann aber keine Möglichkeit auf Fehler zu reagieren
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // Fehlercode setzen
} catch (PDOException $e) { // e = placeholder
    echo "Verbindung fehlgschlagen: " . $e->getMessage(); // e = PDOException
}