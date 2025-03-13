jQuery(document).ready(function() {
$(document).on("input", ".job_name_value, .job_workload", function() { // Aktualisier Button anzeigen
    $(this).closest(".job_box").find(".job_safe").removeClass("hidden");
});    

$(document).on("click", ".job_safe", function() { // Job Aktualisieren
    $box = $(this).closest(".job_box");
    window.updateJob($box);
});

$(document).on("keydown", ".job_name_value, .job_workload", function(event) { // Job Aktualisieren
    if ( event.type === "keydown" && event.key === "Enter" ) {
        $box = $(this).closest(".job_box");
        window.updateJob($box);
    };
});

});