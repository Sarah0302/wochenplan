# wochenplan

Datenbank:
    name: wochenplan
    tabelle 1: personen
        personen_id als int & primary & auto increase
        name als text
        passwort als text
        is_admin als boolean
        is_pool als boolean
    tabelle 2: jobs
        job_id als int & primary & auto increase
        personen_id als int & fremdschlüssel
        day als text
        job als text
        time als text
        status als text

Admin & Pool
    in Datenbank Admin anlegen
        id -> egal
        name -> Admin
        passwort -> Verschlüsseln über https://bcrypt-generator.com/
        is_admin -> 1
    per Admin Formular Pool anlegen & in Datenbank is_pool auf 1 setzen

Datenbank Zugangsdaten Änderungen
    --> in der .env

Person hinzufügen / löschen
    Formular Admin

.env Nutzung
    -> Composer installieren

Feiertage anpassen
    --> holiday.php line 24 / 25