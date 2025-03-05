jQuery(document).ready(function() {

    // FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  
    function setList($jobListe, jobName, jobTime) {
        var $job = $(`
            <div class="job_box" style="border: 1px solid blue; display: flex; flex-direction: row;">
                <div class="job_done" style="background: green; padding: 5px; cursor: pointer;">erledigt</div>
                <input type="text" value="${jobName}">
                <input type="text" value="${jobTime}">
                <div class="job_delete" style="background: red; padding: 5px; cursor: pointer;">löschen</div>
            </div>
        `);

        $jobListe.append($job);
    }

    function workload($counter, $counterWeek, newVal, newValWeek) {
        if (newVal >= 8) {
            $counter.css({ background: 'red', });
        } else if (newVal >= 6) {
            $counter.css({ background: 'yellow', });
        } else {
            $counter.css({ background: 'green', });
        }

        if (newValWeek >= 40) {
            $counterWeek.css({ background: 'red', });
        } else if (newValWeek >= 32) {
            $counterWeek.css({ background: 'yellow', });
        } else {
            $counterWeek.css({ background: 'green', });
        }
    }

    function TimeCounter($container, jobTime) {
        // Die aktuelle Spalte und Zeile ermitteln
        var columnIndex = $container.closest("td").index(); // Index der Spalte
        var $rowAbove = $container.closest("tr").prev(); // Die Zeile über der Job-Liste
        var $counter = $rowAbove.find("td").eq(columnIndex).find("div"); // Das Tages-Count-Element
        var $counterWeek = $rowAbove.find(".personal_week"); // Das Wochen-Count-Element

        var currentVal = parseFloat($counter.text()) || 0;
        var newVal = currentVal + parseFloat(jobTime);

        var currentValWeek = parseFloat($counterWeek.text()) || 0;
        var newValWeek = currentValWeek + parseFloat(jobTime);

        $counter.text(newVal.toFixed(1)); // Zur Tagesübersicht hinzufügen
        $counterWeek.text(newValWeek.toFixed(1)); // Zur Wochenübersicht hinzufügen

        workload($counter, $counterWeek, newVal, newValWeek); // Einfärbung
    }

    function TimeCounterRemove($container, jobTime) {
        // Die aktuelle Spalte und Zeile ermitteln
        var columnIndex = $container.closest("td").index(); // Index der Spalte
        var $rowAbove = $container.closest("tr").prev(); // Die Zeile über der Job-Liste
        var $counter = $rowAbove.find("td").eq(columnIndex).find("div"); // Das Tages-Count-Element
        var $counterWeek = $rowAbove.find(".personal_week"); // Das Wochen-Count-Element

        var currentVal = parseFloat($counter.text()) || 0;
        var newVal = currentVal - parseFloat(jobTime);

        var currentValWeek = parseFloat($counterWeek.text()) || 0;
        var newValWeek = currentValWeek - parseFloat(jobTime);

        $counter.text(newVal.toFixed(1)); // Zur Tagesübersicht hinzufügen
        $counterWeek.text(newValWeek.toFixed(1)); // Zur Wochenübersicht hinzufügen

        workload($counter, $counterWeek, newVal, newValWeek); // Einfärbung
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

            // Zeiten zusammenzählen
            TimeCounter($container, jobTime);
        };

    });

    $(document).on("click", ".job_delete", function() {
        var jobBox = $(this).closest(".job_box");
        var jobTime = parseFloat($(this).siblings('input:eq(1)').val()) || 0;
        var $container = jobBox.closest(".job_container"); // Die umgebende Container-Struktur
    
        jobBox.remove(); // Element entfernen
        TimeCounterRemove($container, jobTime); // Zeit subtrahieren
    });    

});