jQuery(document).ready(function() {

    let userIsActive = false;
    let activityTimeout;

    // Prüfen, ob ein Formular gerade unausgefüllt/offen ist
    function hasUnsavedInput() {
        let hasInput = false;
        let hasUpdate = false;

        $(".job_name, .job_time").each(function() { // Wenn ungesicherter Inhalt in add-job-form
            if ($(this).val().trim() !== "") {
                hasInput = true;
                return false; // Schleife abbrechen
            }
        });

        $(".job_safe").each(function() {
            if (!$(this).hasClass("hidden")) { // Wenn Icon zum aktualisieren sichtbar
                hasUpdate = true;
                return false; // Schleife abbrechen
            }
        })

        return hasInput || hasUpdate;
    }

    // Nutzer-Aktivität registrieren
    function registerActivity() {
        userIsActive = true;
        clearTimeout(activityTimeout);

        // Wenn 15 Sekunden lang keine Aktivität → wieder inaktiv
        activityTimeout = setTimeout(function() {
            userIsActive = false;
        }, 5000);
    }

    // Aktivität bei Eingaben erkennen
    $(document).on("keydown click input", "input", function() {
        registerActivity();
    });
    
    // Jede 10 Sekunden bei allen Nutzern aktualisieren, WENN user = inaktiv UND alles gespeichert wurde
    setInterval(function() {
        if (!userIsActive && !hasUnsavedInput()) {
            window.getData();
        }
    }, 60000); // Jede Minute (60.000 ms)

});