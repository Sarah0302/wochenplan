jQuery(document).ready(function() {

    $(".job_counter").click(function() { // Listen der Person Ein / Ausblenden
        $(this).next(".job_row-list").not(".show_pool").toggleClass("hide");
    });

    $(".week").click(function() { // Listen der Person Ein / Ausblenden
        $(this).closest(".job_row-list").not(".show_pool").toggleClass("hide");
    });

    $(".open_all").click(function() {
        $(".job_row-list").not(".show_pool").removeClass("hide");
    });

    $(".close_all").click(function() {
        $(".job_row-list").not(".show_pool").addClass("hide");
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