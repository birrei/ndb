<?php 
include('head.php');
?>

<h2> Info zu abgeschlossenen Arbeiten </h2>
<pre>
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


</pre>


<h2> In Planung  </h2>
<pre>
  * Such-Seite: Ergebnistabelle erweitern
  * Such-Seite: Ergebnistabelle nach einzelnen Spalten sortierbar 
  * Such-Seite: weitere Suchfilter 
    * Spieldauer von bis
    * Komponist? 
    * Standort?  
    * .... 
  * Tests: 
    * Sammlung ohne Standort bzw. Standort "XXX"
    * Testviews Musikstück: Sammlung Name mit anzeigen 
  * Erfassung Satz:
    * Funktion: Feldinhalte aus anderem Satz des gleichen Musikstücks übernehmen (Checkbox "bekannte Eigenschaft übernehmen"?)   
    * Nummer automatisch besetzen
    * neues Feld: Aufführungsmaterial vorhanden
    * Feld "Melodische Besonderheiten"
    * Feld: "Rhythmische Besonderheiten"
    * Feld "Übung"
    * Löschfunktionen 

  </pre>


<?php 
include('foot.php');
?>

