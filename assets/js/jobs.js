jQuery(document).ready(function() {

    // FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN
    function setList($jobListe, jobName, jobTime) {
        var $job = $(`
            <div draggable="true" class="job_box" style="border: 1px solid blue; display: flex; flex-direction: row;">
                <div class="job_done" style="background: green; padding: 5px; cursor: pointer;">erledigt</div>
                <input class="job_name_value" type="text" value="${jobName}">
                <input class="job_workload" type="number" min="0" max="24" value="${jobTime}">
                <div class="job_safe hide" style="background: lightblue; padding: 5px; cursor: pointer;">aktualisieren</div>
                <div class="job_delete" style="background: red; padding: 5px; cursor: pointer;">löschen</div>
                <div class="job_duplicate" style="background: gray; padding: 5px; cursor: pointer;">duplizieren</div>
            </div>
        `);
        $jobListe.append($job);
    }

    function workplace($container) {
        var columnIndex = $container.closest("td").index(); // Index der Spalte
        var $rowAbove = $container.closest("tr").prev(); // Die Zeile über der Job-Liste
        var $day = $rowAbove.find("td").eq(columnIndex); // Das td über der Liste
        var bgColor = "transparent"; // Standardfarbe

        // Überprüfe alle Job-Namen im Container
        $container.find(".job_name_value").each(function() {
            var jobText = $(this).val().toLowerCase(); // Text im Input-Feld (kleinbuchstaben)

            if (jobText.includes("fahrt")) {
                bgColor = "lightgreen";
            } else if (jobText.includes("homeoffice")) {
                bgColor = "lightblue";
            } else if (jobText.includes("kurzarbeit")) {
                bgColor = "yellow";
            } else if (jobText.includes("halber tag")) {
                bgColor = "orange";
            } else if (jobText.includes("abwesend") || jobText.includes("schule")) {
                bgColor = "red";
            }
        });
        $day.css("background", bgColor);
    }

    function workload($dayCounter, $weekCounter, newDayVal, newWeekVal) {
        if (newDayVal >= 8) {
            $dayCounter.css({ background: 'red', });
        } else if (newDayVal >= 6) {
            $dayCounter.css({ background: 'yellow', });
        } else if (newDayVal >=0.1) {
            $dayCounter.css({ background: 'green', });
        } else {
            $dayCounter.css({ background: 'transparent', });
        }

        if (newWeekVal >= 40) {
            $weekCounter.css({ background: 'red', });
        } else if (newWeekVal >= 32) {
            $weekCounter.css({ background: 'yellow', });
        } else if (newWeekVal >=0.1) {
            $weekCounter.css({ background: 'green', });
        } else {
            $weekCounter.css({ background: 'transparent', });
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
        $dayCounter.text(newDayVal.toFixed(2)); // Zur Tagesübersicht hinzufügen

        // Berechne Wochenzeit für alle Tage dieser Person
        $rowAbove.find(".week_time").each(function() {
            newWeekVal += parseFloat($(this).text()) || 0;
        });
        $weekCounter.text(newWeekVal.toFixed(2)); // Zur Wochenübersicht hinzufügen

        workload($dayCounter, $weekCounter, newDayVal, newWeekVal); // Einfärbung
    }

    function reset() {
        $(".job_name").val('');
        $(".job_time").val('');
        $(".job_safe").addClass("hide");
    }

    // KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK
    $(".job_add").click(function() { // Job hinzufügen
        var $container = $(this).closest(".job_container");
        var $jobListe = $container.find(".job_list");
        var jobName = $container.find(".job_name").val();
        var jobTime = parseFloat($container.find(".job_time").val()) || 0;

        if (jobName != '') {
            setList($jobListe, jobName, jobTime);
            TimeCounter($container);
            workplace($container);
            reset();
        };
    });

    $(document).on("keydown", ".job_name, .job_time", function(event) { // Job hinzufügen
        if ( event.type === "keydown" && event.key === "Enter") {
            var $container = $(this).closest(".job_container");
            var $jobListe = $container.find(".job_list");
            var jobName = $container.find(".job_name").val();
            var jobTime = parseFloat($container.find(".job_time").val()) || 0;

            if (jobName != '') {
                setList($jobListe, jobName, jobTime);
                TimeCounter($container);
                workplace($container);
                reset();
            };
        };
    }); 

    $(document).on("click", ".job_delete", function() { // Job löschen
        var jobBox = $(this).closest(".job_box");
        var $container = jobBox.closest(".job_container");
    
        jobBox.remove();
        TimeCounter($container);
        workplace($container);
    }); 

    $(document).on("click", ".job_duplicate", function() { // Job duplizieren
        var jobBox = $(this).closest(".job_box");
        var jobName = jobBox.find(".job_name_value").val();
        var jobTime = jobBox.find(".job_workload").val();
        var $container = jobBox.closest(".job_container");
        var jobList = jobBox.closest(".job_list");
        var $job = $(`
            <div draggable="true" class="job_box" style="border: 1px solid blue; display: flex; flex-direction: row;">
                <div class="job_done" style="background: green; padding: 5px; cursor: pointer;">erledigt</div>
                <input class="job_name_value" type="text" value="${jobName}">
                <input class="job_workload" type="number" min="0" max="24" value="${jobTime}">
                <div class="job_safe hide" style="background: lightblue; padding: 5px; cursor: pointer;">aktualisieren</div>
                <div class="job_delete" style="background: red; padding: 5px; cursor: pointer;">löschen</div>
                <div class="job_duplicate" style="background: gray; padding: 5px; cursor: pointer;">duplizieren</div>
            </div>
        `);
        jobList.append($job);

        TimeCounter($container);
        workplace($container);
    }); 

    $(document).on("input", ".job_name_value, .job_workload", function() { // Aktualisier Button anzeigen
        $(this).closest(".job_box").find(".job_safe").removeClass("hide");
    });    

    $(document).on("click", ".job_safe", function() { // Job Aktualisieren
        var $container = $(this).closest(".job_container");
        TimeCounter($container);
        workplace($container);
        reset();
    });

    $(document).on("keydown", ".job_name_value, .job_workload", function(event) { // Job Aktualisieren
        if ( event.type === "keydown" && event.key === "Enter" ) {
            var $container = $(this).closest(".job_container");
            TimeCounter($container);
            workplace($container);
            reset();
        };
    });

    $(document).on("click", ".job_done", function() { // Job als Erledigt kennzeichenn
        var $jobBox = $(this).closest(".job_box"); 
        var $inputs = $jobBox.find(".job_name_value, .job_workload");
    
        if ($inputs.prop("disabled")) { 
            $jobBox.css({ background: 'transparent' }); 
            $inputs.prop("disabled", false);
        } else { 
            $jobBox.css({ background: 'green' }); 
            $inputs.prop("disabled", true);
        }
    });    

});