
# in Arbeit
Seit: 26.04.2024 - Integration Satz > Übung  
zu: Satz / neue Mehrfachzuordnungen (Übernahme aus satz.Bemerkung) 
  * Übung
  * Melodische Besonderheiten
  * Rhythmische Besonderheiten
  * Dynamische Besonderheiten 

---------------


# Klärung offen 

Stand: 25.04.2024: 
umgesetzt: Spieldauer Erfassungswert in Sekunden ändern 
  * Für Erfassung: Angabe in Minuten verfügbar, + autom. Umrechnung
  * Für Suche: Änderung auf Sekunden-Eingabe 
  * Dataclearing: Update Minutenwerte auf Sekunden  

Offen: Klärung mit AG zu korrekter Notation, Demo: select * from v_tmp_Spieldauer

---------------

# In Planung: 
  * Gespeicherte Suchen ! 
  * Seiten-Titel im Register anzeigen 
  * Erfassung Satz 
    * (vorerst verworfen: Satz > Taktart: Mehrfachauswahl) 
  * Feld. "Aufführungsmaterial vorhanden"    
  * Gespeicherte Suchen 
  * Korrektur: Suchfenster, Tabelle Bearbeiten soll auf die angezeigte Tabelle zeigen 
  * Korrektur: Bearbeiten-Funktion aus Ansicht v_satz funktioniert nicht 
  * Korrektur: iFrame-Formulare: Reaktion, wenn Speichern ohne Auswahl gedrückt wird  
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
  * Suchformular mit GET-Parametern (so könnten Such-Links gespeichert werden)
    * oder: gespeicherte Suche (Abfragen mit Namen / SQL abspeichern) 
  * Warnung, wenn Datensatz nicht gespeichert ist 
  * Links zum navigieren von Satz -> Musikstück -> Sammlung
  * Tabelle über Tabellen-Spalten- Links sortieren (Javascript)
  * Datenblatt für eine Sammlung 
  * Hilfe-Seite 
  * Musikstück löschen, Satz löschen

# Tester 
 * Musikstück mit mehreren Sätzen: ID 72  

-----


# Erledigt 

       
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
  
  * 09.04.2024 - Korrektur: Fehler bei Speichern ohne Auswahl Erprobt
  * 09.04.2024 - Auswahl-Feld "Erprobt" (Erfassung, Suche, Testview) 
  * 09.04.2024 - Suche Ergebnistabelle: "Bearbeiten" Zeigt je nach Ebene auf Sammlung, Musikstück, Satz 
  * 08.04.2024 - Suche: In Textfeldern suchen (Text-Teilstrings!)
  * 08.04.2024 - Suche Ergebnistabelle: Bemerkung-Felder werden ebenfalls angezeigt
  

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

Sonstiges 26.03.204  
  * Such-Seite: Filter Spieldauer von bis   
  * Anpassung Erfassung: Musikstueck.Nummer, Satz.Nr + jeweils Name - Vergabe-Automatismus 
  * Anpassung Erfassung: edit_sammlung_add_musikstueck.php: default-Wert 0 


05.04.2024 
 

erledigt: 
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


# erledigt 

------------------------
Info zum 29.03.: 
* Suchformular: Funkion "alle Filter zurücksetzen", + Filter "Notenwerte"
  * Korrektur Satz.-Nr (0 oder leer -> 1 )
  * Umstellung Satz > Notenwerte (Bearbeitung, Suche etc.)
     dazu: Neuer Ablauf "Erfassen" - > "Bearbeiten" (wird noch auf andere Seiten auch angewandt, bisher nur Satz > Notenwerte)  
  * Hinweis: Formulare  "Erfassung->Bearbeitung" werden nochmal überarbeitet, ausserdem wird es für Unterformulare es eine Löschfunktion geben 

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

Info zum 01.03.2024 
  * 05.03.2024: 
    * Hilfeseite Fortsetzung 
    * (Erst-) Erfassungs-Formulare: Link "Tabelle anzeigen" wirder entfernt, da zu verwirrend, in Praxis bisher nicht verwendet) 

------------------------

  * 01.03.2024
    * Startseite: alle hinterlegten Links im neuen Fenster, Startseite bleibt offen 

  * 29.02.2024
    * <a href="tests.php">Tests-Seite</a> 
    * <a href="help.php">Hilfe-Seite</a> (erste Notizen, weiteres folgt)
    * Überarbeitung Fußleiste 
    * Diese Updates-Seite 

  * 28.02.2024: zu "Suche Musikstück": 
    * Ergänzung "Verwendungszweck"
    * Filterboxen-Auswahl bleibt nach Suchvorgang erhalten. 
    * Funktion "Auswahlbox zurücksetzen"
    * Spalten in Ergebnistabelle ergänzt 
  
  * 27.02.2024: Musikstück > Verwendungszweck Mehrfachauswahl  


  -----

