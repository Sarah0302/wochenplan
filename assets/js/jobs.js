jQuery(document).ready(function() {

    // Drag & Drop Job Boxen  Drag & Drop Job Boxen  Drag & Drop Job Boxen  Drag & Drop Job Boxen  Drag & Drop Job Boxen  Drag & Drop Job Boxen  Drag & Drop Job Boxen  Drag & Drop Job Boxen
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

        var newPerson = rowAbove.find(".week").text().trim().replace(/[0-9.]/g, ''); // Das td über der Liste (alle Zahlen und Punkte entfernen)
        var newDay = box.closest("table").find("th").eq(columnIndex).find(".date").text();

        // Neue Werte setzen
        box.find(".job_inputs input[name='updatePerson']").val(newPerson);
        box.find(".job_inputs input[name='updateDay']").val(newDay);

        // Datenbank updaten
        window.updateJob($box);
        selected = null; // Reset für nächste Aktion
    });

    // KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK
    $(document).on("click", ".job_duplicate", function() { // Job duplizieren
        $box = $(this).closest(".job_box");
        var jobContainer = $box
        var jobId = '';
        var jobName = jobContainer.find("#updateJob").val();
        var jobTime = jobContainer.find("#updateTime").val();
        var jobPerson = jobContainer.find("#updatePerson").val();
        var jobDay = jobContainer.find("#updateDay").val();
        var jobStatus = 'open';
        // var jobList = jobContainer.closest(".job_list");

        console.log('jobId: ' + jobId);
        console.log('jobName: ' + jobName);
        console.log('jobTime: ' + jobTime);
        console.log('jobPerson: ' + jobPerson);
        console.log('jobDay: ' + jobDay);
        console.log('jobStatus: ' + jobStatus);

        // var job = jobBox(jobId, jobName, jobTime, jobPerson, jobDay, jobStatus);

        // jobList.append(job);

        // $container = jobList.find(".job_box").last();
        // console.log('Neue job_box gefunden:', $container.html());

        window.duplicateJob(jobName, jobTime, jobPerson, jobDay, jobStatus);

        // window.TimeCounter();
        // window.workplace();
        // window.updateJob($box);
    }); 

});