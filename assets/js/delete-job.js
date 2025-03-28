jQuery(document).ready(function() {

    $(document).on("click", ".job_delete", function() { // Job löschen
        $week = window.getWeekFromUrl();
        $url = "./wochenplan.php?week=";
        $url += $week;
        $url += "#user";

        $(this).closest(".job_box").remove();

        // ID des zu löschenden Datensatzes aus dem Datensatz extrahieren
        var id = $(this).closest(".job_box").attr("id");

        // AJAX-Aufruf durchführen, um delete.php mit der ID zu verwenden
        $.ajax({
            url: "delete.php",
            method: "POST",
            data: { // ID als POST-Daten senden
                deleteid: id 
            },
            success: function(response) {
                window.location.href = "" + $url;
            },
            error: function(xhr, status, error) {
                alert("Fehler beim Löschen: " + error); // Zeigt den Fehler an
            }
        });

        location.reload();
    });
    
});