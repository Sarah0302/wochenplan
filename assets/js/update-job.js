jQuery(document).ready(function() {

    $(document).on("input", ".job_name_value, .job_workload", function() { // Aktualisier Button anzeigen
        $(this).closest(".job_box").find(".job_safe").removeClass("hidden");
    });

    $(document).on("click", ".job_done", function() { // Job Status in Datenbank setzen & Job Aktualisieren
        $box = $(this).closest(".job_box");
        $statusInput = $box.find("input[name='updateStatus']");

        if ($statusInput.val() === 'done') {
            $statusInput.val("open");
        } else {
            $statusInput.val("done");
        }

        window.updateJob($box);
        location.reload();
    });

    $(document).on("click", ".job_safe", function() { // Job Aktualisieren
        $box = $(this).closest(".job_box");
        window.updateJob($box);
        location.reload();
    });

    $(document).on("keydown", ".job_name_value, .job_workload", function(event) { // Job Aktualisieren
        if ( event.type === "keydown" && event.key === "Enter" ) {
            $box = $(this).closest(".job_box");
            window.updateJob($box);
            location.reload();
        };
    });

    
    // Drag & Drop
    let selected = null;

    $(document).on("dragstart", ".job_box", function(e) { // Jobs draggable machen
        selected = $(this);
    });

    $(document).on("dragover", ".job_list", function(e) { // Dragover für alle job_listen aktivieren
        e.preventDefault();
    });

    $(document).on("drop", ".job_list", function(e) { // Drop-Event
        $(this).append(selected);

        // neue Person und neues Datum auslesen
        var box = selected; // Die verschobene Job-Box direkt verwenden
        $box = box;
        var columnIndex = box.closest("td").index(); // Index der Spalte
        var rowAbove = box.closest("tr").prev(); // Die Zeile über der Job-Liste

        var newPersonId = rowAbove.find(".personen_id").text(); // Das td über der Liste
        var newDay = box.closest("table").find("th").eq(columnIndex).find(".date").text();

        // Neue Werte setzen
        box.find(".job_inputs input[name='updatePerson']").val(newPersonId);
        box.find(".job_inputs input[name='updateDay']").val(newDay);

        // Datenbank updaten
        window.updateJob($box);
        location.reload();
        selected = null; // Reset für nächste Aktion
    });

});