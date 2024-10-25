
###  Aufgaben in Arbeit
- [ ] delete.php: Löschbarkeit vor (und nicht nach) Nutzerbestätigung prüfen

### Offene Aufgabe, neue Features 
- [ ] Sammlung "Erfassungstatus" (vom Anwender gesetzt. .. "Vollständig" Sammlung wird in Tests erfasst, unvollständig nicht", da Unvollständigkeit bekannt/akzeptiert) 
- [ ] Tabellen Spalten-Sortierung (per JavaScript, s. https://www.w3schools.com/howto/howto_js_sort_table.as
- [ ] Alle Tabellen mit "erstellt" und "geändert"-Spalten 
- [ ] Logging (Datum, Name)
- [ ] MouseOver Infos in der Ergebnis-Tabelle 
- [ ] PDF-Export für eine Sammlung 
- [ ] Seite für "info-Views" (entspr. Tests- Seite) 
- [ ] Eigenes Git-Repository für das Projekt 
- [ ] Ausgabe Fehlermeldungen für Anwender verbessern (aktuell nur "ein Fehler ist aufgetreten", Grund bleibt für Anwender unklar)


### Offene Verbesserungen und Korrekturen 
- [ ] Unterformulare, Übersichten: jeweilige Tabellen-Links ergänzen   
- [ ] delete-Routinen: Folge-Links prüfen  
- [ ] Suche: Beschreibung ergänzen, wenn Genaue Suche ausgewählt 
- [ ] iframe-Formulare: Speicherverhalten vereinheitlichen 
- [ ] Übersichtstabellen: Bearbeiten-Links müssen auf neuen Tab verweisen
- [ ] Erfassung: Umgang mit fehlerhaften Eingabewerten (zu lang, ect.)
- [ ] Übersichtstabellen -> Anzahl Zeilen begrenzen
- [ ] "Plural-Problem" 
- [ ] Datum Spalten "erstellt" und "geändert" bei allen Tabellen
- [ ] Auswahlformulare: Verhalten, wenn Werte "verbraucht" sind (cl_html_select.php, print_select - test dev Schwierigkeitsgrad) 
- [ ] Validierung Eingabewerte
- [ ] für alle edit-Formulare (auch stammdaten-Tabellen) htmlspecialchars() einsetzen
- [ ] foreign keys benannt neu anlegen 
- [ ] col unsigned - defs entfernen 
- [ ] "open new page" vereinheitlichen 
- [ ] musikstueck: Spalte "JahrAuffuehrung" löschen
- [ ] Formulare: Spaltenbezeichung fett drucken
- [ ] Klassen-Dateien umbenennen: cl_* -> class.*  

### Offene Aufgaben Prio 2
- [ ] iframe-Formulare: Autofocus auf erstes Feld möglich? 
- [ ] Benutzer-Verwaltung  
- [ ] Hilfe: Erfassung Schwierigkeitsgrad / Instrumente 
- [ ] Tabelle Schüler, Termin 
- [ ] Anzeige Anzahl Ergebniszeilen
- [ ] Spracheingabe 
- [ ] Fehlerbehandlung: Bearbeiten-Formular wird bei nicht exisiterender ID geöffnet (siehe Vorlage edit_abfrage.php, cl_abfrage.php) 
- [ ] Kalender-Tabelle 
- [ ] Feld "Bestellnummer" entfernen ?
- [ ] Eingabefelder maxlength prüfen -> soll db Feldlänge entsprechen 
- [ ] Eingabefelder autofocus prüfen 
- [ ] Erklärung: Warum "Besetzungen" als Einheiten, und nicht aufgefächert in einzelne Instrumente? 
- [ ] Handytaugliches Layout 
- [ ] Projektbeschreibung erarbeiten 
- [ ] Feld "Opus" -> ändern in "Werkverzeichnis" (zumindest im Formular)
- [ ] Notensymbole Schrift
- [ ] select - Elemente: die rosafärbung ein/ausschaltbar machen

### erledigte Aufgaben 
- [X] Delete-Funktionen ergänzen (satz->erprobt, sammmlung->besonderheiten) 
- [X] delete.php: Anzeige Tabellenlink ja/nein konfigurierbar machen 
- [X] Erprobt- Attribut erweitern 
- [X] Suche: Filter nach Erprobt Jahr
- [X] Tabellen-Anzeige show_table2.php
- [X] Seite "Tests": Inhaltsverzeichnis erzeugen
- [X] Startseiten-Links aus Tabreihenfolge nehmen 
- [X] Korrektur: Fehler Erfassungsformular "Schwierigkeitsgrad"  
- [X] Korrektur: Suche, Gespeicherte Suche: Beschreibungtext bei Speicherung ausblenden
- [X] Bereinigung Ritardando 
- [X] Intervalle mit Gruppierungs-Begriff
- [X] Ansicht "Satz mit Besonderheiten" 
- [X] Suche, Ergebnisanzeige: Anzahl Zeilen angezeigen
- [X] Formulare: CSS- Klassen besser zuordnen
- [x] iframe-(Unterformular)- Aufruf über radiobox Elemenete 

### vorerst verworfen 
- [ ] ~~auto_update: Editierungs-Formular~~ aktuell nur Thema für "Service" > "Dataclearing" 
