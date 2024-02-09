
## Dezember 2023 - Neue Spalte "JahrAuffuehrung"
Neue Spalte "musikstueck.JahrAuffuehrung". Datentyp integer in der Annahme, dass der Inhalt "Jahre letzte Aufführung" bedeuten soll.  

## 02.02.2023, 06.02.2024 - Termin mit AG
 * Erfassung Live  
 * Die Spalte  "musikstueck.JahrAuffuehrung" soll mehrere "Aufführungsjahre" aufnehmen können. Vorläufige Lösung: zu varchar ändern.
 * Besetzung - Eigenschaften müssen einzeln filterbar sein. Umsetzung eingeplant 

## Fortsetzung Anpassungen 
 * 03.02. Umsetzung Korrekturen s.a. ..\ddl\updates\20240203_korrekturen.sql (auf prod schon erledigt). dort auch Anpassung "musikstueck.JahrAuffuehrung"
 * 03.02. Umsetzung Musikstück / Besetzung (auf prod abgeschlossen), Siehe ..\ddl\updates\20240203_musikstueck_zu_besetzung.sql
 * 05.03.2024 Optimierung der Scripte list_tables.php, show_table.php 
 * 08./09.02.2024, Basisentwurf:  Formular Einfügen und Bearbeiten/Löschen von Daten in Tabelle (erster einfacher Prototyp ist Tabelle "verlag") 

 ## Notizen: 
  * Testviews für Anzeige nicht vollständiger Erfassungen 
  * View musikstueck_v - mit einzelnen Besetzungen. Die Variante mit group_concat als musikstueck_v anlegen. 


    
