<?php 
include('head.php');
?>

<pre>Entwurf! </pre>

<hr />

<p>Kapitel: </p>
<ul>
    <li><a href="#erfassung">Erfassung</a></li>
    <ul>
        <li><a href="#erfassung_besonderheit">Erfassung Besonderheiten-Typ</a></li>
    </ul>
    <li><a href="#suche">Suche</a><li>
    <li><a href="#info1">Info: Speicherprinzipien</a><li>
</ul>

<hr />

<h1 id="erfassung">Erfassung / Bearbeitung</h1>

<p> <b>Neue Einheit erfassen </b>: Beim erstmaligen anlegen eines Datensatzes werden im 
Formular nur die Haupt-Felder (z.B. Nummer, Name) abgefragt. 
Beim speichern werden diese Felder übernommen 
und eine eindeutige ID erzeugt, es wird zum "Bearbeiten"-Formular weitergeleitet.  
Im Anschluss werden im Dialog "Bearbeiten" ggf. noch noch weitere Eigenschaften erfasst werden. 

<p><b>Erfassung Satz: "Spieldauer": </b>: Der Spieldauer-Wert wird als Sekunden-Wert gespeichert, Das Feld "Minuten" dient als Hilfsmittel. 
Folgende Vorgehensweisen sind alternativ möglich: 
<br>1) Sekunden-Wert direkt eingeben
<br>2) Minutenwert eingeben (Format Zahl oder Format "(minuten):(sekunden)"). Die Minuten-Eingabe wird automatisch in Sekunden umgerechnet. 
</p>

<p id="#erfassung_besonderheit">Erfassung Besonderheiten</p>

<pre> 
Anlegen eigener Kategorien: 
- Startseite: "Besonderheit Typen" > "Neu erfassen"


Kategorie löschen 
- ! noch nicht in der Anwendung möglich, bitte DataClearing beantragen 
- Script: delete_lookup_type.sql 


</pre>




<hr />

<h1 id="suche">Suche</h1> 

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


<hr />

<h1 id="info1"> Formularelemente und Speicherprinzipien </h1>

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





<?php 
include('foot.php');
?>

