<?php
// Eingeloggten Benutzer und People-Array abrufen
$user = $_SESSION['user'];
// $people = $_SESSION['people'] ?? ["Pool"];
$people = ["Pool", "Alina", "Sarah", "Test 1"];

$weekdays = ['Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'];

// Datum für jeden Tag der Woche berechnen
$start = new DateTime();
$start->setISODate($year, $week, 1); // Setzt Montag der angegebenen Woche
$weekDates = [];

foreach ($weekdays as $day) {
    $weekDates[$day] = $start->format('d.m.'); // Format für Tabelle
    $start->modify('+1 day'); // Nächsten Tag berechnen
}

try {
    require_once "write.php";    // Daten aus write.php werden eingebunden

    $query = "SELECT id, person, day, job, time, status FROM jobs";
    $stmt = $pdo->query($query);
    $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC); // Alle Datensätze einmal abrufen und als Array speichern

    // Spalte für jede Person
    for ($i = 0; $i < count($people); $i++) : 
        echo '<tr class="saturday-col job_counter bg-zinc-100 border-8 border-white grid grid-cols-[200px_repeat(5,1fr)] items-stretch cursor-pointer">';
            echo '<td class="week cursor-pointer p-2 flex flex-row justify-between items-center gap-2">'. $people[$i] .'<div class="personal_week p-2 shadow-md shadow-gray-400/50">0</div></td>';

        // Zellen für jeden Tag
        for ($index = 0; $index <= 4; $index++) : 
            echo '<td class="p-2 relative flex h-full">';
                echo '<div class="week_time text-end p-2 w-fit absolute right-2 top-2 bottom-2 shadow-md shadow-gray-400/50">0</div>';
            echo '</td>';
        endfor;

            echo '<td class="saturday hidden p-2 relative flex h-full">';
                echo '<div class="week_time text-end p-2 w-fit absolute right-2 top-2 bottom-2 shadow-md shadow-gray-400/50">0</div>';
             echo '</td>';
        echo '</tr>';

        // Spalte für jeden Tag
        if ($people[$i] === $user) :
            echo '<tr class="saturday-col job_row-list grid grid-cols-[200px_repeat(5,1fr)] items-stretch">';
        elseif ($people[$i] === 'Pool') :
            echo '<tr class="saturday-col job_row-list grid grid-cols-[200px_repeat(5,1fr)] items-stretch show_pool">';
        else :
            echo '<tr class="saturday-col job_row-list grid grid-cols-[200px_repeat(5,1fr)] items-stretch hidden">';
        endif;

            echo '<td class="week cursor-pointer pb-4"></td>';

            foreach ($weekdays as $day) :
                if ($day === 'Samstag') :
                    echo '<td class="saturday hidden pb-4 flex h-full">';
                else :
                    echo '<td class="pb-4 flex h-full">';
                endif;

                    echo '<div class="job_container p-2 ml-2 border border-stone-300 flex flex-col justify-between h-full">';
                        echo '<div class="job_list h-full min-h-6 pb-6">'; // Job Liste
                            foreach ($jobs as $row) : // Daten abrufen

                                $updateid = $row['id'];
                                $person = $row['person'];
                                $job_day = $row['day'];
                                $job = $row['job'];
                                $time = $row['time'];
                                $status = $row['status'];

                                // echo '<br><br>';
                                // echo 'updateid: ' . $updateid;
                                // // echo 'person: ' . $person;
                                // // echo '<br>day: ' . $job_day;
                                // // echo '<br>job: ' . $job;
                                // // echo '<br>time: ' . $time;
                                // // echo '<br>status: ' . $status;
                                // echo '<br><br>';

                                if ($person === $people[$i] && $weekDates[$day] === $job_day) :
                                    echo '<div draggable="true" class="job_box mt-1 p-2 border border-slate-400" id="' . $updateid . '">
                                        <div class="flex flex-row gap-1">
                                            <input class="job_name_value border border-slate-200 p-2 w-full" type="text" value="' . $job . '">
                                            <input class="job_workload border border-slate-200 p-2 w-full" type="number" min="0" max="24" value="' . $time . '">
                                            <div class="job_safe hidden p-2 w-full"><img src="assets/images/update.svg" alt="update Job"></div>
                                        </div>
                                        <div class="flex flex-row gap-1 mt-1">
                                            <div class="job_done p-2 w-1/3">
                                                <img class="cursor-pointer w-[30px] h-auto cursor-pointer" src="assets/images/done.svg" alt="Job done">
                                            </div>
                                            <div class="job_delete p-2 w-1/3">
                                                <img class="cursor-pointer w-[30px] h-auto cursor-pointer" src="assets/images/delete.svg" alt="Job delete">
                                            </div>
                                            <div class="job_duplicate p-2 w-1/3">
                                                <img class="cursor-pointer w-[30px] h-auto cursor-pointer" src="assets/images/duplicate.svg" alt="Job duplizieren">
                                            </div>
                                        </div>
                                    </div>';
                                endif;
                            endforeach;
                        echo '</div>';

                        // Job hinzufügen
                        $status = 'test';
                        echo '<form method="post" class="flex flex-row justify-between items-center gap-2">';
                            // echo '<input id="updateid" name="updateid" type="text" value="'. $updateid .'" hidden>';
                            echo '<input id="person" name="person" type="text" value="'. $people[$i] .'" hidden>';
                            echo '<input id="day" name="day" type="text" value="'. $weekDates[$day] .'" hidden>';
                            echo '<input id="status" name="status" type="text" value="'. $status .'" hidden>';
                            echo '<input id="job" name="job" class="job_name p-2 border border-slate-200 w-3/6" type="text" placeholder="Neuer Job">';
                            echo '<input id="time" name="time" class="job_time p-2 border border-slate-200 w-2/6" type="number" placeholder="Zeit" min="0" max="24">';
                            echo '<input class="job_add p-2 w-1/6 text-lg border border-slate-200 bg-lime-200 cursor-pointer" type="submit" value="+">';
                        echo '</form>';

                    echo '</div>'; // job_container
                echo '</td>';
            endforeach;

        echo '</tr>';
    endfor;

} catch (PDOException $e) {
    // Fehlermeldung wird ausgegeben & nach 3 Sekunden (3000 Millisekunden) wird man auf die Startseite zurück geleitet
    echo 'Fehler beim Laden der Tabellen Inhalte: ' . 
        $e->getMessage() . 
        '<script>
            setTimeout(function() {
                 window.location.href = "wochenplan.php";
            }, 3000);
        </script>';
}