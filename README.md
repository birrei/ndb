
# Change Log  

12.07.2024: 
 * auf Übersicht-Tabelle link für "Neu anlegen" anzeigen
 * Lösch-Funktion für jede Tabelle  
 * Überarbeitung Pflege "Besonderheiten" 

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


----


# Das Projekt

Datenbank mit Web-Anwendung für die Erfassung und Abfrage von Notenmaterial für Musikunterricht und Orchester. Fokus: Abfragen für den Praxis-Einsatz (z.B. Verwendungszweck, Besetzung, Schwierigkeitsgrad etc., inbesondere an Musikschulen) Aktuell nicht für bibliographische Erfassung gedacht.  Das Programm ist parallel  zur konkreten Verwendung entstanden, Anforderungen konnten iterativ aufgenommen werden.  

# Team
 * 1 Musiklehrer / Orchsterleitung
 * 1 Entwickler


# Technik    
 * PHP: Version 8.2.12 (dev) - Richtlinien: OOP, PDO, Prepared Statements (Absicherung gegen SQL-Injection)
 * DB: 10.4.32-MariaDB (dev), MySQL 5.7.42-log (prod) (letztere Version kennt keine CTEs ...)
 * Layout: CSS Grid (anstelle Tabellen, noch nicht in allen Teilen konsequent umgesetzt)
 * Browser: Chrome, Edge (aktuellste Versionen)
 * JavaScript wurde sparsam eingesetzt (XXX beschreiben, welche Funktionen genau )

---

