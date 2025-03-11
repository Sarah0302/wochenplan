jQuery(document).ready(function() {

    // FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN  FUNKTIONEN
    function jobBox(jobName, jobTime) {
        return $(`
            <div draggable="true" class="job_box mt-1 p-2 border border-slate-400">
                <div class="flex flex-row gap-1">
                    <input class="job_name_value border border-slate-200 p-2 w-full" type="text" value="${jobName}">
                    <input class="job_workload border border-slate-200 p-2 w-full" type="number" min="0" max="24" value="${jobTime}">
                    <div class="job_safe hidden p-2 w-full"><img src="assets/images/update.svg" alt="update Job"></div>
                </div>
                <div class="flex flex-row gap-1 mt-1">
                    <div class="job_done p-2 w-1/3"><img src="assets/images/done.svg" alt="Job done"></div>
                    <div class="job_delete p-2 w-1/3"><img src="assets/images/delete.svg" alt="Job delete"></div>
                    <div class="job_duplicate p-2 w-1/3"><img src="assets/images/duplicate.svg" alt="Job duplizieren"></div>
                </div>
            </div>
        `); 
    }    

    function workplace() {
        $(".job_container").each(function() {
            var $container = $(this);
            var columnIndex = $container.closest("td").index(); // Index der Spalte
            var $rowAbove = $container.closest("tr").prev(); // Die Zeile über der Job-Liste
            var $day = $rowAbove.find("td").eq(columnIndex); // Das td über der Liste
            var bgColor = "";
    
            // Falls keine Jobs in dieser Liste vorhanden sind → Setze Standardfarbe
            if ($container.find(".job_name_value").length === 0) {
                $day.removeClass("bg-lime-300 bg-cyan-300 bg-amber-300 bg-orange-300 bg-rose-300");
                return; // Nächste Iteration von .each()
            }
    
            // Überprüfe alle Job-Namen in dieser Liste
            $container.find(".job_name_value").each(function() {
                var jobText = $(this).val().toLowerCase(); // Kleinbuchstaben
    
                if (jobText.includes("fahrt")) {
                    bgColor = "bg-lime-300";
                } else if (jobText.includes("homeoffice")) {
                    bgColor = "bg-cyan-300";
                } else if (jobText.includes("kurzarbeit")) {
                    bgColor = "bg-amber-300";
                } else if (jobText.includes("halber tag")) {
                    bgColor = "bg-orange-300";
                } else if (jobText.includes("abwesend") || jobText.includes("schule")) {
                    bgColor = "bg-rose-300";
                }
            });
    
            // Hintergrundfarbe des Tages setzen
            $day.removeClass("bg-lime-300 bg-cyan-300 bg-amber-300 bg-orange-300 bg-rose-300");
            $day.addClass(bgColor);
        });
    }

    function workload() {
        $(".week_time").each(function() {
            var $dayCounter = $(this);
            var newDayVal = parseFloat($dayCounter.text()) || 0;
    
            // Tagesfarbe setzen
            $dayCounter.removeClass('bg-red-700 bg-yellow-700 bg-lime-700');
            if (newDayVal >= 8) {
                $dayCounter.addClass('bg-red-700');
            } else if (newDayVal >= 6) {
                $dayCounter.addClass('bg-yellow-500');
            } else if (newDayVal >= 0.1) {
                $dayCounter.addClass('bg-lime-700');
            } else {
                $dayCounter.removeClass('bg-red-700 bg-yellow-700 bg-lime-700');
            }
        });
    
        $(".personal_week").each(function() {
            var $weekCounter = $(this);
            var newWeekVal = parseFloat($weekCounter.text()) || 0;
    
            // Wochenfarbe setzen
            $weekCounter.removeClass('bg-red-700 bg-yellow-700 bg-lime-700');
            if (newWeekVal >= 40) {
                $weekCounter.addClass('bg-red-700');
            } else if (newWeekVal >= 32) {
                $weekCounter.addClass('bg-yellow-500');
            } else if (newWeekVal >= 0.1) {
                $weekCounter.addClass('bg-lime-700');
            } else {
                $weekCounter.removeClass('bg-red-700 bg-yellow-700 bg-lime-700');
            }
        });
    }    

    function TimeCounter() {
        $(".job_container").each(function() {
            var $container = $(this);
            var columnIndex = $container.closest("td").index(); // Spalten-Index
            var $rowAbove = $container.closest("tr").prev(); // Die Zeile über der Job-Liste
            var $dayCounter = $rowAbove.find("td").eq(columnIndex).find(".week_time"); // Tages-Count-Element
            var $weekCounter = $rowAbove.find(".personal_week"); // Wochen-Count-Element
            var newDayVal = 0;
            var newWeekVal = 0;
    
            // Berechne Tageszeit für diese Spalte
            $container.find(".job_workload").each(function() {
                newDayVal += parseFloat($(this).val()) || 0;
            });
            $dayCounter.text(newDayVal.toFixed(2));
    
            // Berechne Wochenzeit für alle Tage dieser Person
            $rowAbove.find(".week_time").each(function() {
                newWeekVal += parseFloat($(this).text()) || 0;
            });
            $weekCounter.text(newWeekVal.toFixed(2));
    
            workload(); // Aktualisiere Farben für alle Einträge
        });
    }    

    function reset() {
        $(".job_name").val('');
        $(".job_time").val('');
        $(".job_safe").addClass("hidden");
    }

    function addJob($container) {
        var $jobListe = $container.find(".job_list");
        var jobName = $container.find(".job_name").val();
        var jobTime = parseFloat($container.find(".job_time").val()) || 0;

        if (jobName != '') {
            var job = jobBox(jobName, jobTime); // JobBox generiert nun ein Element
            $jobListe.append(job); // Füge das generierte Element in die Liste ein
            TimeCounter();
            workplace();
            reset();
        };
    }

    // Drag & Drop Job Boxen  Drag & Drop Job Boxen  Drag & Drop Job Boxen  Drag & Drop Job Boxen  Drag & Drop Job Boxen  Drag & Drop Job Boxen  Drag & Drop Job Boxen  Drag & Drop Job Boxen
    let selected = null;

    $(document).on("dragstart", ".job_box", function(e) { // Jobs draggable machen
        selected = this;
    });

    $(document).on("dragover", ".job_list", function(e) { // Dragover für alle job_listen aktivieren
        e.preventDefault();
    });

    $(document).on("drop", ".job_list", function(e) { // Drop-Event
        $(this).append(selected);
        selected = null;
        workplace();
        TimeCounter();
    });

    // KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK
    $(".job_add").click(function() { // Job hinzufügen
        var $container = $(this).closest(".job_container");
        addJob($container);
    });

    $(document).on("keydown", ".job_name, .job_time", function(event) { // Job hinzufügen
        if ( event.key === "Enter") {
            var $container = $(this).closest(".job_container");
            addJob($container);
        };
    }); 

    $(document).on("input", ".job_name_value, .job_workload", function() { // Aktualisier Button anzeigen
        $(this).closest(".job_box").find(".job_safe").removeClass("hidden");
    });    

    $(document).on("click", ".job_safe", function() { // Job Aktualisieren
        TimeCounter();
        workplace();
        reset();
    });

    $(document).on("keydown", ".job_name_value, .job_workload", function(event) { // Job Aktualisieren
        if ( event.type === "keydown" && event.key === "Enter" ) {
            TimeCounter();
            workplace();
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

    $(document).on("click", ".job_duplicate", function() { // Job duplizieren
        var jobContainer = $(this).closest(".job_box");
        var jobName = jobContainer.find(".job_name_value").val();
        var jobTime = jobContainer.find(".job_workload").val();
        var jobList = jobContainer.closest(".job_list");

        var job = jobBox(jobName, jobTime);
        jobList.append(job);

        TimeCounter();
        workplace();
    }); 

    $(document).on("click", ".job_delete", function() { // Job löschen
        var jobBox = $(this).closest(".job_box");
        
        jobBox.remove();
        TimeCounter();
        workplace();
    });

});