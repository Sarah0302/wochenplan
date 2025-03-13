jQuery(document).ready(function() {

    $(document).on("click", ".job_delete", function() { // Job löschen
        var jobBox = $(this).closest(".job_box");
        
        jobBox.remove();
        window.TimeCounter();
        window.workplace();
    });

});