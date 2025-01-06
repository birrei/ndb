
# Changelog  

06.01.2025: Suche: Mehrfach-Kombination "Instrument" / "Schwierigkeitsgrad" getrennt nach Instrumenten in einer Box 

13.12.2024: Umstellung Button Suche neben Suchfeld 

03.12.2024: Begonnen: Verbesserungen an Suchlogik und dazugehörigem Hilfe-Text 

30.11.2024: Snowflakes auf der Startseite (Animation CSS) 

26.11.2024: Spalten "ts_insert" und "ts_update" bei allen Tabellen

25.11.2024: Aufruf "Info-Sichten" auf Startseite (unten) verfügbar  

18.11.2024: Überarbeitung Dataclearing-Formular 

13.11.2024: Neues Feld "Sammlung" > "Erfasst" (+ Filter auf der Sammlungen- Übersichtsseite, Kapitel auf Hilfe-Seite) 

10.11.2024: Chrome-Bookmarks importieren, Teil 1 (Hintergrund: Vorhandene Bookmarksammlung  mit Links zu Noten-Kaufportalen soll importiert und in Sammlungen integriert werden).   

26.10.2024: Unterformular-Aufruf über radiobox Elemente (macht aktuell aktives Unterformular besser sichtbar)

19.10.2024 - Suche: 
 * Ergänzende Suchoption "Aussschluss-Suche". 
 * Neue Ansicht "Satz Besonderheiten" 
 
14.10.2024 - Umstellung Repository - Struktur (dev (nicht Teil er Anwendung), notendb (ANwendungsdateien, für Installation benötigt), service (Zusatz-Aufträge, nicht Teil der Anwendung)) 

11.10.2024 - Suche: Einzelfunktionen "Filter zurücksetzen" auskommentiert (da nicht verwendet, Screen zu überladen). Formatierung Auswahlfelder prägnanter gestaltet. 

09.10.2024 - Suche: Auswahl "Ebene" ersetzt durch Auswahl "Ansicht", Auswahl-Box anstelle Radio-Elemente

02.10.2024 - Übersichtstabelle Sammlung > Filter "Standort" 

01.10.2024 - Filter "Erprobt > Jahr" 

20.09.2024 - Integration Abfragetyp 

01.09.2024 - Umstellung Erprobt auf Mehrfach-Zuordnung, Integration Jahr

27.08.2024 - Genaue Suche für Satz > Besonderheiten. Hilfe-Text dazu.   

22.08.2024 - Gespeicherte Abfragen mit 2 getrennten Eingabeformularen 
  * Anwendermodus (Name, Beschreibung)
  * Expertemodus (SQL Abfrage-Text, Referenztabelle)  

21.08.2024 - Dataclearings-Seite (dataclearing.php): Funktionen (bisher): 
  * Sammlung kopieren (wahlweise mit allen Musikstücken/Sätzen und deren Eigenschaften)
  * Besetzung bei allen Musikstückstücken einer Sammlung hinzufügen / entfernen 
  * Verwendungszweck bei allen Musikstückstücken einer Sammlung hinzufügen / entfernen

02.08.2024
 * Neu: "Sammlung Besonderheiten" (z.B. "Verfügbarkeit" > "Kauf geplant") 
 
19.07.2024: 
 * auf Übersicht-Tabelle link für "Neu anlegen" anzeigen
 * Lösch-Funktion für jede Tabelle  
 * Überarbeitung Pflege "Besonderheiten" 
 * Tests zu "Abfragen" übertragen (keine separaten Views, keine separate Seite) 


10.07.2024: 
 * Stricharten, Notenwerte und Übung übernommen zu "Besonderheiten" 

05.07.2024: 

Schwierigkeitsgrad mit Differenzierung nach Instrument (Instrument kann auch ein Ensemble sein). Bisherige Klappliste ist jetzt Mehrfachauswahl-Unterformular. Im Suchformular sind die Attribute getrennt angezeigt. 

Info: als Standardwert für "Instrument" ist für alle "(Instrument unbestimmt)" eingetragen, mit Ausnahmen akt. Sammlung iD 167 -> anschauen. Ggf. Updates erforderlich? 

Verbesserung der gespeicherten Suche 
 * Checkbox statt Name, Name wird temp. gesetzt (kann später geändert werden)
 * Suchauswahl wird in Beschreibungstext übernommen 

------------

27.06.2024: Für Abfragen, die über die Suche gespeichert werden: Bezeichnungen der gewählten Filter/Kategorien wird in die Beschreibung übernommen 

26.06.2024: Aktualisierung von Unterformularen (iframes) über das Hauptformualar (zusätzlicher Link)

26.06.2024: Einfügen von Mehrfach-Zuordnungen über das Hauptformular  (zusätzlicher Link)

25.06.2024: Startseite, Fußleiste, Bearbeiten-Links aus Übersichtstabellen: die Links werden nicht mehr automatisch im neuen Fenster geöffnet. Innerhalb des Erfassungs-Workflows sollen die Formulare jedoch weiterhin nebeneinander liegen- dort bleibt der Zwang. 

25.06.2024: Erfassung Heftdaten (Sammlung, Musikstück, Satz): Falls in einer Stammdatentabelle (z.B. Verlag, Komponist, Besetzung ...) ein Eintrag ergänzt werden soll: neben den entspr. Auswahl-Feldern ist jetzt ein passernder Link verfügbar. 

23.06.2024: Layout: Breite der Suchfelder-Leiste links ist jetzt fix, die Ergebnis-Tabelle kann sich nach rechts (Umstellung auf CSS Grid)   

22.06.2024: Löschfunktionen für Sammlung, Musikstück, Satz. Der Link zum Aufruf der Löschfunkion ist ganz unten auf dem jeweiligen Bearbeitungs-Screen zu finden.   

----

18.06.2024: Links für Navigation von Satz > Musikstück bzw. Musikstück > Sammlung  

18.06.2024: Suche-Seite: 
 * Auswahlfelder nach Relevanz anordnen (z.B. "Besetzung" oben, "Verlag" unten)
 * Anzahl Zeilen in Mehrfach-Auswahlfeldern (im Code) konfigurierbar  

16.06.2024: Gespeicherte Suchen / Abfragen
 * Eine Suche mit allen Filtereinstellungen kann durch den Anwender als Abfrage abgespeichert werden. 
 * Eigene Abfragen können angelegt werden (Bereitstellung Admin -> Anwender, da SQL-Kenntnisse erforderlich)
 Demo für Anwender folgt.    

12.06.2024: Ungespeicherte Änderungen im Formular werden sichtbar gemacht. 
Sobald in Formularfeld eine Eingabe/Änderung erfolgt, wird eine auffällige 
Hintergrundfarbe angezeigt. Nach dem Speichern verschwindet die Hintergrundfarbe wieder 
Dagegen (vorerst) verworfen: Beim Schließen des Formulars automatisch speichern, nicht empfehlenswert. .. Ergänzung 21.06.2024: die Einstellung kann im Browser (hier Chrome) evt. überschrieben werden: die Texteingabe - Felder mit (vom Browser bereitgestellten)"Nachschlagefunktion" lässt den Hintergrund bei Eingabe hellblau erscheinen. 

----

10.06.2024: DataClearing- Script: Die Daten zu einer LookupTypID (Besonderheit Typ ID) sollen aus der Datebank gelöscht werden können (Verknüpfungen und Stammdaten)

10.06.2024 - load_row()-Funktionen als Standart nach insert/update
Nach  insert/update-Operation sollen im Formular nicht die zuvor aus dem Formular gesendeten, sondern die in der Zeile zu einer ID gespeicherten Werte abgerufen werden (es soll sichtbar werden, falls ein zuvor eingegebener Wert fehlerhaft abgespeichert wurde)

06.06.2024 
  - Erweiterten Titel im Registerblatt anzeigen

30.05.2024 - Spieldauer:   
  - Anzeige: Erfassung in Sekunden, Anzeige bei Abfrag-Ergebnissen in "'" / "''" - Notation 
  - Suche: Eingabe in Minut. / Umrechnung (wie ERfassung) 

-----------------
30.05.2024: 
  - Überarbeitung Suche-Seite Layout (Auswahl-Felder jetzt am linken Rand) 
  - Name- und Bemerkung- Felder vergrößert (Sammlung, Satz, Musikstück) 
  - Kategorisierung Besonderheiten (eigene Kategorien können angelegt werden)
  - Textsuche erfasst auch "Besetzung"-Texte
  - Startseite, Sammlung, "Daten anzeigen": wird jetzt nach ID abwärts sortiert (die zuletzt angelegte Sammlung steht oben)

26.04.2024 - Abschluss: Integration Satz > Übung 
Stand: 25.04.2024: 
umgesetzt: Spieldauer Erfassungswert in Sekunden ändern 
  * Für Erfassung: Angabe in Minuten verfügbar, + autom. Umrechnung
  * Für Suche: Änderung auf Sekunden-Eingabe 
  * Dataclearing: Update Minutenwerte auf Sekunden  

