
###  Aufgabe in Arbeit   

Integration Schüler-Tabelle
Funktionen: 
    - Zuordnung Schüler Schwierigkeitsgrad 
    - Anzeige geeignetes Material (match satz/schueler Schwierigkeitsgrad), ggf. Besonderheiten - mit option "Übernahme" 
    - Planung (ANzeige übernommene Vorschläge)
        - Plaung offen 
        - Planung aktiv ("Material", Datum von, Datum bis )

-------------------
- install/ddl.php 
- Initial-Befüllung aus Verwendungszweck - dev\features\20250106_schueler.sql
- index.php Links 
- cl_schueler.php 
- edit_schueler.php 
- Tabelle: schueler_schwierigkeitsgrad
- edit_schueler_schwierigkeitsgrade.php 
- edit_schueler_schwierigkeitsgrad.php 



###  Aufgaben in Arbeit - 2. Reihe 
- Dataclearing: Sammlung > Gattung / Sammlung > Epoche 
- Suche: Ergebnis-Abfrage, separate Queries: Verwendungszwecke (erledigt: Besetzungen)
- Verbesserung Suchlogik (Ergänzung Optionen an Suchbox, Ergebnisabfrage nicht filtern): 
    Erledigt: Besetzung. Weiter: Verwendungszweck     
- Suche, Ergebnistabelle: Feldinterne Auflistungen nicht filtern! (für Besetzungen, Besonderheiten umgesetzt, andere folgen )
- Suche: Hilfekapitel 
- Suche, gespeicherte Suche: Zeilenangänge korrigieren 
- URL-Angaben mit Beschreibung zusammenfügen 


### Offene Verbesserungen und Korrekturen
- Hilfe zur Suche, Textsuche: Bitte beachten: In der Ansicht "Satz ..." werden nur Sammlungen / Musikstücke ausgegeben, bei denen ein Satz vorhanden ist. 
- Suche: Layout ändern (responsive) 
- Sammlung Name - FEld im Formular zu kurz 
- Suche: weitere Ansichten z.B: Musikstück Fokus 
- edit forms: Überall autofocus gesetzt?  
- Demo: Beim Öffnen von edit_sammlung.php ist der Screen leer. Problem ist include cl_sammlung - Ursache? 
- Besonderheiten Erfassung Schnellsuche
- edit Satz: Prüfen: Spieldauer, wenn mehr als 60 Minuten  ... 
- Fehler (Nur Edge): Besonderheiten-Typ Screen, Ansteuern des iframes per Button-LInk "Aktualisieren" funktioniert nicht korrekt. 
- delete.php: Löschbarkeit vor (und nicht nach) Nutzerbestätigung prüfen
- Unterformulare, Übersichten: jeweilige Tabellen-Links ergänzen   
- delete-Routinen: Folge-Links prüfen  
- Suche: Beschreibung ergänzen, wenn Genaue Suche ausgewählt 
- iframe-Formulare: Speicherverhalten vereinheitlichen 
- Übersichtstabellen: Bearbeiten-Links müssen auf neuen Tab verweisen
- Erfassung: Umgang mit fehlerhaften Eingabewerten (zu lang, ect.)
- Übersichtstabellen -> Anzahl Zeilen begrenzen
- "Plural-Problem" 
- Auswahlformulare: Verhalten, wenn Werte "verbraucht" sind (cl_html_select.php, print_select - test dev Schwierigkeitsgrad) 
- Validierung Eingabewerte
- für alle edit-Formulare (auch stammdaten-Tabellen) htmlspecialchars() einsetzen
- foreign keys benannt neu anlegen 
- col unsigned - defs entfernen 
- "open new page" vereinheitlichen 
- musikstueck: Spalte "JahrAuffuehrung" löschen
- Formulare: Spaltenbezeichung fett drucken
- Klassen-Dateien umbenennen: cl_* -> class.*  
- Fehlerbehandlung: Bearbeiten-Formular wird bei nicht exisiterender ID geöffnet (siehe Vorlage edit_abfrage.php, cl_abfrage.php) 
- Prüfung XXS,  https://php-de.github.io/jumpto/auswahllisten/
- Hilfe-Seiten: automatisierte Überschriften verbessern 

### Offene Aufgaben Prio 2
- Bookmarks-Import, Übernahme als Sammlungen (Teil 1 (Import) fertig, Übernahme Sammlung fehlt noch)
- Spalten Spalten "ts_insert" und "ts_update"  in edit-Formularen anzeigen 
- Spalte User (Aktualisierung bei insert, update)
- iframe-Formulare: Autofocus auf erstes Feld möglich? 
- Benutzer-Verwaltung  
- Feld "Bestellnummer" entfernen 
- Eingabefelder maxlength prüfen -> soll db Feldlänge entsprechen 
- Eingabefelder autofocus prüfen 
- Erklärung: Warum "Besetzungen" als Einheiten, und nicht aufgefächert in einzelne Instrumente? 
- Handytaugliches Layout 
- Projektbeschreibung erarbeiten 
- Feld "Opus" -> ändern in "Werkverzeichnis" (zumindest im Formular)
- Notensymbole Schrift
- select - Elemente: die rosafärbung ein/ausschaltbar machen
- Spracheingabe 
- Tabelle Schüler, Termin 
- Löschtabellen (Speicherung gelöschter ZEilen) 
- Ausgabe Fehlermeldungen für Anwender verbessern (aktuell nur "ein Fehler ist aufgetreten", Grund bleibt für Anwender unklar)
- Kalender-Tabelle 


### Geplante neue Features 

- Tabelle: material (Name, Beschreibung)
- Neue Tabelle: Schüler, Asoc: Schüler, Stück.  
- Suchefrage: NICHT 
- Tabellen Spalten-Sortierung (per JavaScript, s. https://www.w3schools.com/howto/howto_js_sort_table.asp) 
- MouseOver Infos in der Ergebnis-Tabelle 
- PDF-Export für eine Sammlung 
- Eigenes Git-Repository für das Projekt 

### vorerst verworfen 
- ~~auto_update: Editierungs-Formular~~ aktuell nur Thema für "Service" > "Dataclearing" 

### erledigte Aufgaben 
-  Delete-Funktionen ergänzen (satz->erprobt, sammmlung->besonderheiten) 
-  delete.php: Anzeige Tabellenlink ja/nein konfigurierbar machen 
-  Erprobt- Attribut erweitern 
-  Suche: Filter nach Erprobt Jahr
-  Tabellen-Anzeige show_table2.php
-  Seite "Tests": Inhaltsverzeichnis erzeugen
-  Startseiten-Links aus Tabreihenfolge nehmen 
-  Korrektur: Fehler Erfassungsformular "Schwierigkeitsgrad"  
-  Korrektur: Suche, Gespeicherte Suche: Beschreibungtext bei Speicherung ausblenden
-  Bereinigung Ritardando 
-  Intervalle mit Gruppierungs-Begriff
-  Ansicht "Satz mit Besonderheiten" 
-  Suche, Ergebnisanzeige: Anzahl Zeilen angezeigen
-  Formulare: CSS- Klassen besser zuordnen
-  iframe-(Unterformular)- Aufruf über radiobox Elemenete 
-  Anzeige Anzahl Ergebniszeilen
-  Sammlung Feld "Erfasst" ja/nein, Datenprüfungen nur auf Erfasst=Nein anwenden 
-  Überarbeitung Dataclearing-Formular (Auswahl Tasks)
-  Aufruf "Info-Sichten" auf Startseite einbinden 
-  Spalten "ts_insert" und "ts_update" bei allen Tabellen
-  Verworfen: Instrumentkombis Vorlage für Besetzungen (wird anders/besser gelöst, Datei test_instrumentenkombi.php archiviert)
- show_table2.php -> "Nein einfügen" Link ist verloren gegangen??? 
- Verbesserung Suchlogik: Besetzungen 
- autoupdate verwerfen 
- Suche: Button "Suchen" neben Suchtextfenster 
- Suche: Filterleiste ausblenden 
- Suche: Mehrfach-Kombination "Instrument" / "Schwierigkeitsgrad" getrennt nach Instrument 
