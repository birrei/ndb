<?php 
include('head.php');
?>
<pre>
Zum nächsten Termin - Neu: 

  * Erfassungsformular wechselt automatisch zum Bearbeitungsformular 
  * Erfassung Musikstücke und Sätze: Nummer wird automatisch hochgezählt, 
      automatisierte Namen-Vergabe in Klammern   
  * Erfassungs-(Haupt.)-Formulare enthalten oben unter der Überschrift die Info zur letzten Aktion in blauer Schrift 
  * in Unterformularen ist die Funktion "Erfassung beenden" entfernt, 
      stattdessen muss das Formular-Feld zur Ergänzung einer Zuordnung erneut aufgerufen werden 
      (etwas unbequemer, aber transparenter) 
  * innerhalb eines Bearbeitungs-Formulars ist die Aktualisierung einer Seite (per F5) nicht mehr geeigent 
     (es kommt die Warnung wg. das erneuten SEnden eines Formulars - das funktioniert bei klicken auf "ja" zwar schon, ist aber nicht ideal). 
      -> Stattdessen bitte einfach "Speichern" drücken. 
  * Der Speichen-Button ist auffälliger formatiert 
  * Nochmals der Hinweis, 
    - dass das Forumular per Tab-Taste durchlaufen werden kann 
    - das Speichern jederzeit per Eingabetaste betätigt werden kann 

Klärung: 
   - Spieldauer als Sekunden? 
     - oder Minuten-Angabe mit Komma? (z.B. 5,5 Minuten für 05:30?)

Stand: 04.04.2024 

</pre>
<hr>

<pre>
------------------------
Info zum 29.03.: 
* Suchformular: Funkion "alle Filter zurücksetzen", + Filter "Notenwerte"
  * Korrektur Satz.-Nr (0 oder leer -> 1 )
  * Umstellung Satz > Notenwerte (Bearbeitung, Suche etc.)
     dazu: Neuer Ablauf "Erfassen" - > "Bearbeiten" (wird noch auf andere Seiten auch angewandt, bisher nur Satz > Notenwerte)  
  * Hinweis: Formulare  "Erfassung->Bearbeitung" werden nochmal überarbeitet, ausserdem wird es für Unterformulare es eine Löschfunktion geben 

------------------------
Info zum 26.03. 
  * Info: Erfassung Musikstück / Satz:x 
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

