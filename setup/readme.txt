Flurmanager Datenbank Setup

1. Datenbank mit PHPMyAdmin anlegen

2. Eigenen Benutzer für die Datenbank mit den folgenden Rechten anlegen:
   SELECT, INSERT, UPDATE, DELETE, CREATE, DROP, FILE, INDEX, ALTER, 
   CREATE TEMPORARY TABLES, LOCK TABLES

3. datenbank.sql in die Datenbank exportieren.

4. Im Hauptordner die Datei config.php öffnen und den Benutzer, das Passwort
   und die Datenbank entsprechend eintragen. Außerdem die Flureigenschaften und
   das Wurzelverzeichnis setzen.

5. Den Kommentar vor der Zeile
	//$loginErforderlich = false;
   entfernen.

6. Den Flurmanager im Browser aufrufen. Für den Admin einen Mitbewohner anlegen.
   Dann in der Adresszeile /registrieren anhängen, einen Benutzernamen und ein
   Passwort für den Administrator anlegen. In das Verzeichnis /user/alle wechseln
   und den angelegten Benutzer bearbeiten. Das Häkchen bei Ist Aktiviert setzen.

7. Den Kommentar in der config wieder herstellen. Das System kann jetzt normal
   benutzt werden.