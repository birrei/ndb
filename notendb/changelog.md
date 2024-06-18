18.06.2024: Links zum Navigieren von Satz > Musikstück > Sammlung  

18.06.2024: Suche-Seite: 
 * Auswahlfelder nach Relevanz anordnen (z.B. "Besetzung" oben, "Verlag" unten)
 * Anzahl Zeilen in Mehrfach-Auswahlfeldern (im Code) konfigurierbar  

16.06.2024: Gespeicherte Suchen / Abfragen
 * Eine Suche mit allen Filtereinstellungen kann durch den Anwender als Abfrage abgespeichert werden. 
 * Eigene Abfragen können angelegt werden (Bereitstellung Admin -> Anwender, da SQL-Kenntnisse erforderlich)
 Demo für Anwender folgt.    

12.06.2024: Ungespeicherte Änderungen im Formular werden sichtbar gemacht. 
Wenn im Formularfeld eine Eingabe/Änderung erfolgt, wird eine auffällige 
Hintergrundfarbe angezeigt. Nach dem Speichern verschwindet die Hintergrundfarbe wieder 
Dagegen (vorerst) verworfen: Beim Schließen des Formulars automatisch speichern, nicht empfehlenswert. 

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

-----------------

18.04.2024: Umstellung Satz > Schwierigkeitsgrad (Vorlage: Satz > Erprobt) 
  * Tabellen erstellen + Inhalte migrieren : 20240418_satz_schwierigkeitsgrad.sql
  * Anpassen: View v_satz
  * erstellen: cl_schwierigkeitsgrad.php (Kopie von cl_erprobt)
  * erstellen: insert_schwierigkeitsgrad.php
  * erstellen: edit_schwierigkeitsgrad.php 
  * ergänzen: Zeile in index.php 
  * cl_satz.php: Feld "Schwierigkeitsgrad" ändern in "SchwierigkeitsgradID"  
  * edit_satz.php: Feld "Schwierigkeitsgrad" ändern in Select-Element  
  * Anpassung cl_musikstueck (Abfrage für print_table_saetze())
  * Erfassung / Bearbeitung / Abrufe testen 
    * Auch Speichern mit leeren Feldern (nicht getroffener Auswahl) testen!
  * Ergänzen/anpassen: suche.php (! aus Text-Suche rausnehmen!)
  * Testview "satz ohne Schwierigkeitsgrad-Angabe"   
  * Produduktivnahme - 19.04.2024 
  * info unter changelog.md    

--------------------------------
--------------------------------

Alt - neu abwärts

  * 27.02.2024: Musikstück > Verwendungszweck Mehrfachauswahl  

  * 28.02.2024: zu "Suche Musikstück": 
    * Ergänzung "Verwendungszweck"
    * Filterboxen-Auswahl bleibt nach Suchvorgang erhalten. 
    * Funktion "Auswahlbox zurücksetzen"
    * Spalten in Ergebnistabelle ergänzt 

  * 29.02.2024
    * <a href="tests.php">Tests-Seite</a> 
    * <a href="help.php">Hilfe-Seite</a> (erste Notizen, weiteres folgt)
    * Überarbeitung Fußleiste 
    * Diese Updates-Seite 
------------------------

  * 01.03.2024
    * Startseite: alle hinterlegten Links im neuen Fenster, Startseite bleibt offen 


Info zum 01.03.2024 
  * 05.03.2024: 
    * Hilfeseite Fortsetzung 
    * (Erst-) Erfassungs-Formulare: Link "Tabelle anzeigen" wirder entfernt, da zu verwirrend, in Praxis bisher nicht verwendet) 
------------------------

Info zum 17.03.2024  

  * 17.03.2024 - <b>Änderung <a href="search_musikstueck.php">Musikstück Such-Formular</a> Ergebnis-Tabelle:</b> 
    Anzeige wird auf Musikstück aggregiert -> Spalte  "Besetzungen" zeigt alle Besetzungen mit Komma getrennt. 
    So ergibt sich nur eine Zeile pro Musikstück auch bei mehreren Besetzungen 
    
  * 16.03.2024  <b>Sammmlung Auswahl Standort</b> 
    * Umstellung sammlung.Standort -> StandortID s. (Repository s. sql\20240316_standort.sql) 
    * Anpassung Anwender: 
    * Neue Tabelle "Standort" -> Einstieg auf Startseite (und Fußteil) ergänzt 
    * Sammlung: Standortauswahl über Klappliste 
    
  * 15.03.2024 <b>Verbesserung zur Auswahl / Anzeige "Komponist" </b> 
    * Neue View v_select komponist Hinterlegt für Auswahl Musikstück > Komponist
      Anzeige "Name" berücksichtigt, dass entweder Vorname oder Nachname leer sein können 
    * Komponist Nachname neu "(unbekannt)" -> ID 53
    * Musikstücke mit KomponistID=0 -> KomponistID 53
    * Komponist Eintrag mit ID 0 löschen (sonst wurde das bisher als default für leere Einträge angezeigt, was falsch ist)
    

------------------------
Info zum 26.03. 
  * Info: Erfassung Musikstück / Satz:
    * Nummer-Felder werden mit Vorgabewert "1" besetzt (was natürlich geändert werden kann) 
    * Wenn Musikstück Name leer bleibt, wird "Musiksück [Nr]" gespeichert.
    * Wenn Satz Name leer bleibt, wird "Satz [Nr]" gepsichert 
  * Info: Musikstück > Gattung als Untertabelle 
  * Info: Musikstück > Epoche als Untertabelle 
  * Info: Suchfomular: + Epoche, + Gattung, + Spieldauer von / bis 
  * Info: Suchformular: Auswahl Ebene. Die Auswahl hat Einfluss auf die angezeigten Spalten, die Gruppierung sowie die Sortierung 

Klärung: 
  * Satz > Spieldauer - ältere Werte unklar

Ausblick: 
  * In Arbeit: Satz "Notenwerte" als Untertabelle mit Mehrfach-Auswahl 
  * Geplant: Umstrukturierung weitere Satz-Tabellenfelder,  noch offene Felder 

------------------------

Info zum 29.03.: 
* Suchformular: Funkion "alle Filter zurücksetzen", + Filter "Notenwerte"
  * Korrektur Satz.-Nr (0 oder leer -> 1 )
  * Umstellung Satz > Notenwerte (Bearbeitung, Suche etc.)
     dazu: Neuer Ablauf "Erfassen" - > "Bearbeiten" (wird noch auf andere Seiten auch angewandt, bisher nur Satz > Notenwerte)  
  * Hinweis: Formulare  "Erfassung->Bearbeitung" werden nochmal überarbeitet, ausserdem wird es für Unterformulare es eine Löschfunktion geben 

-------------------

05.04.2024 erledigt: 
	* insert_notenwert.php / edit_notenwert.php
	* insert_verlag.php / edit_verlag.php
	* insert_standort.php / edit_standort.php
	* insert_komponist.php / edit_komponist.php
	* insert_besetzung.php /   edit_besetzung.php
	* insert_verwendungszweck.php /    edit_verwendungszweck.php
	* insert_epoche.php / edit_epoche.php
	* insert_gattung.php / edit_gattung.php
	* insert_strichart.php /  edit_strichart.php
	* insert_sammlung.php / edit_sammlung.php
  * edit_satz_list_notenwerte.php
  * edit_satz_add_notenwert.php
  * edit_sammlung_add_musikstueck.php / edit_sammlung_list_musikstuecke.php
  edit_musikstueck.php
  edit_musikstueck_add_besetzung.php
  edit_musikstueck_add_satz.php
  edit_musikstueck_add_verwendungszweck.php
  edit_musikstueck_list_besetzungen.php
  edit_musikstueck_list_saetze.php
  edit_musikstueck_list_verwendungszwecke.php
  edit_satz.php
  edit_satz_add_strichart.php
  edit_satz_list_stricharten.php


Sonstiges 26.03.204  
  * Such-Seite: Filter Spieldauer von bis   
  * Anpassung Erfassung: Musikstueck.Nummer, Satz.Nr + jeweils Name - Vergabe-Automatismus 
  * Anpassung Erfassung: edit_sammlung_add_musikstueck.php: default-Wert 0 


28.03.2024, 29.03.2024: 
  * Alle Suchformular-Felder in einem Rutsch leeren 
  * Umstellung Satz > Notenwerte 
    * Tabellen erstellen + Inhalte migrieren : 20240326_satz_notenwerte.sql
    * Anpassen: View v_musikstueck, v_satz  
    * erstellen: cl_notenwert.php
    * erstellen: insert_notenwert.php (verbesserte Variante)
    * erstellen: edit_notenwert.php (verbesserte Variante)
    * ergänzen: Zeile in index.php 
    * anpassen: cl_satz: function add_notenwert 
    * anpassen: cl_satz: function print_table_notenwerte  (angepasste Variante!)
    * cl_satz.php: Feld "Notenwerte" entfernen 
    * edit_satz.php: Feld "Notenwerte" entfernen 
    * erstellen: edit_satz_add_notenwert.php (verbesserte Variante!)
    * erstellen: edit_satz_list_notenwerte.php  (verbesserte Variante!)
    * Erfassung / Bearbeitung / Abrufe testen 
    * Ergänzen/anpassen: search_musikstueck.php 
    * View v_tmp_Notenwerte löschen, def. aus ddl_views.sql entfernen
    * Produduktivnahme - 29.03.2024 - 17:00 

Tabellen-Anpassung Musikstück / "Gattung"
 * Tabellen erstellen + Inhalte migrieren DDL: ..\sql\20240321_gattung.sql
 * Anpassen: View v_musikstueck, v_satz  
 * erstellen: cl_gattung.php 
 * erstellen: insert_gattung.php 
 * erstellen: edit_gattung.php 
 * anpassen: cl_musiksteuck.php: Spalte Epoche entfernen, Spalte GattungID ergänzen 
 * anpassen: edit_musikstueck.php 
 * Ergänzen: index.php, foot.php 
 * Erfassung / Bearbeitung testen 
 * Ergänzen/anpassen: Suchbox / Filter: search_musikstueck.php 
 * Feld musikstueck.Gattung löschen: ALTER TABLE musikstueck DROP Epoche
 * View löschen: drop view v_tmp_Gattungen

Tabellen-Anpassung Musikstück / "Epoche"  
  * Tabellen erstellen + Inhalte migrieren DDL: ..\sql\20240324_epoche.sql
  * Anpassen: View v_musikstueck, v_satz  
  * erstellen: cl_epoche.php 
  * erstellen: insert_epoche.php 
  * erstellen: edit_epoche.php 
  * anpassen: cl_musiksteuck.php: Epoche -> EpocheID 
  * anpassen: edit_musikstueck.php : Epoche -> EpocheID 
  * Ergänzen: index.php, foot.php 
  * Erfassung / Bearbeitung / Abrufe testen 
  * Ergänzen/anpassen: Suchbox / Filter: search_musikstueck.php 
  * Feld musikstueck.Epoche löschen: ALTER TABLE musikstueck DROP Epoche 
  * View v_tmp_Epochen aus ddl_views.sql entfernen, View löschen  
  * Produktivnahme: 
  * 20240324_epoche.sql
  * Dateien auf FTP-Server erneuern 
  * ddl_views*- ausführen
  * Test Erfassung 
  * Test Bearbeitung 
  * Test Suche 
  * Feld musikstueck.Epoche löschen: ALTER TABLE musikstueck DROP Epoche 
  * drop view v_tmp_Epochen

---------------

  * 08.04.2024 - Suche: In Textfeldern suchen (Text-Teilstrings!)
  * 08.04.2024 - Suche Ergebnistabelle: Bemerkung-Felder werden ebenfalls angezeigt
  
  * 09.04.2024 - Korrektur: Fehler bei Speichern ohne Auswahl Erprobt
  * 09.04.2024 - Auswahl-Feld "Erprobt" (Erfassung, Suche, Testview) 
  * 09.04.2024 - Suche Ergebnistabelle: "Bearbeiten" Zeigt je nach Ebene auf Sammlung, Musikstück, Satz 


  * 09.04.2024: Umstellung Satz > Erprobt: 
    * Tabellen erstellen + Inhalte migrieren : 20240408_satz_erprobt.sql
    * Anpassen: View v_satz
    * erstellen: cl_erprobt.php
    * erstellen: insert_erprobt.php
    * erstellen: edit_erprobt.php 
    * ergänzen: Zeile in index.php 
    * cl_satz.php: Feld "Erprobt" ändern in "ErprobtID"
    * edit_satz.php: Feld "Erprobt" ändern in Select-Element  
    * Anpassung cl_musikstueck (Abfrage für print_table_saetze())
    * Erfassung / Bearbeitung / Abrufe testen 
      * Auch Speichern mit leeren Feldern (nicht getroffener Auswahl) testen!
    * Ergänzen/anpassen: suche.php (! aus Text-Suche rausnehmen!)
    * View v_tmp_Erprobt löschen, def. aus ddl_views.sql entfernen
    * Altes Feld "Satz.Erprobt" entfernen 
    * nochmal testen: Suche, Erfassung Satz
    * Testview "satz ohne erprobt-Angabe"   
    * Produduktivnahme - 09.04.2024 
    * info unter aufgaben.md


-----------------

