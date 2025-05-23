<?php
require_once "helpers.php"; // Daten aus helpers.php werden eingebunden

if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Nur starten, wenn keine Session aktiv ist
}

// Alle geöffneten User aus der open-user.php
$openUsers = isset($_SESSION['people_list']) ? $_SESSION['people_list'] : [];

// Admin aus dem Array löschen, da er keine Zeile benötigt
$people = array_filter($people, function($person) {
    return intval($person['is_admin']) !== 1;
});    
$people = array_values($people); // Neu indexieren um Lücken zu vermeiden

    // Spalte für jede Person
    for ($i = 0; $i < count($people); $i++) : 
        if ($people[$i]['personen_id'] === $userId) : // Wenn angemeldeter User
            echo '<tr id="user" class="saturday-col job_counter bg-zinc-100 mt-4 grid grid-cols-[200px_repeat(5,1fr)] items-stretch cursor-pointer">';
        else : 
            echo '<tr class="saturday-col job_counter bg-zinc-100 mt-4 grid grid-cols-[200px_repeat(5,1fr)] items-stretch cursor-pointer">';
        endif;

            echo '<td class="cursor-pointer p-2 flex flex-row justify-between items-center gap-2"><span class="person_name">'. $people[$i]['name'] .'</span><span class="personen_id hidden">'. $people[$i]['personen_id'] .'</span><div class="personal_week p-2 shadow-md shadow-gray-400/50">0</div></td>';

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
        if (in_array($people[$i]['personen_id'], $openUsers)) : // Wenn User in Array zuvor geöffneter User enthalten
            echo '<tr class="saturday-col list-col job_row-list mt-2 grid grid-cols-[200px_repeat(5,1fr)] items-stretch">';
        elseif (intval($people[$i]['is_pool']) === 1) :
            echo '<tr class="saturday-col list-col job_row-list mt-2 grid grid-cols-[200px_repeat(5,1fr)] items-stretch show_pool">';
        else :
            echo '<tr class="saturday-col list-col job_row-list mt-2 grid grid-cols-[200px_repeat(5,1fr)] items-stretch hidden">';
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
                            foreach ($jobs as $row) : // Daten aus Datenbank abrufen

                                $updateid = $row['job_id'];
                                $personen_id = $row['personen_id'];
                                $job_day = $row['day'];
                                $job = $row['job'];
                                $time = $row['time'];
                                $status = $row['status'];

                                if ($personen_id === $people[$i]['personen_id'] && $weekDates[$day] === $job_day) :
                                    echo '<div draggable="true" class="job_box cursor-grab mt-1 p-2 border border-slate-400" id="' . $updateid . '">
                                        <div class="job_inputs flex flex-row gap-1">
                                            <input id="updateJob" name="updateJob" class="job_name_value border border-slate-200 p-2 w-full" type="text" value="' . $job . '">
                                            <input id="updateTime" name="updateTime" class="job_workload border border-slate-200 p-2 w-full" type="number" min="0" max="24" value="' . $time . '">
                                            <input id="updatePerson" name="updatePerson" type="text" value="' . $personen_id . '" hidden>
                                            <input id="updateDay" name="updateDay" type="text" value="' . $job_day . '" hidden>
                                            <input id="updateStatus" name="updateStatus" type="text" value="' . $status . '" hidden>
                                            <div class="job_safe hidden p-2 w-full flex align-center justify-center">
                                                <img class="cursor-pointer w-[25px] h-auto cursor-pointer" src="assets/images/update.svg" alt="update Job">
                                            </div>
                                        </div>
                                        <div class="flex flex-row gap-1 mt-1">
                                            <div class="job_done p-2 w-1/3 flex align-center justify-start">
                                                <img class="cursor-pointer w-[30px] h-auto cursor-pointer" src="assets/images/done.svg" alt="Job done">
                                            </div>
                                            <div class="job_delete p-2 w-1/3 flex align-center justify-center">
                                                <img class="cursor-pointer w-[30px] h-auto cursor-pointer" src="assets/images/delete.svg" alt="Job delete">
                                            </div>
                                            <div class="job_duplicate p-2 w-1/3 flex align-center justify-end">
                                                <img class="cursor-pointer w-[30px] h-auto cursor-pointer" src="assets/images/duplicate.svg" alt="Job duplizieren">
                                            </div>
                                        </div>
                                    </div>';
                                endif;
                            endforeach;
                        echo '</div>';

                        // Job hinzufügen
                        $status = 'open';
                        echo '<form method="post" id="addJob-form" class="flex flex-row justify-between items-center gap-2">';
                            echo '<input id="addPersonenId" name="addPersonenId" type="text" value="'. $people[$i]['personen_id'] .'" hidden>';
                            echo '<input id="addDay" name="addDay" type="text" value="'. $weekDates[$day] .'" hidden>';
                            echo '<input id="addStatus" name="addStatus" type="text" value="'. $status .'" hidden>';
                            echo '<input id="addJob" name="addJob" class="job_name p-2 border border-slate-200 w-3/6" type="text" placeholder="Neuer Job">';
                            echo '<input id="addTime" name="addTime" class="job_time p-2 border border-slate-200 w-2/6" type="number" placeholder="Zeit" min="0" max="24">';
                            echo '<input class="job_add p-2 w-1/6 text-lg border border-slate-200 bg-lime-200 cursor-pointer" type="submit" value="+">';
                        echo '</form>';

                    echo '</div>';
                echo '</td>';
            endforeach;

        echo '</tr>';
    endfor;