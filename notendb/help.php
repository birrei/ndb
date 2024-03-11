<?php 
include('head.php');
?>

<p> !!  Entwürfe !! </p> 

<h2>Erfassung </h2>
<pre>
Gültig für alle (Erst-) Erfassungformulare
(gilt sowohl für Haupt- als auch für Unterformulare)
* Nur Zuorndungen (Auswahl) und Name
* Nach dem Speichern wird das Formular geleert. Die ID des neu angelegten Datensatzes 
* Die Bearbeitung des gerade neu angelegten Datensatzes wird über den "Bearbeiten"-Link fortgesetzt
* Alternativ können im gleichen Formular weitere neue Datensätze angelegt werden. 
    Die neu angelegten Datensätze können dann über die Tabelle (Aufruf über Startseite) aufgefunden und weiter bearbeitet werden. 

</pre>

<h2>Suche</h2> 

<pre>
Für die Auswahl mehrerer Kategorie-Einträge innerhalb einer Auswahlbox 
muss gleichzeitg die STRG-Taste gedrückt sein. 
Suchlogik: 
 * Filtereinträge innerhalb einer Kategorie (innerhalb einer Auswahlbox) werden per ODER verknüpft. 
 * Die Kombination von Kategorien erfolgt über UND-Verknüpfung. 
 
    Beispiel:
    Besetzung: "Violine" ODER "Violine und Klavier" (2 Einträge in Auswahlbox markiert)
        UND 
    Verwendungszweck: "Hochzeit" ODER "Fest"

</pre> 

<?php 
include('foot.php');
?>

