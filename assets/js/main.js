jQuery(document).ready(function() {

    $(".week_before").click(function() {
        $week = window.getWeekFromUrl();
        $week = ($week - 1 < 1) ? 53 : $week - 1; // wenn kleiner 1 dann 53 sonst -1
        window.location.href = "wochenplan.php?week=" + $week;
    });

    $(".week_after").click(function() {
        $week = window.getWeekFromUrl();
        $week = ($week + 1 > 53) ? 1 : $week + 1; // wenn größer 53 dann 1 sonst +1
        window.location.href = "wochenplan.php?week=" + $week;
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
            $(".saturday-col").removeClass("grid-cols-[200px_repeat(6,1fr)]");
            $(".saturday-col").addClass("grid-cols-[200px_repeat(5,1fr)]");
        } else {
            $(this).html('Samstag ausblenden');
            $(".saturday-col").removeClass("grid-cols-[200px_repeat(5,1fr)]");
            $(".saturday-col").addClass("grid-cols-[200px_repeat(6,1fr)]");
        }
    });

});