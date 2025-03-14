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

});