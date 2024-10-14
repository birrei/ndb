<?php 
include('head.php');
?>

<h1>Suche</h1> 

<ul id="table-of-contents"></ul>

<h2 class="chapter-title chapter-title-h2" id="suchemehrfachauswahl1">Mehrfachauswahl: Einträge markieren</h2>

<p>Markierung Optionen:</p>
<ul>
    <li>Markierung eines Eintrags</li>
    <li>Markierung mehrere Einträge bei gedrückter STRG-Taste oder (falls die gewünschten Einträge untereinander liegen) bei gedrückter SHIFT - Taste 
    </li>
</ul>

<h2 class="chapter-title chapter-title-h2" id="suchemehrfachauswahl2">Mehrfachauswahl: Suchlogik</h2>
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
<p> (Im aktullen Beispiel: Auswahlbox "Übung Notenwerte") </p> 
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


<h2 class="chapter-title chapter-title-h2" id="suche-ansicht">Ergebnistabelle: Ansicht, Gruppierung, Sortierung</h2>

<ul> 
    <li>
        <b> Ansicht "Sammlung":</b> Ergebnistabelle wird auf Sammlung-Ebene gruppiert (Eine Zeile pro Sammlung)
        <br />Die Sortierung erfolgt nach Standort Name, Sammlung Name
     </li> 
     <li>
     <b> Ansicht "Sammlung mit Links":</b> Ergebnistabelle wird auf Sammlung-/Link Ebene gruppiert (Eine Zeile pro Sammlung und Link) 
        <br />Die Sortierung erfolgt nach Standort Name, Sammlung Name
     </li>      
     <li>
     <b> Ansicht "Musikstück":</b> Ergebnistabelle wird auf Musikstück-Ebene gruppiert gruppiert (Eine Zeile pro Musikstück)  
        <br />Die Sortierung erfolgt nach Standort Name, Sammlung Name, Musikstück Name         
     </li> 
     <li>
        <b> Ansicht "Satz":  wird auf Satz-Ebene gruppiert   (Eine Zeile pro Musikstück)
        <br />Die Sortierung erfolgt nach Standort Name, Sammlung Name, Musikstück Name, Satz Name            
     </li> 
</ul>

<h2 class="chapter-title chapter-title-h2" id="suchetext">Textsuche</h2>
<p> Hinweis: Die Verwendung der Textsuche kann zu einer verzögerten Ergebnisanzeige führen! </p>
<p> Sucht einen Textteil innerhalb aller Text-Felder. </p>
<p> Folgende Felder werden durchsucht: XXX </p>
<p> Folgende Felder werden nicht durchsucht. XXX </p>     

<script>
    const tableOfContents = document.getElementById("table-of-contents");
    const chapterTitles = document.getElementsByClassName("chapter-title");
    for (const chapterTitle of chapterTitles) {
        const listEntry = document.createElement("li");
        const anchor = document.createElement("a");
        anchor.innerHTML = chapterTitle.innerHTML;  
        // level= chapterTitle.tagName.substring(2,1); 
        anchor.href = "#" + chapterTitle.id;
        listEntry.appendChild(anchor);
        // listEntry.style="padding-left: 10px"; 
    tableOfContents.appendChild(listEntry);
    }
</script>

<?php 
include('foot.php');
?>

