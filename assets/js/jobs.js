jQuery(document).ready(function() {

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
        window.workplace();
        window.TimeCounter();
    });

    // KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK  KLICK
    $(document).on("input", ".job_name_value, .job_workload", function() { // Aktualisier Button anzeigen
        $(this).closest(".job_box").find(".job_safe").removeClass("hidden");
    });    

    $(document).on("click", ".job_safe", function() { // Job Aktualisieren
        window.TimeCounter();
        window.workplace();
        window.reset();
    });

    $(document).on("keydown", ".job_name_value, .job_workload", function(event) { // Job Aktualisieren
        if ( event.type === "keydown" && event.key === "Enter" ) {
            window.TimeCounter();
            window.workplace();
            window.reset();
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

        window.TimeCounter();
        window.workplace();
    }); 

    $(document).on("click", ".job_delete", function() { // Job löschen
        var jobBox = $(this).closest(".job_box");
        
        jobBox.remove();
        window.TimeCounter();
        window.workplace();
    });

});