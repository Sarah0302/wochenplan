<?php
// Funktion
function getHoliday($apiUrl) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    if ($httpCode == 200 && $response) {
        return json_decode($response, true);
    } else {
        echo "Fehler: HTTP-Statuscode $httpCode<br>";
        echo "Antwort: $response<br>";
        return [];
    }
}

// Daten
$country = 'DE';
$state = $country . '-BW';
$validFrom = date("Y-01-01");
$validTo = date("Y-12-31");
$apiUrl = "https://openholidaysapi.org/PublicHolidays?countryIsoCode=$country&subdivisionCode=$state&validFrom=$validFrom&validTo=$validTo";

// Feiertage abrufen
$holidays = getHoliday($apiUrl);

// Datum und Name extrahieren
$feiertage = array();
foreach ($holidays as $holiday) {
    $holidayName = ''; // Feiertagsname auf Deutsch extrahieren
    foreach ($holiday['name'] as $name) {
        if ($name['language'] === 'DE') {
            $holidayName = $name['text'];
            break;
        }
    }

    // Datum formatieren
    $date = strtotime($holiday['startDate']); // In Unix-Timestamp umwandeln
    $holidayDate = date("d.m", $date); // Format: Tag.Monat

    // Feiertag ins Array speichern (Datum => Feiertagsname)
    $feiertage[$holidayDate] = $holidayName;
}

// Debugging: Feiertage ausgeben
echo 'Feiertage:<br>';
print_r($feiertage);
?>