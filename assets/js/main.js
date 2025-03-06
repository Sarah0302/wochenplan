jQuery(document).ready(function() {

    // Drag & Drop Job Boxen
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
    });

    // Klick Events
    $(".job_counter").click(function() { // Listen der Person Ein / Ausblenden
        $(this).next(".job_row-list").toggleClass("hide");
    });

    $(".week").click(function() { // Listen der Person Ein / Ausblenden
        $(this).closest(".job_row-list").toggleClass("hide");
    });

    $(".open_all").click(function() {
        $(".job_row-list").removeClass("hide");
    });

    $(".close_all").click(function() {
        $(".job_row-list").addClass("hide");
    });

    $(".saturday_button").click(function() {
        $(".saturday").toggleClass("hide");

        if( $(".saturday").hasClass("hide") ) {
            $(this).html('Samstag anzeigen');
        } else {
            $(this).html('Samstag ausblenden');
        }
    });

});