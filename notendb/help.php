<?php 
include('head.php');
?>

<p>Inhalt</p>
<p class="inhalt1"><a href="#erfassung">Erfassung</a></p>
<p class="inhalt2"><a href="#erfassungsammlung">Sammlung erfassen</a></p>
<p class="inhalt2"><a href="#erfassungmusikstueck">Musikstück erfassen</a></p>
<p class="inhalt2"><a href="#erfassungsatz">Satz erfassen</a></p>


<hr />

<h1 id="erfassung">Erfassung</h1>
<h2 id="erfassungsammmlung">Sammlung erfassen</h2>
<p> .... </p> 

<h2 id="erfassungmusikstueck">Musikstück erfassen</h2>
<p> .... </p> 

<h2 id="erfassungsatz">Satz erfassen</h2>

Falls es nur einen Satz gibt, ist der Satz die Fortsetzung des Musikstücks. 


<p><b>"Spieldauer": </b>: Der Spieldauer-Wert wird als Sekunden-Wert gespeichert, Das Feld "Minuten" dient als Hilfsmittel. 
Folgende Vorgehensweisen sind alternativ möglich: 
<br>1) Sekunden-Wert direkt eingeben
<br>2) Minutenwert eingeben (Format Zahl oder Format "(minuten):(sekunden)"). Die Minuten-Eingabe wird automatisch in Sekunden umgerechnet. 
</p>




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







<?php 
include('foot.php');
?>

