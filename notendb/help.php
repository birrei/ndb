<?php 
include('head.php');
?>

<div class="hilfeseite"> 

<p><b>Inhalt</b></p>

<p class="inhalt1"><a href="#erfassung"><b>Erfassung</b></a></p>

<p class="inhalt2"><a href="#erfassungsatz">Satz</a></p>
<p class="inhalt3"><a href="#erfassungsatzspieldauer">Satz Spieldauer</a></p>

<p class="inhalt2"><a href="#erfassungbesonderheiten">Besonderheiten</a></p>

<p class="inhalt1"><a href="#suche"><b>Suche</b></a></p>
<p class="inhalt2"><a href="#suchemehrfachauswahl1">Mehrfachauswahl: Einträge markieren</a></p>
<p class="inhalt2"><a href="#suchemehrfachauswahl2">Mehrfachauswahl: Suchlogik</a></p>



<hr />

<h1 id="erfassung">Erfassung</h1>

<h2 id="erfassungsatz">Satz</h2>

<!-- Falls es nur einen Satz gibt, ist der Satz die Fortsetzung des Musikstücks.  -->

<h3 id="erfassungsatzspieldauer">Satz Spieldauer</h3>

<p>Der Spieldauer-Wert wird als Sekunden-Wert gespeichert und kann im Sekunden-Feld direkt eingegeben werden. 
Bei Bedarf kann der Wert in Minuten eingegeben werden, dieser wird automatisch in Sekunden umgerechnet. 
Folgende Eingaben im Minuten-Feld sind alternativ möglich: 
</p> 

<ul>    
    <li> Ganzzahl (z.B: 5 für 5 Minuten)</li>
    <li>
        Zeit-Format "mm:ss" (z.B: 01:30 bzw. 1:30 für 1 Minute und 30 Sekunden)
    </li>
</ul>

<h2 id="erfassungbesonderheiten">Besonderheiten</h2>

<p> Besonderheiten können für Sammlungen oder Sätze erfasst werden. Jede Besonderheit wird einem Besonderheit-Typ untergeordnet. 
    Der Typ ist für die Erfassung einer Besonderheit am Satz / an der Sammlung nicht zwinged erforderlich -  
    jede Besonderheit hat (über Typen hinweg) eine eigene eindeutige ID. 
    
</p>

<p>
Wichtig ist die Typ-Zuordnung für die Suche: Auf der <a href="suche.php">Suche-Seite</a> 
wird für jeden Typ eine Mehrfach-Auswahlbox mit den zugeordneten Besonerheiten angezeigt (weiteres dazu im Kapitel <a href="#suche">Suche</a>)  

</p>




<hr />

<h1 id="suche">Suche</h1> 

<h2 id="suchemehrfachauswahl1">Mehrfachauswahl: Einträge markieren</h2>

<p>Markierung Optionen:</p>

<ul>
    <li>Markierung eines Eintrags</li>
    <li>Markierung mehrere Einträge bei gedrückter STRG-Taste oder (falls die gewünschten Einträge untereinander liegen) bei gedrückter SHIFT - Taste 
    </li>

</ul>

<h2 id="suchemehrfachauswahl2">Mehrfachauswahl: Suchlogik</h2>

<p><b>Standard-Suche</b></p>

<p> Filtereinträge innerhalb einer Kategorie (innerhalb einer Auswahlbox) werden per ODER verknüpft. 
        Die Kombination von Kategorien (Auswahlboxen) erfolgt über UND-Verknüpfung. </p> 
    <p> Beispiel: 
    <br />Besetzung: "Violine" ODER "Violine und Klavier" 
    <br/> UND 
    <br />Verwendungszweck: "Hochzeit" ODER "Fest"
</p> 

<p><b>Zusatzoption: Genaue Suche</b></p>

<p> Bei einigen Auswahl-Boxen steht die Option "Genaue Suche" (Checkbox unter Auswahlkasten) zur Verfügung </p> 

<p> Beispiele zur Unterschiedung der Logik ohne / mit genauer Suche: 
    
<p> (Im Beispiel: Auswahlbox "Besonderheiten" > "Übung Notenwerte") </p> 

<p>Beispiel 1: Suche nach Notenwert "Achtel": </p>

<ul> 
    <li> 
    Die Standard-Suche findet alle Sätze, bei denen u.a. Notenwert "Achtel" - ggf. zusammen mit anderen Notenwerten - vorkommt 
     </li> 
<li>
    Die Genaue Suche findet alle Sätze, bei denen nur ein Notenwert, und zwar "Achtel" vorkommt. 
    Sätze, bei denen weitere Notenwerte vorkommen, werden ausgeschlossen.    
</li> 
</ul>

<p>Beispiel 2: "Suche nach Notenwerten "Achtel" und "Sechzentel"</p>

<ul>
    <li>
        Die Standard-Suche findet alle Sätze, bei denen u.a. "Achtel" oder "Viertel" vorkommen. 
    </li>
    <li>
        Die Genaue Suche findet Sätze, bei denen nur "Achtel" und "Sechzehntel" vorkommen. 
        Sätze, bei denen nur einer der beiden beiden Notenwerte oder weitere Notenwerte vorkommen, werden ausgeschossen. 
    </li>
</ul>

<h2 id="suchetext">Textsuche</h2>
<p> Sucht einen Textteil innerhalb aller Text-Felder.  


</div>

<?php 
include('foot.php');
?>

