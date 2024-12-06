<?php 
include('head.php');
?>

<div class="body-doc"> 

<h1 id="erfassung">Erfassung</h1>

<p class="doc"><b>Kapitel:</b></p>

<!-- Inhaltsverzeichnis wird uber Javascript befüllt, s. Script-Teil Seite unten  --> 
<ul id="table-of-contents"></ul>

<h2 class="chapter-title chapter-title-h3" id="erfassung_sammlung">Sammlung</h2>  
<h3 class="chapter-title chapter-title-h3" id="erfassung_sammlung_nummer">Sammlung: Nummer</h3>
    <p>Enthält ein ganzzahligen Wert, der die Reihenfolge der Musikstück innerhalb der Sammlung abbildet. Der Wert wird bei neu anlegen eines Musikstücks automatisch hochgezählt. Er kann bei der Bearbeitung manuell angepasst werden. 

<h3 class="chapter-title chapter-title-h3" id="erfassung_sammlung_name">Sammlung: Name</h3>
    <p> Name XXX </p>
<h3 class="chapter-title chapter-title-h3" id="erfassung_sammlung_standort">Sammlung: Standort</h3>    
<h3 class="chapter-title chapter-title-h3" id="erfassung_sammlung_verlag">Sammlung: Verlag</h3>    
<h3 class="chapter-title chapter-title-h3" id="erfassung_sammlung_verwendungszweck">Sammlung: Verwendungszwecke</h3>    
<h3 class="chapter-title chapter-title-h3" id="erfassung_sammlung_besonderheiten">Sammlung: Besonderheiten</h3>    
<h3 class="chapter-title chapter-title-h3" id="erfassung_sammlung_links">Sammlung: Links</h3>    
<h3 class="chapter-title chapter-title-h3" id="erfassung_sammlung_bemerkung">Sammlung: Bemerkung</h3>    
<h3 class="chapter-title chapter-title-h3" id="erfassung_sammlung_erfasst">Sammlung: Erfasst</h3>

    <p>Das Feld kann aktiviert werden, wenn die Erfassung der Sammlung (inklusive Musistücke/Sätze) komplett abgeschlossen ist. 
        
    <p> Hinweis: Die Datenprüfungen unter <a href="tests.php?title=Tests">Tests</a> enthalten nur Abfragen auf vollständig erfasste Sammlungen. </p>

<h3 class="chapter-title chapter-title-h3" id="erfassung_musikstueck_besetzung">Musikstück: Besetzung</h3>

    <p> Eine Besetzung mit mehreren Instrumenten kann sowohl als Ensemble-Eintrag als über mehrere einzelnem Instrument-Einträgen zugeordnet werden. </p>

    <p>Empfehlung: Ordne für eine feste Besetzung (bei der keines der Instrument weggelassen werden kann) einen Ensemble-Eintrag zu, da dieser später bei der Suche (XXX Verweis auf Suche-Kapitel... ) einfacher ausgewählt werden kann. Die Zuordnung mehrerer einzelner Instrumenten ist z.B. bei Sammelheften mit gleichen Stücken bei variabler Instrumenten-Beteiligung sinnvoll. 
   

<h3 class="chapter-title chapter-title-h3" id="erfassung_satz_spieldauer">Satz: Spieldauer</h3>

    <p>Der Spieldauer-Wert wird als Sekunden-Wert gespeichert und kann im Sekunden-Feld direkt eingegeben werden.</p>

    <p>Bei Bedarf kann der Wert auch in Minuten eingegeben werden. Bei Eingabe der Minuten-Angabe dieser wird diese automatisch in Sekunden umgerechnet. Folgende Eingaben im Minuten-Feld sind alternativ möglich: 
    </p> 

    <ul>    
        <li> Ganzzahl (z.B: 5 für 5 Minuten)</li>
        <li>
            Zeit-Format "mm:ss" (z.B: 01:30 bzw. 1:30 für 1 Minute und 30 Sekunden)
        </li>
    </ul>
    <p> Hinweis: Eingaben > 60 min sind (noch) nicht möglich XXX </p>
<h3 class="chapter-title chapter-title-h3" id="erfassung_satz_besonderheiten">Satz: Besonderheiten</h3>

    <p> Besonderheiten können für Sammlungen oder Sätze erfasst werden. Jede Besonderheit wird einem Besonderheit-Typ untergeordnet. Der Typ ist für die Erfassung einer Besonderheit am Satz / an der Sammlung nicht zwinged erforderlich -  jede Besonderheit hat (über Typen hinweg) eine eigene eindeutige ID. 
    </p>

<h3 class="chapter-title chapter-title-h3" id="erfassung_besetzung">Stammdaten: Besetzung</h3>

    <p> Als Besetzung können sowohl Ensembles als auch Einzelinstrumente hinterlegt werden. 

    <p> Beispiele für Besetzungen:  </p>
    <ul>    
        <li>Violine und Klavier</li>
        <li>Violine </li>
        <li>Klavier </li>    
        <li>Orchester</li>  
        <li>Klaviertrio (Violine, Violoncello und Klavier)</li>         
        <li>Violoncello</li>
    </ul>

    <p>Die Zuordnung einer Besetzung wird <a href="#erfassung_musikstueck_besetzung">auf Musikstück-Ebene vorgenommen</a></p>


<hr>


XXX 

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

