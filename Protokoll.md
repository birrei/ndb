
## offene Aufgaben: 
 * Anzeige Tabellen mit Sortierspalten im Spaltenkopf 
 * Seite für: Testviews für Anzeige unvollständig erfasster Daten 
 * View musikstueck_v - mit einzelnen Besetzungen. Die Variante mit group_concat als musikstueck_v2 anlegen. 
 * Doku, Hinweis auf Verwendung PDO, damit theoret. auf andere Datenbanksysteme übertragbar 
 * Iframe: erstes Eingabefeld im Formular mit autofokus? (recherche ... scheint nicht so einfach)
 * Seite für Löschungen 
 * Suche-Seite: Nach Suchvorgang soll Auswahl im multiple-Filterfeld erhalten bleiben. 

## Notizen 
 * Erfassung Zuordnung (asoc) im iframe. Unterdatensätze: für größere Tabellen: insert im iframe, Bearbeitung in neuem Fenster  
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
 * 23.02.2024: Sammlung -> Unterformular Musikstück (immer von Sammlung aus anlegen / bearbeiten)
 * 23.02.2024: Erfassung / Bearbeitung Stammdatentabelle "Besetzungen" 
 * 23.02.2024: Erfassung / Bearbeitung Stammdatentabelle "Stricharten" 
 * 23.02.2024: (hat sich erledig, da jetzt Unterformular: Musikstück, Auswahl Sammlung: Filter einschränken)  
* 23.02.2024: Suchformular, Prototyp für Suche von Musikstücken nach Besetzungen
* 27.02.2024: Musikstück > Verwendungszweck - Mehrfachauswahl einrichten 