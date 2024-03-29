<?php 
include('head.php');
?>

<h2>Zum nächsten Termin</h2>
<pre>

 * Korrektur Satz.Nr (0 oder leer -> 1 )



</pre>

<pre>
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

</pre>

Aufaben Planung und laufendes Protokoll: <a href="https://github.com/birrei/ndb/blob/main/notendb/aufgaben.md">Aufgaben</a>

<?php 
include('foot.php');
?>

