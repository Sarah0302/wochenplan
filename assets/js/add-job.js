jQuery(document).ready(function() {

    $(".job_add").click(function() { // Job hinzufügen
        var $container = $(this).closest(".job_container");
        window.addJob($container); // Greift auf die globale Funktion aus functions.js zu
    });

    $(document).on("keydown", ".job_name, .job_time", function(event) { // Job hinzufügen
        if (event.key === "Enter") {
            var $container = $(this).closest(".job_container");
            window.addJob($container);
        }
    });

});
