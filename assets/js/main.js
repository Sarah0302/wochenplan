jQuery(document).ready(function() {

    // FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  
    function setList($jobListe, jobName, jobTime) {
        var $job = $(`
            <div class="job_box" style="border: 1px solid blue; display: flex; flex-direction: row;">
                <div class="job_done" style="background: green; padding: 5px; cursor: pointer;">erledigt</div>
                <input type="text" value="${jobName}">
                <input class="job_workload" type="text" value="${jobTime}">
                <div class="job_safe" style="background: lightblue; padding: 5px; cursor: pointer;">aktualisieren</div>
                <div class="job_delete" style="background: red; padding: 5px; cursor: pointer;">löschen</div>
            </div>
        `);
        $jobListe.append($job);
    }

    function workload($dayCounter, $weekCounter, newDayVal, newWeekVal) {
        if (newDayVal >= 8) {
            $dayCounter.css({ background: 'red', });
        } else if (newDayVal >= 6) {
            $dayCounter.css({ background: 'yellow', });
        } else {
            $dayCounter.css({ background: 'green', });
        }

        if (newWeekVal >= 40) {
            $weekCounter.css({ background: 'red', });
        } else if (newWeekVal >= 32) {
            $weekCounter.css({ background: 'yellow', });
        } else {
            $weekCounter.css({ background: 'green', });
        }
    }

    function TimeCounter($container) {
        var columnIndex = $container.closest("td").index(); // Index der Spalte
        var $rowAbove = $container.closest("tr").prev(); // Die Zeile über der Job-Liste
        var $dayCounter = $rowAbove.find("td").eq(columnIndex).find(".week_time"); // Das Tages-Count-Element
        var $weekCounter = $rowAbove.find(".personal_week"); // Das Wochen-Count-Element
        var newDayVal = 0;
        var newWeekVal = 0;

        // Berechne Tageszeit für diese Spalte
        $container.find(".job_workload").each(function() {
            newDayVal += parseFloat($(this).val()) || 0;
        });
        $dayCounter.text(newDayVal.toFixed(1)); // Zur Tagesübersicht hinzufügen

        // Berechne Wochenzeit für alle Tage dieser Person
        $rowAbove.find(".week_time").each(function() {
            newWeekVal += parseFloat($(this).text()) || 0;
        });
        $weekCounter.text(newWeekVal.toFixed(1)); // Zur Wochenübersicht hinzufügen

        workload($dayCounter, $weekCounter, newDayVal, newWeekVal); // Einfärbung
    }

    // KLICK EVENTS  KLICK EVENTS  KLICK EVENTS  KLICK EVENTS  KLICK EVENTS  KLICK EVENTS  KLICK EVENTS  KLICK EVENTS  KLICK EVENTS  KLICK EVENTS  
    $(".job_add").click(function() {
        // Werte abrufen
        var $container = $(this).closest(".job_container");
        var $jobListe = $container.find(".job_list");
        var jobName = $container.find(".job_name").val();
        var jobTime = parseFloat($container.find(".job_time").val()) || 0;

        if (jobName != '') {
            // Job zur Liste hinzufügen
            setList($jobListe, jobName, jobTime);

            // Hinzufügen Felder leeren
            $(".job_name").val('');
            $(".job_time").val('');

            TimeCounter($container); // Zeiten zusammenzählen
        };

    });

    $(document).on("click", ".job_delete", function() {
        var jobBox = $(this).closest(".job_box");
        var $container = jobBox.closest(".job_container"); // Die umgebende Container-Struktur
    
        jobBox.remove(); // Element entfernen
        TimeCounter($container); // Zeiten zusammenzählen
    }); 

    $(document).on("click", ".job_safe", function() {
        var $container = $(this).closest(".job_container");
        TimeCounter($container); // Zeiten aktualisieren
    });    

});