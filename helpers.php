<?php
// Eingeloggten Benutzer und People-Array abrufen
$user = $_SESSION['user'];
// $people = $_SESSION['people'] ?? ["Pool"];
$people = ["Pool", "Alina", "Sarah", "Test 1"];

// Aktuelles Datum und Kalenderwoche abrufen
$today = new DateTime(); // Datum als Objekt
$thisDay = date('d.m.');
$weekdayEnglish = date('l'); // Englischer Wochentag
$thisWeek = date("W"); // Aktuelle Kalenderwoche
$week = isset($_GET['week']) ? intval($_GET['week']) : date("W");  // week in URL vorhanden? -> Wenn ja Wert abrufen -> Wenn nein aktuelle Woche 
$year = date("Y"); // aktuelles Jahr

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
// $holiday = ' bg-rose-900'; // Feiertag