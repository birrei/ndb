
###  Aufgaben in Arbeit

- [ ] auto_update 
- [ ] delete.php: Löschbarkeit VOR Nutzerbestätigung prüfen

### Offene Aufgaben 
* Startzeiten-Links aus Tabreihenfolge nehmen 
* Sammlung "Druckansicht/Datenblatt" 
* Übersicht Sammlung: Sortierung nach Name
* Tabellen Spalten-Sortierung (per JavaScript, s. https://www.w3schools.com/howto/howto_js_sort_table.asp) 
* Suche, Ergebnisanzeige: Anzahl Zeilen angezeigen  
* Eigenes Git-Repository für das Projekt 
* Logging (Datum, Name)
* Konfiguration Fehlerausgabe
* Tabellen-Anzeige show_table2.php

### Verbesserungen, Korrekturen 
* delete-Routinen: Folge-Links prüfen  
* Suche: Beschreibung ergänzen, wenn Genaue Suche ausgewählt 
* iframe-Formulare: Speicherverhalten vereinheitlichen 
* Übersichtstabellen: Bearbeiten-Links müssen auf neuen Tab verweisen
* Überall html -> print_table2 verwenden
* Erfassung: Umgang mit fehlerhaften Eingabewerten (zu lang, ect.)
* Übersichtstabellen -> Anzahl Zeilen begrenzen
* "Plural-Problem" 
* Suche: Filter IDs über GET zur Verfügung stellen
* Datum Spalten "erstellt" und "geändert" bei allen Tabellen
* iframe-Formular: Autofocus auf ertes Feld ? 
* Auswahlformulare: Verhalten, wenn Werte "verbraucht" sind (cl_html_select.php, print_select - test dev Schwierigkeitsgrad) 
* Validierung Eingabewerte
* Sortierung über Spaltentitel (Javascript)
* für alle edit-Formulare (auch stammdaten-Tabellen) htmlspecialchars() einsetzen
* foreign keys benannt neu anlegen 
* col unnsigned - defs entfernen 
* Formulare Bezeichnungen alle Fett drucken 
* "open new page" vereinheitlichen 
* iframe-aufruf-Buttons: farbig, wenn aktiv 
* musikstueck: Spalte "JahrAuffuehrung" löschen

### Offene Aufgaben Prio 2
* Benutzer-Verwaltung  
* Formulare: Spaltenbezeichung fett drucken 
* Hilfe: Erfassung Schwierigkeitsgrad / Instrumente 
* Tabelle Schüler, Termin 
* Anzeige Anzahl Ergebniszeilen
* Spracheingabe 
- Fehlerbehandlung: Bearbeiten-Formular wird bei nicht exisiterender ID geöffnet (siehe Vorlage edit_abfrage.php, cl_abfrage.php) 
* Kalender-Tabelle 
* Feld "Bestellnummer" entfernen ?
* Eingabefelder maxlength prüfen -> soll db Feldlänge entsprechen 
* Eingabefelder autofocus prüfen 
* Erklärung: Warum "Besetzungen" als Einheiten, und nicht aufgefächert in einzelne Instrumente? 
* Handytaugliches Layout 

* Projektbeschreibung erarbeiten 
* Feld "Opus" -> ändern in "Werkverzeichnis" (zumindest im Formular)
* Notensymbole Schrift



### Notizen für Doku: 
* Untertabellen / Unterformulare - Unterschied 1) mit / 2) ohne Schnell-Löschmöglichkeit: 1: Gespeichert sind nur Verknüpfungsinformationen (die leicht wiederhergestellt werden können).    


### erledigte Aufgaben 
* Delete-Funktionen ergänzen (satz->erprobt, sammmlung->besonderheiten) 
* delete.php: Löschung Musikstück / Satz ohne abschließenden Tabellenlink  
* Erprobt- Attribut erweitern 
* Suche: Filter nach Erprobt Jahr
