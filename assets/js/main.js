jQuery(document).ready(function() {

    $(".week_before").click(function() {
        $maxWeek = window.getMaxWeeks();
        $thisWeek = window.getWeekFromUrl();
        $week = ($thisWeek - 1 < 1) ? $maxWeek : $thisWeek - 1; // wenn kleiner 1 dann maxWochen sonst -1
        $url = "./wochenplan.php?week=";
        $url += $week;
        $url += "#user";
        window.location.href = $url;
    });

    $(".week_after").click(function() {
        $maxWeek = window.getMaxWeeks();
        $thisWeek = window.getWeekFromUrl();
        $week = ($thisWeek + 1 > $maxWeek) ? 1 : $thisWeek + 1; // wenn größer maxWochen dann 1 sonst +1
        window.location.href = $url;
    });

    $("#selectKW").on("change", function() {
        var week = $(this).val();
        window.location.href = $url;
    });    

    // JOBS  JOBS  JOBS  JOBS  JOBS  JOBS  JOBS  JOBS  JOBS  JOBS  JOBS  JOBS  JOBS  JOBS  JOBS  JOBS  JOBS  JOBS  
    $(".job_counter").click(function() { // Listen der Person Ein / Ausblenden
        $(this).next(".job_row-list").not(".show_pool").toggleClass("hidden");
        window.openLists();
    });

    $(".week").click(function() { // Listen der Person Ein / Ausblenden
        $(this).closest(".job_row-list").not(".show_pool").toggleClass("hidden");
        window.openLists();
    });

    $(".open_all").click(function() {
        $(".job_row-list").not(".show_pool").removeClass("hidden");
        window.openLists();
    });

    $(".close_all").click(function() {
        $(".job_row-list").not(".show_pool").addClass("hidden");
        window.openLists();
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