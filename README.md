
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

# Dateien 
Für die Anwendung werden die Dateien im Ordner "notendb" benötigt. Die Dateien im Ordner "sql" sind nicht erforderlich. 

-----

## Backup 
Hinweis: die u.a. Methode dient optional als Alternative zum Export über PhpMyAdmin. 

Vorgehensweise: 
* Datei ../admin/backup/backup.php ausführen: Struktur und Daten werden gesichert, Datei "backup.sql" wird erzeugt. 
* Datei ../admin/backup/backup_ddl.php ausführen: Struktur wird gesichert, Datei "backup_ddl.sql" wird erzeugt. 
* SQL-Dateien umbenennen (backup_[yyyy-mm-dd].sql, backup_ddl_[yyyy-mm-dd].sql ) und anschließend runterladen. 


## Restore
Restore prod- Daten auf Demo

* Sql 



## Ordner "notendb" 

```
└── 📁notendb
    └── 📁admin
        └── 📁backup
        └── 📁install
            └── install_abfragen.php
            └── install_views.php
            └── v_abfrage.sql
            └── v_komponist.sql
            └── v_lookup_groups.sql
            └── v_lookup.sql
            └── v_musikstueck.sql
            └── v_sammlung_lookuptypes.sql
            └── v_sammlung.sql
            └── v_satz_instrumente.sql
            └── v_satz_lookuptypes.sql
            └── v_satz.sql
            └── v2_info_Spieldauern.sql
            └── v2_info_Taktarten.sql
            └── v2_info_Tempobezeichnungen.sql
            └── v2_info_Tonarten.sql
            └── v3_test_musikstueck_ohne_besetzung.sql
            └── v3_test_musikstueck_ohne_komponist.sql
            └── v3_test_musikstueck_ohne_satz.sql
            └── v3_test_sammlung_ohne_musikstueck.sql
            └── v3_test_sammlung_ohne_verlag.sql
            └── v3_test_satz_ohne_erprobt.sql
            └── v3_test_satz_ohne_schwierigkeitsgrad.sql
            └── v3_test_satz_ohne_spieldauer.sql
        └── 📁restore
            └── backup.sql
            └── restore.php
        └── 📁tools
            └── sqlexec.php
        └── foot.php
        └── head.php
        └── index.php
    └── 📁dbconn
        └── cl_db.php
    └── .gitignore
    └── cl_abfrage.php
    └── cl_abfragetyp.php
    └── cl_besetzung.php
    └── cl_epoche.php
    └── cl_erprobt.php
    └── cl_gattung.php
    └── cl_html_info.php
    └── cl_html_select.php
    └── cl_html_table.php
    └── cl_instrument.php
    └── cl_komponist.php
    └── cl_link.php
    └── cl_linktype.php
    └── cl_lookup.php
    └── cl_lookuptype.php
    └── cl_musikstueck.php
    └── cl_sammlung.php
    └── cl_satz_erprobt.php
    └── cl_satz.php
    └── cl_schwierigkeitsgrad.php
    └── cl_standort.php
    └── cl_verlag.php
    └── cl_verwendungszweck.php
    └── dataclearing.php
    └── delete.php
    └── edit_abfrage.php
    └── edit_abfrage2.php
    └── edit_abfragetyp.php
    └── edit_besetzung.php
    └── edit_epoche.php
    └── edit_erprobt.php
    └── edit_gattung.php
    └── edit_instrument.php
    └── edit_komponist.php
    └── edit_linktype.php
    └── edit_lookup_type_add_lookup.php
    └── edit_lookup_type_list_lookups.php
    └── edit_lookup_type.php
    └── edit_lookup.php
    └── edit_musikstueck_besetzung_old.php
    └── edit_musikstueck_besetzung.php
    └── edit_musikstueck_besetzungen.php
    └── edit_musikstueck_saetze.php
    └── edit_musikstueck_verwendungszweck.php
    └── edit_musikstueck_verwendungszwecke.php
    └── edit_musikstueck.php
    └── edit_sammlung_link.php
    └── edit_sammlung_links.php
    └── edit_sammlung_lookup.php
    └── edit_sammlung_lookups.php
    └── edit_sammlung_musikstuecke.php
    └── edit_sammlung.php
    └── edit_satz_erprobt.php
    └── edit_satz_erprobte.php
    └── edit_satz_lookup_old.php
    └── edit_satz_lookup.php
    └── edit_satz_lookups.php
    └── edit_satz_schwierigkeitsgrad.php
    └── edit_satz_schwierigkeitsgrade.php
    └── edit_satz.php
    └── edit_schwierigkeitsgrad.php
    └── edit_standort.php
    └── edit_verlag.php
    └── edit_verwendungszweck.php
    └── favicon.ico
    └── foot_raw.php
    └── foot.php
    └── head_raw.php
    └── head.php
    └── help.php
    └── index.php
    └── javascript.js
    └── show_abfrage.php
    └── show_table2.php
    └── style.css
    └── suche.php
    └── test.html
    └── test2.php
    └── tests.php
```