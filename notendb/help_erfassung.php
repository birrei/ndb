<?php 
include('head.php');
?>

<h1 id="erfassung">Erfassung</h1>


<ul id="table-of-contents"></ul>


<h3 class="chapter-title chapter-title-h3" id="erfassungsatzspieldauer">Satz: Spieldauer</h3>

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

<h2 class="chapter-title chapter-title-h2" id="erfassungbesonderheiten">Satz: Besonderheiten</h2>

<p> Besonderheiten können für Sammlungen oder Sätze erfasst werden. Jede Besonderheit wird einem Besonderheit-Typ untergeordnet. 
    Der Typ ist für die Erfassung einer Besonderheit am Satz / an der Sammlung nicht zwinged erforderlich -  
    jede Besonderheit hat (über Typen hinweg) eine eigene eindeutige ID. 
</p>

<p>
Wichtig ist die Typ-Zuordnung für die Suche: Auf der <a href="suche.php">Suche-Seite</a> 
wird für jeden Typ eine Mehrfach-Auswahlbox mit den zugeordneten Besonerheiten angezeigt (weiteres dazu im Kapitel <a href="#suche">Suche</a>)  

</p>


<h2 class="chapter-title chapter-title-h2" id="erfassunghinweise">Hinweise aus der  Praxis</h1> 
<p> 
Der Umfang der erfassen Informationen soll sich an den in der Praxis benötigten Informationen 
(die später über die Suche abrufbar sein sollen) orientieren. Beispiel: Die Erfassung einzelner Notenwerte: 
ist nur sinnvoll, wenn diese zu Lehrzwecken gefunden werden sollen (z.B. nur bis Schwierigkeitsgrad 2/3)

</p> 


<script>

    const tableOfContents = document.getElementById("table-of-contents");
    const chapterTitles = document.getElementsByClassName("chapter-title");

    for (const chapterTitle of chapterTitles) {
    const listEntry = document.createElement("li");
    const anchor = document.createElement("a");
    anchor.innerHTML = chapterTitle.innerHTML;  
    level= chapterTitle.tagName.substring(2,1); 
    anchor.href = "#" + chapterTitle.id;
    listEntry.appendChild(anchor);
    // listEntry.style="padding-left: 10px"; 
    tableOfContents.appendChild(listEntry);
    }


</script>

<?php 
include('foot.php');
?>

