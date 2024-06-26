﻿
# in Arbeit 
  * Abfage -> Beschreibungstext für Lookups 
  * Bearbeitungs-Formular für Link-Typen 
  * Sammlung -> neues Feld "Materialinformation

-----------------

# In Planung

## Review mit AG 
 * Sammlung Links mit oder ohne Typen? 
 * "Stricharten" / "Notenwerte" zu "Besonderheiten" ?  

## Neue Features

## Verbesserungen

  * Fehlerbehandlung, falls Bearbeiten-Formular bei nicht exisiterender ID geöffnet wird (siehe Vorlage edit_abfrage.php, cl_abfrage.php) 
  * Aktualisierngs-Datum / -zeit für jede Tabelle 
  * Logging 

## Dokumentation / Hilfekapitel 
  * Hilfe: How To: Einrichtung neue Besonderheit - Kategorie
  * Gespeicherte Suchen 

----- 
  * Lookups ("Besonderheiten") auch für Sammlung und Musikstück  
  * Tabelle lookup_type Feld type_key muss eindeutig sein (unique constraint anlegen)
  * Links zur Sammlung (Digitale Exemplare, Links zu Bestellung)
  * Link Typ insert Bearbeitung  

  * Sammlung (einfach-) Zuordnung "Info Aufführungsmaterial"  

  * Darstellung der Besonderheiten in Abfrage-Ergebnissen verbessern 
      (Typ Name im Feld nur 1 x anzeigen)

  * Schwierigkeitsgrad Mehrfachzuordnung!, Zuweisung an Stimme / Orchester 

  * Verknüpfung zwischen Sammlungen festlegen 
  * Musikstück Aufführungsjahre - Auswahlfeld 

  * Wenn nach einem Eintrag aus Mehrfach-Zuordnungen gesucht (gefiltert) wird, erscheint im Abfrageergebnis nur diese Zuordnung (auch dann, wenn es noch andere Zuordnungen gibt)  Demo für AG: Musikstück mit mehreren Besetzungen - Nicht ideal, sollte wenn möglich noch geändert werden 

  * Erfassung Satz 
    * (vorerst verworfen: Satz > Taktart: Mehrfachauswahl) 
  * Feld. "Aufführungsmaterial vorhanden"    
  * Gespeicherte Suchen 
  * Erfassungsformular: beim Schließen automatisch speichern (geht das?)
  * Korrektur: Suchfenster, Tabelle Bearbeiten soll auf die angezeigte Tabelle zeigen 
  * Korrektur: Bearbeiten-Funktion aus Ansicht v_satz funktioniert nicht 
  * Korrektur: iFrame-Formulare: Reaktion, wenn Speichern ohne Auswahl gedrückt wird 
     --> Anpassung entspr. Datei edit_satz_list_lookups.php (Prüfung auf leeren parameter) 
  * Korrektur: für alle edit-Formulare (auch stammdaten-Tabellen) htmlspecialchars() einsetzen 
  * Klärung intern: autofocus-Funktion bei allen selects so nicht sinnvoll   
  * Sammlung, Musikstück, Satz: Validierung Eingabewerte
  * Löschfunktion (im Bearbeiten-Formularen) 
    * Funktion: Feldinhalte aus anderem Satz des gleichen Musikstücks übernehmen (Checkbox "bekannte Eigenschaft übernehmen"?) 
  * Handytaugliches Layout 
  * Such-Seite: weitere Suchfilter nach Erweiterung Auswahltabellen 
    * Satz: Tonart, Taktart, Tempobezeichnung, Lagen 
  * Suche: Validierung von manuell eingegeben Such-Parametern (z.B: SpieldauerBis > SpieldauerBis ect.)
  * Such-Seite: Ergebnistabelle nach einzelnen Spalten sortierbar 
  * Suchseite: Optimierung per AJAX ?

  * Tabelle über Tabellen-Spalten- Links sortieren (Javascript)
  * Datenblatt für eine Sammlung 
  * Hilfe-Seite 
  * Musikstück löschen, Satz löschen
  * Eingabefelder maxlength prüfen -> soll db Feldlänge entsprechen 
  * Eingabefelder autofocus prüfen 
  * Projektbeschreibung erarbeiten 
  * Feld "Opus" -> ändern in "Werkverzeichnis" (zumindest im Formular)
  * Stricharten übernehmen zu Besonderheiten? 

