

## offene Aufgaben: 
 * Startseite, "Daten anzeigen" -> geöffnete Seite soll Bearbeitungslink anzeigen 
 * Anzeige Tabellen mit Sortierspalten im Spaltenkopf 
 * Seite für: Testviews für Anzeige unvollständig erfasster Daten 
 * View musikstueck_v - mit einzelnen Besetzungen. Die Variante mit group_concat als musikstueck_v2 anlegen. 
 * Doku, Hinweis auf Verwendung PDO, damit theoret. auf andere Datenbanksysteme übertragbar 



 ## Erledigte Aufgaben 
  * Besetzung - Eigenschaften müssen einzeln filterbar sein. 

## Notizen 
 * Erfassung Zuordnung (asoc) im iframe. Erfassung Unterdatensätze in neuem Fenster  
 * Erfassung (insert_*.php): Nur obligatorische Felder (z.B. Name, Nr) erfassen und dann speichern. Fortsetzung im Bearbeitungsformular (edit_*.php)

## Protokoll 
 * Dez. 2023: Neue Spalte "musikstueck.JahrAuffuehrung". Datentyp integer in der Annahme, dass der Inhalt "Jahre letzte Aufführung" bedeuten soll.  
 * 02.02.2023, 06.02.2024 - Termin mit AG. Erfassung Live. Die Spalte "musikstueck.JahrAuffuehrung" soll mehrere "Aufführungsjahre" aufnehmen können. Vorläufige Lösung: zu varchar ändern.
 * 03.02. Umsetzung Korrekturen s.a. ..\ddl\updates\20240203_korrekturen.sql (auf prod schon erledigt). dort auch Anpassung "musikstueck.JahrAuffuehrung"
 * 03.02. Umsetzung Musikstück / Besetzung (auf prod abgeschlossen), Siehe ..\ddl\updates\20240203_musikstueck_zu_besetzung.sql
 * 05.03.2024 Optimierung der Scripte list_tables.php, show_table2.php 
 * 08./09.02.2024, Basisentwurf:  Formular Einfügen und Bearbeiten/Löschen von Daten in Tabelle (erster einfacher Prototyp ist Tabelle "verlag") 
 * 10.02. Auswahl-Elemente: wenn Wert unbekannt, dann muss es leer sein (Prototyp bei Sammlung > VerlagID ) 
 * 21.02.2024: Zuordnung Stricharten 
 * 22.02.2024: Bearbeitungsformulare "Stricharten", "Besetzung" 
 * 22.02.2024: Neue Version show_table2.php 
 * 22.02.2024: Optimierung der insert_- edit_-Dateien (Nutzer-Meldungen in functions auslagern) 
 
