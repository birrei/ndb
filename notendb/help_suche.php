<?php 
include('head.php');
?>

<div class="body-doc"> 

<h1>Suche</h1> 

<p><b>Kapitel:</b></p>

<ul class="doc" id="table-of-contents"></ul>

<h2 class="chapter-title chapter-title-h2" id="suche-ansicht">Auswahl Ansicht</h2>

<ul> 
    <li>
        <b> Ansicht "Sammlung":</b> Die Ergebnistabelle wird auf Sammlung-Ebene gruppiert (Eine Zeile pro Sammlung).
        Die Sortierung erfolgt nach Standort Name, Sammlung Name
     </li> 
     <li>
     <b> Ansicht "Sammlung mit Links":</b> Die  Ergebnistabelle wird auf Sammlung-/Link Ebene gruppiert (Eine Zeile pro Sammlung und Link).
        Die Sortierung erfolgt nach Standort Name, Sammlung Name
     </li>      
     <li>
     <b> Ansicht "Musikstück":</b> Die  Ergebnistabelle wird auf Musikstück-Ebene gruppiert gruppiert (Eine Zeile pro Musikstück).
        Die Sortierung erfolgt nach Standort Name, Sammlung Name, Musikstück Name         
     </li> 
     <li>
        <b> Ansicht "Satz":</b> Die Ergebnistabelle  wird auf Satz-Ebene gruppiert (Eine Zeile pro Satz). 
        Die Sortierung erfolgt nach Standort Name, Sammlung Name, Musikstück Name, Satz Name            
     </li> 
     <li>
        <b> Ansicht "Satz Besonderheiten":</b> Die Ergebnistabelle wird auf Satz-Ebene gruppiert (Eine Zeile pro Satz)
        Es werden nur ausgewählte Spalten angezeigt, der Fokus bei dieser Ansicht ist die Spalte "Besonderheiten" - Diese wird als erste Spalte angezeigt
        Die Ausgabe des Inhaltes in "Besonderheiten" erfolgt gruppiert mit Zeilenumbrüchen. 
        Die Sortierung erfolgt nach Standort Name, Sammlung Name, Musikstück Name, Satz Name            
     </li>     
</ul>

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

<p><b>Zusatzoptionen: "Genaue Suche" und "Ausschluss-Suche"</b></p>
<p> Bei einigen Auswahl-Boxen stehen die Optionen  "Genaue Suche" und "Ausschluss-Suche" (Checkboxen) zur Verfügung. 
    Die "Ausschluss-Suche" kann ergänzend zur "Genauen Suche" aktiviert werden, allein ausgewählt ist sie wirkungslos.</p> 
    
<p> Nachfolgend werden zwei Beispiele (Praxisfall: "Übung Notenwerte") zur Wirkung der Suchlogik aufgeführt. </p>

<p>Beispiel 1: Suche nach einem Notenwert, z.B. "Achtel": </p>
<ul> 
    <li> 
    Die Standard-Suche (ohne aktivierte Zusatz-Optionen) findet alle Sätze, 
    bei denen Notenwert "Achtel" vorkommt (unabhängig davon, ob noch weitere Notenwerte vorkommen)
     </li> 

     <li>
     Die "Genaue Suche" ohne "Ausschluss-Suche": Bei nur einem Wert (wie wie hier "Achtel") hat das die die gleiche Wirkung 
    wie die Standardsuche. 
    </li> 

    <li>
    Die "Genaue Suche" mit Option "Ausschluss-Suche" findet alle Sätze, 
    bei denen nur ein Notenwert, und zwar "Achtel" vorkommt. 
    Sätze, bei denen weitere Notenwerte vorkommen, werden ausgeschlossen.    
    </li> 
</ul>

<p>Beispiel 2: "Suche nach Notenwerten "Achtel" und "Sechzentel"</p>
<ul>
    <li>
        Die Standard-Suche (ohne aktivierte Zusatz-Optionen) findet alle Sätze, 
        bei denen "Achtel" ODER "Viertel" vorkommen (unabhängig davon, ob noch weitere Notenwerte vorkommen)
    </li>

    <li>
    Die "Genaue Suche" ohne Option "Ausschluss-Suche" findet Sätze, bei denen "Achtel" UND "Sechzehntel" vorkommen 
    (unabhängig davon, ob noch weitere Notenwerte vorkommen)
    </li> 

    <li>
    Die "Genaue Suche" mit Option "Ausschluss-Suche" findet Sätze, bei denen "Achtel" UND "Sechzehntel", 
    sowie keine weiteren Notenwerte vorkommen. 

    </li> 

</ul>



<h2 class="chapter-title chapter-title-h2" id="suchetext">Textsuche</h2>
<p> Hinweis: Die Verwendung der Textsuche kann zu einer verzögerten Ergebnisanzeige führen! </p>
<p> Sucht einen Textteil innerhalb aller Text-Felder. </p>
<p> Folgende Felder werden durchsucht: XXX </p>
<p> Folgende Felder werden nicht durchsucht. XXX </p>     

</div>

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

