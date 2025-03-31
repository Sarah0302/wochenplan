jQuery(document).ready(function() {
    
    $(document).on("click", ".job_add", function(event) { // Job hinzufügen
        event.preventDefault(); // Standard-Formularverhalten verhindern
        var $container = $(this).closest(".job_container");
        window.addJob($container); // Greift auf die globale Funktion aus functions.js zu
        window.getData();
    });

    $(document).on("keydown", ".job_name, .job_time", function(event) { // Job hinzufügen
        if (event.key === "Enter") {
            event.preventDefault(); // Standard-Formularverhalten verhindern
            var $container = $(this).closest(".job_container");
            window.addJob($container);
            window.getData();
        }
    });

    $(document).on("click", ".job_duplicate", function() { // Job duplizieren
        $box = $(this).closest(".job_box");
        var jobContainer = $box
        var jobName = jobContainer.find("#updateJob").val();
        var jobTime = jobContainer.find("#updateTime").val();
        var jobPerson = jobContainer.find("#updatePerson").val();
        var jobDay = jobContainer.find("#updateDay").val();
        var jobStatus = 'open';

        window.duplicateJob(jobName, jobTime, jobPerson, jobDay, jobStatus);
        window.getData();
    }); 
    
});
