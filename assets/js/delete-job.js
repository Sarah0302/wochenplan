jQuery(document).ready(function() {

    $(document).on("click", ".job_delete", function() { // Job löschen
        window.TimeCounter();
        window.workplace();

        // ID des zu löschenden Datensatzes aus dem Datensatz extrahieren
        var id = $(this).closest(".job_box").attr("id");

        // AJAX-Aufruf durchführen, um delete.php mit der ID zu verwenden
        $.ajax({
            url: "delete.php",
            method: "POST",
            data: { deleteid: id }, // ID als POST-Daten senden
            success: function(response) {
                alert(response); // Zeigt die Rückgabemeldung von delete.php an
            },
            error: function(xhr, status, error) {
                alert("Fehler beim Löschen: " + error); // Zeigt den Fehler an
            }
        });
        window.location.href = "wochenplan.php";
    });

});