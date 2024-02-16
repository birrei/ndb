# Projekt 

# Hinweise
 * Dieses Repository ist öffentlich, um eine ev. spätere Weitergabe des Projekts zu erleichtern. 
 * Das Repository enthält keine Zugangsdaten, keine Anwendungs-Links oder sonstige Hinweise auf den den konkreten Einsatz.

# Ordner "notendb" 
 Wichtig! Die Scripte für die Notendatenbank-Webanwendung müssen in einem passwortgeschützten, separaten Ordner abgelegt werden! 

 * index.php - Startseite
 * list_tables.php - Alle Tabellen und Views werden aufgelistet. Die Liste enthält Links, über die die Tabelle af Seite show_table.php angezeigt wird (Übergabe Parameter "table")
 * show_table.php - Zeigt die Daten der Tabelle an, deren Name als Parameter übergeben wird. Weitere optionale Parameter: 
  * "sortcol": Spalte, nach der die Anzeige sortiert werden (default: "ID", diese Spalte gibt es in jeder Tabelle)
  * "sortorder": Sortierrichtung (default: ASC")
 * sqlexec.php - einfaches Script zur Ausführung von SQL-commands 
 * dbconnect.php (ignored, da Zugangsdaten enthaltend, XXX noch andere Lösung suchen)
 * head.php - ... 
 * foot.php - ... 


# Ordner "ddl" 
 * Datenbank-Objekte zur Notendatenbank (MySQL), weitere Doku folgt noch 
 





