<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Eingeloggten Benutzer abrufen
$user = $_SESSION['user'];
$userId = $_SESSION['userId'];

// Admin / Pool Status abrufen
$admin = $_SESSION['is_admin'];
$pool = $_SESSION['is_pool'];

// Daten aus Datenbank abrufen
require_once "read.php";

// Aktuelles Datum und Kalenderwoche abrufen
$today = new DateTime(); // Datum als Objekt
$thisDay = date('d.m.');
$weekdayEnglish = date('l'); // Englischer Wochentag
$thisWeek = date("W"); // Aktuelle Kalenderwoche
$week = isset($_GET['week']) ? intval($_GET['week']) : date("W");  // week in URL vorhanden? -> Wenn ja Wert abrufen -> Wenn nein aktuelle Woche 
$year = date("Y"); // aktuelles Jahr

// Neue URL generieren
$url = "./wochenplan.php?week=";
$url .= $week;
$url .= "#user";

// Maximale Anzahl der Kalenderwochen des aktuellen Jahres
$lastDay = new DateTime("$year-12-28"); // 28.12. liegt immer in der letzten KW
$maxWeeks = $lastDay->format("W"); // Anzahl der Kalenderwochen dieses Jahres

// Englische Wochentage zu deutschen Wochentagen mappen
$weekdayGerman = [
    'Monday'    => 'Montag',
    'Tuesday'   => 'Dienstag',
    'Wednesday' => 'Mittwoch',
    'Thursday'  => 'Donnerstag',
    'Friday'    => 'Freitag',
    'Saturday'  => 'Samstag',
];
$weekdays = ['Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'];

// Aktuellen Wochentag in Deutsch abrufen
$weekday = $weekdayGerman[$weekdayEnglish];

// Datum für jeden Tag der Woche berechnen
$start = new DateTime();
$start->setISODate($year, $week, 1); // Setzt Montag der angegebenen Woche
$weekDates = [];

foreach ($weekdays as $day) {
    $weekDates[$day] = $start->format('d.m.'); // Format für Tabelle
    $start->modify('+1 day'); // Nächsten Tag berechnen
}

// Markierungen
$classToday = ' bg-amber-500'; // Heute
$classHoliday = ' bg-rose-900'; // Feiertag