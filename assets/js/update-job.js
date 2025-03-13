jQuery(document).ready(function() {
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

});