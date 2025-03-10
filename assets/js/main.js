jQuery(document).ready(function() {

    $(".week_before").click(function() {
        let week = parseInt(new URLSearchParams(window.location.search).get("week")) || new Date().getWeek();
        let newWeek = (week - 1 < 1) ? 53 : week - 1; // wenn kleiner 1 dann 53 sonst -1
        window.location.href = "wochenplan.php?week=" + newWeek;
    });

    $(".week_after").click(function() {
        let week = parseInt(new URLSearchParams(window.location.search).get("week")) || new Date().getWeek();
        let newWeek = (week + 1 > 53) ? 1 : week + 1; // wenn größer 53 dann 1 sonst +1
        window.location.href = "wochenplan.php?week=" + newWeek;
    });

    // JOBS  JOBS  JOBS  JOBS  JOBS  JOBS  JOBS  JOBS  JOBS  JOBS  JOBS  JOBS  JOBS  JOBS  JOBS  JOBS  JOBS  JOBS  
    $(".job_counter").click(function() { // Listen der Person Ein / Ausblenden
        $(this).next(".job_row-list").not(".show_pool").toggleClass("hidden");
    });

    $(".week").click(function() { // Listen der Person Ein / Ausblenden
        $(this).closest(".job_row-list").not(".show_pool").toggleClass("hidden");
    });

    $(".open_all").click(function() {
        $(".job_row-list").not(".show_pool").removeClass("hidden");
    });

    $(".close_all").click(function() {
        $(".job_row-list").not(".show_pool").addClass("hidden");
    });

    $(".saturday_button").click(function() {
        $(".saturday").toggleClass("hidden");

        if( $(".saturday").hasClass("hidden") ) {
            $(this).html('Samstag anzeigen');
        } else {
            $(this).html('Samstag ausblenden');
        }
    });

});