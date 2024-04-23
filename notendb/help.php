<?php 
include('head.php');
?>

<pre>Entwurf! </pre>

<h2>Erfassung / Bearbeitung </h2>

<p> Formular "erfassen": Beim erstmaligen anlegen eines Datensatzes werden im 
    Formular nur die Haupt-Felder (z.B. Nummer, Name) abgefragt. Beim speichern werden diese Felder übernommen 
    und eine eindeutige ID gespeichert. Im Anschluss können im Dialog "Bearbeiten" noch (falls vorhanden) 
    noch weitere Eigenschaften erfasst werden. 

<h3>Erfassung Satz: "Spieldauer"</h3>
Mögliche Erfassung: 
<br>1) Sekunden-Wert direkt eingeben 
<br>2) Minutenwert eingeben (Format Zahl oder "(minuten):(sekunden)"), der dann in Sekunden umgerechnet wird. 
<br>In der Datenbank wird der Sekundenwert gespeichert. </i>

<h3> Formularelemente und Speicherprinzipien </h3>

<h4> Unterscheidung und Speicherprinzipien </h4>

<p>Speicherprinzipien: </p>
    <ul> 
        <li>(Text-)Felder</li>
        <li>Zuordnungen (aus Meta-Datentabellen)
            <ul>
                <li>Einfach-Zuordnungen (z.B. Musikstück > Komponist, Musikstück > Epoche) </li>
                <li>Mehrfach-Zordnungen (z.B: Musikstück > Besetzung, Satz > Stricharten)</li>
            </ul>
        </li>
        <li>Untereinheiten  (Sammlung -> Musikstücke bzw. Musikstueck -> Sätze )</li>        
    </ul>

    
<p> Fromularelemente und Speicherprinzipien</p>
<ul> 
    <li>Textfelder</li>
    <li>Auswahlfelder ("Klapplisten"): Einfach-Zuordnungen</li> 
    <li>Unterformulare (iFrames): Mehrfach-Zuordnung, Untereinheiten</li> 
</ul>

<h2>Suche</h2> 

<h3>Auswahlbox mit Mehrfach-auswahl</h3>
<h4>Auswahl mehrerer Kategorie-Einträge</h4>
  <p> bei gedrückter STRG-Taste die gewünschten Einträge mit der Mausw markieren </p> 
<h4>Auswahl mehrerer Kategorie-Einträge untereinander</h4>
  <p> bei gedrückter STRG-Taste + SHIFT-Taste den ersten und den letzten gewünschten Eintrag markieren. </p> 

<h3>Hinweis zur internen Suchlogik</h3>

<p> Filtereinträge innerhalb einer Kategorie (innerhalb einer Auswahlbox) werden per ODER verknüpft. Die Kombination von Kategorien erfolgt über UND-Verknüpfung. </p> 

<p> Beispiel: 
<br />Besetzung: "Violine" ODER "Violine und Klavier" 
<br/> UND 
<br />Verwendungszweck: "Hochzeit" ODER "Fest"


<h3>Textsuche</h3>
<p> Sucht einen Teil-Text innerhalb der einfachen Textfelder, nicht jedoch in Bezeichnungen der Auswahl-Felder. 
Beispiel: Gesucht wird im Feld "Bearbeiter", nicht jedoch im Feld "Komponist" ("Komponist" ist über die Auswahl-Boxen filterbar) 



<?php 
include('foot.php');
?>

