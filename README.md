# wochenplan

1. env anlegen (zur Verwendung der Datenbank) (Wenn nicht lokal, dann anpassen!)
    DB_DSN="mysql:host=localhost;dbname=wochenplan"
    DB_USERNAME="root"
    DB_PASSWORD="root"

2. Datenbank Tabellen anlegen:
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

3. Admin & Pool anlegen
    in Datenbank Admin anlegen
        id -> egal
        name -> Admin
        passwort -> Verschlüsseln über https://bcrypt-generator.com/
        is_admin -> 1
    per Admin Formular Pool anlegen & in Datenbank is_pool auf 1 setzen

4. Nutzung:
    Person hinzufügen / löschen
        Formular Admin

    .env Nutzung
        -> Composer installieren

    Feiertage anpassen
        --> holiday.php line 24 / 25