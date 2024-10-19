
# Projekt
Datenbank mit Web-Anwendung, Erfassung und Abfrage von Notenmaterial für Musikunterricht und Orchesterleitung. 

# Technik    
 * PHP: Version 8.2.12 / Integration: OOP, PDO, Prepared Statements
 * DB: 10.4.32-MariaDB (dev), MySQL 5.7.42-log (prod) 
 * UI: HTML, CSS, Javascript / Browser: Chrome, Edge

# Team
 * 1 Musiklehrer / Orchesterleitung
 * 1 Entwickler

# Status
In Arbeit, Fertigstellung der Grundfunktionen aktuell geplant für Ende 2025

-----

--- Entwürfe --- 

# Ordner / Dateien 
```
└── 📁notendb: Anwendung  (obligatorisch)
└── 📁dev: optional (Dateien aus Entwicklungsprozess)
└── 📁service: optional, Datein aus Aufträgen (Dataclearin, Tests) 
```
# Ordner "notendb" 
Anwendungsscripte und DDLs  ... XXX 

## Ordner "admin" 
### Ordner "backup"  
Hinweis: die u.a. Methode dient optional als Alternative zum Export über PhpMyAdmin. 

Vorgehensweise: 
* Datei ../admin/backup/backup.php ausführen: Struktur und Daten werden gesichert, Datei "backup.sql" wird erzeugt. 
* Datei ../admin/backup/backup_ddl.php ausführen: Struktur wird gesichert, Datei "backup_ddl.sql" wird erzeugt. 
* SQL-Dateien umbenennen (backup_[yyyy-mm-dd].sql, backup_ddl_[yyyy-mm-dd].sql ) und anschließend runterladen. 


## Ordner "dbconn" 

----

# Ordner "service" 

## Dataclearing 
XXX z.B. "allen Musikstücken in Sammlung X soll die Besetzung Y zugeordnet werden" (Sammel-Update)

## Abfragen 

* Tests  
XXX Abfragen für die Seite "Tests", die zusätzlich zu den vorinstallieren Tests angelegt werden können (SQL-Kenntnisse erforderlich).  

XXX Seite "Tests" enthält im wesentlich Abfragen, welche strukturelle Erfassungs-Lücken (Unvollständigkeiten) aufzeigen sollen Strukturelle Erfassungslücken z.B.: "Sammlungen ohne Musikstück" (unvollständig technische Defintion)

* Abfragen 
Abfragen, die in Tabelle "Abfragen" hinterlegt werden sollen (SQL-Kenntnisse erforderlich).  Siehe auch Kapitel Abfragen XXX (gespeicherte Suche, auf Doku zu Suche)

