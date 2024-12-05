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

<hr>


<h2 class="chapter-title chapter-title-h2" id="suchlogik0">Suchlogik: Kategorie-Arten</h2>
<ul> 
    <li> Einfach-Auswahl (z.B. Verlag, Komponist). Es kann nur ein Eintrag ausgewählt werden</li> 
    <li> Mehrfach-Auswahl (z.B. Besetzung, Verwendungszweck). Es können ein oder mehrere Einträge ausgewählt werden. 
    </li> 
</ul>

<p> Die Suche orientiert sich an den Erfassungs-Optionen, Beispiel: Das Suchfeld Komponist bietet nur eine Einfach-Auswahl an, da einer Sammlung nur ein Komponist zugeorndet werden kann. </p>

<h2 class="chapter-title chapter-title-h2" id="suchlogik1">Suchlogik: Auswahl mehrerer Kategorien</h2>

<p>Die Kombination mehrere Kategorien (mehrere Auswahl-Felder) erfolgt über UND-Verknüpfung.</p> 

<p> Beispiel: 
    <br />Komponist: "Mozart" 
    <br/> UND     
    <br />Besetzung: "Violine" 
    <br/> UND 
    <br />Verwendungszweck: "Hochzeit" ODER "Fest"
</p> 

<hr>

<h2 class="chapter-title chapter-title-h2" id="suchlogik2">Suchlogik: Auswahl in einer Kategorie, Mehrfachauswahl</h2>

<p>
Mehrfach-Auswahl (z.B. Besetzung, Verwendungszweck). Es können ein oder mehrere Einträge ausgewählt werden.
Bei ausgewählten Kategorien stehen zusätzlich die Optionen  "Einschluss-Suche" und "Ausschluss-Suche" zur Verfügung. 
</p> 



<p> <b>Varianten: </b></p>

<p> <b>Standard (= ohne Zusatzoption)</b>: 
<ul> 
    <li>Bei Auswahl eines Eintrags werden alle Zeilen gesucht, die diese Eigenschaft aufweisen </li> 
    <li>Bei Auswahl mehrerer Einträge werden alle Zeilen gesucht, die <u>mindestens eine dieser Eigenschaften</u> aufweisen.</li>
</ul>
</p>
        
<p> <b>Standard mit Zusatzoption "Einschluss-Suche"</b> 
<ul> 
    <li>Bei Auswahl eines Eintrags werden alle Zeilen gesucht, die diese Eigenschaft aufweisen (Kein Unterschied zu Variante ohne Zusatzoption)</li> 
    <li>Bei Auswahl mehrerer Einträge werden alle Zeilen gesucht, die <u>alle ausgewählten Eigenschaften</u> aufweisen.</li> 
</ul>
</p>

<p><b>Standard mit Zusatzoption "Ausschluss-Suche" </b>
<ul> 
    <li>Bei Auswahl eines Eintrags werden alle Zeilen gesucht, die nur diese Eigenschaft aufweisen</li> 
    <li>Bei Auswahl mehrerer Einträge werden alle Zeilen gesucht, die <u>mind. eine der ausgewählten Eigenschaften, jedoch keine weitere Eigenschaften aus der Kategorie</u> aufweisen </li> 
</ul>
</p>

<p><b>Standard mit Zusatzoptionen "Einschluss-Suche" und "Ausschluss-Suche" </b>
<ul> 
    <li>Bei Auswahl eines Eintrags werden alle Zeilen gesucht, die nur diese Eigenschaft aufweisen</li> 
    <li>Bei Auswahl mehrerer Einträge werden alle Zeilen gesucht, die <u>nur die ausgewählten Eigenschaften </u>aufweisen </li> 
</ul>
</p>

<p> <b>Beispiele (Praxisfall: "Satz Besonderheiten" > "Übung Notenwerte"): </b></p>

<p> Suche nach einer Eigenschaft (Hier: Notenwert "Achtel"): 

    <ul> 
        <li>    Finde Sätze, bei denen der Notenwert "Achtel" vorkommt: Standard-Suche, ohne Zusatz-Option bzw. mit Zusatzoption "Einschluss-Suche" (kein Unterschied)
                    </li> 
        <li>    Finde Sätze, bei denen NUR Notenwert "Achtel" vorkommt: Standard-Suche mit Option "Ausschluss-Suche"
        </li> 
    </ul>



</p>

<p> Suche nach mehreren Eigenschaften (hier: Notenwerte "Achtel" und "Viertel"): 

<ul> 
        <li>    Finde Sätze, bei denen Notenwerte "Achtel" ODER "Viertel" vorkommmen: Standard-Suche
        </li> 
        <li>    Finde Sätze, bei denen Notenwerte "Achtel" UND "Viertel" vorkommmen: Standard-Suche mit Option "Einschluss-Suche"    
        </li> 
        <li>    Finde Sätze, bei denen NUR Notenwerte "Achtel" ODER "Viertel" vorkommmen: Standard-Suche mit Option "Ausschluss-Suche"
        </li> 
        <li>    Finde Sätze, bei denen NUR Notenwerte "Achtel" UND "Viertel" vorkommmen: Standard-Suche mit Optionen "Einschluss-Suche" und "Ausschluss-Suche"
        </li>         
    </ul>

    </p>

    <p>Merker: "Einschluss-Suche" -> "UND", "Ausschluss-Suche" -> "NUR" 

    <hr>


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

