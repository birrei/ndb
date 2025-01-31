<?php 
include('head.php');
?>

<div class="body-doc"> 

<p> Entwurf! </p>

<h1 id="erfassung">Erfassung</h1>

<p class="doc"><b>Kapitel:</b> </p>

<ul id="table-of-contents"></ul> <!-- Inhaltsverzeichnis wird per Javascript befüllt, s. Script-Teil Seite ganz unten  --> 

<hr>

<h2 class="chapter-title chapter-title-h2" id="erfassung_sammlung">Sammlung</h2>  
    <!-- <h3 class="chapter-title chapter-title-h3" id="erfassung_sammlung_name">Sammlung: Name</h3> -->
    <!-- <h3 class="chapter-title chapter-title-h3" id="erfassung_sammlung_standort">Sammlung: Standort</h3>     -->
    <!-- <h3 class="chapter-title chapter-title-h3" id="erfassung_sammlung_verlag">Sammlung: Verlag</h3>     -->
    <!-- <h3 class="chapter-title chapter-title-h3" id="erfassung_sammlung_besonderheiten">Sammlung: Besonderheiten</h3>     -->
    <!-- <h3 class="chapter-title chapter-title-h3" id="erfassung_sammlung_links">Sammlung: Links</h3>     -->
    <!-- <h3 class="chapter-title chapter-title-h3" id="erfassung_sammlung_bemerkung">Sammlung: Bemerkung</h3>     -->
    <h3 class="chapter-title chapter-title-h3" id="erfassung_sammlung_erfasst">Sammlung: (vollständig) Erfasst</h3>

        <p>Das Feld kann aktiviert werden, wenn die Erfassung der Sammlung (inklusive Musistücke/Sätze) komplett abgeschlossen ist. 
            
        <p> Hinweis: Die Datenprüfungen unter <a href="tests.php?title=Tests">Tests</a> enthalten nur Abfragen auf vollständig erfasste Sammlungen. </p>
        .... 

<h2 class="chapter-title chapter-title-h2" id="erfassung_musikstueck">Musikstück</h2>
    <h3 class="chapter-title chapter-title-h3" id="erfassung_musikstueck_nummer">Musikstück: Nummer</h3>
        <p>Enthält ein ganzzahligen Wert, der die Reihenfolge der Musikstück innerhalb der Sammlung abbildet. 
            Der Wert wird bei Neuanlage eines Musikstücks automatisch vergeben (hochgezählt), kann danach aber manuell angepasst werden.
            Es können nur ganzzahlige Werte verwendet werden (nicht möglich sind z.B: 1.1 oder 1b etc) 
    
    <h3 class="chapter-title chapter-title-h3" id="erfassung_musikstueck_besetzung">Musikstück: Besetzung(en)</h3>

        <p>Die Einträge für die Zuordnung stammen aus der Stammdaten-Tabelle <a href="#erfassung_stammdaten_besetzung">"Besetzung"</a> 
        
        </p>
        
        <p>Für feste Besetzungen (z.B. Violine, Viola und Klavier = "Klaviertrio"), bei der keines der Instrument weggelassen werden kann, 
            sollte als ein Ensemble-Eintrag vorgenommen werden. Die Erfassung von Einzelinstrumenten ist nur 
            dann sinnvoll, wenn die Instrumente bei einem Musikstück variieren können  
            - z.B. wenn ein Sammelhelft mit gleichen 
            Musikstücken für verschiedene Instrumenten besetzt werden kann (kommt z.B. bei Lehr-Werken vor)
        </p>

        <p>
            Die Art der Zuordnung wirkt auf das Vorgehen bei der Suche aus (XXX Verweis hier später einfügen) 
        </p>
        <p>XXX </p>



   
    <!-- <h3 class="chapter-title chapter-title-h3" id="erfassung_musikstueck_verwendungszweck">Musikstück: Verwendungszwecke</h3>    -->


<h2 class="chapter-title chapter-title-h2" id="erfassung_musikstueck">Satz</h2>
    <p class="draft"> 
        Entwurf  XXX: 
        1 Satz muss nicht zwingend ein Satz im Wortsinn sein, es ist einfach Teil eines Musikstück.  
        Sätze können Teile eines Musikstücks sein, die sich in den im Satz erfassten Eigenschaften 
        unterscheiden. ... Ein einzelner Satz-Datensatz ist die Fortsetzung der Musikstück-Information der mit dem Musistück "verschmilzt".
        ... XXX Erklärung zu Abschnitten 
        </p>

    <h3 class="chapter-title chapter-title-h3" id="erfassung_satz_spieldauer">Satz: Spieldauer</h3>
        <p>
            Im Formular werden die Felder "Minuten" und "Sekunden" anzeigt. 
            Gespeichert wird nur der Sekundenwert - das Feld "Minuten" dient als Hilfsfeld, 
            welches das Umrechnen größerer Werte erspart.   
        </p>
        <p>Zur Eingabe im Hilfsfeld "Minuten": 
            Der Eingabewert wird bei Eingabe simultan in Sekunden umgerechnet und im Sekundenfeld angezeigt. 
            Folgende Eingaben im Minuten-Feld sind alternativ möglich: 
            <br>1) Ganzzahl (z.B: 5 für 5 Minuten, 90 für 90 Minuten)
            <br>2) Zeit-Format "mm:ss" (z.B: 01:30 bzw. 1:30 für 1 Minute und 30 Sekunden). 
            Eingaben bis 59:59 sind möglich, für größere Zeitangaben müssen Ganzzahlangaben (s.1) verwendet werden. 

        </p> 

    <h3 class="chapter-title chapter-title-h3" id="erfassung_satz_besonderheiten">Satz: Besonderheiten</h3>
        <p> Besonderheiten können für Sammlungen oder Sätze erfasst werden. Jede Besonderheit wird einem Besonderheit-Typ untergeordnet. Der Typ ist für die Erfassung einer Besonderheit am Satz / an der Sammlung nicht zwinged erforderlich -  jede Besonderheit hat (über Typen hinweg) eine eigene eindeutige ID. 
        </p>

    <h3 class="chapter-title chapter-title-h3" id="erfassung_satz_schueler">Satz: Zuordnung Schüler</h3>
        <p>
            Verfügbare Felder: 
        <ul>    
            <li>Schüler</li>
            <li>Bemerkung (hier können Anmerkungen/Notizen zur Verknüpfung abgelegt werden, 
                z.B. zum Grund der Auswahl dieser Noten für den Schüler</li>
        </ul>
        </p>
        <p>Die erfassten Zuordnungen sind auch über das Formular "Schüler"  (<a href="#erfassung_schueler_noten">Schüler: Verknüpfte Noten</a>) sichtbar. </p>

           
<h2 class="chapter-title chapter-title-h2" id="erfassung_material">Material</h2>
    <h3 class="chapter-title chapter-title-h3" id="erfassung_material_schueler">Material: Zuordnung Schüler</h3>
        <p>Im Unterformular werden die vorhandenen Verknüpfungen zwischen Material und Schülern angezeigt. 
            Die Bearbeitung sowie das Löschen der Verknüpfungs-Information ist möglich.  
        </p>
        <p> Eine Verknüpfung zwischen Schüler und Material kann auch im Formular "Schüler" vorgenommen werden, 
            siehe <a href="#erfassung_schueler_material">Schüler: Zuordnung Materialien</a>. 
        </p>

<h2 class="chapter-title chapter-title-h2" id="erfassung_schueler">Schüler</h2>
    <h3 class="chapter-title chapter-title-h3" id="erfassung_schueler_schwierigkeitsgrade">Schüler: Instrumente und Schwierigkeitsgrade</h3>

        <p>Die Schwierigkeitsgrade sollen darüber informieren, welche Instrumente der Schüler spielt und 
            innerhalb welcher Schwierigkeitsgrade das Unterichtsmaterial für diesen Schüler liegen sollte.
        </p>  

        <p> Hinweis: Die auswählbaren Einträge folgen der gleichen Systematik, 
            die auch für die Satz- Schwierigkeitsgrade hinterlegt sind. 
            Für einen Schüler können (und sollten auch) mehrere Schwierigkeitsgrade pro Instrument eingetragen werden 
            (im Gegensatz zum Satz, bei dem  pro Instrument eine eindeutige Entscheidung getroffen wird).
            Durch den Eintrag mehrerer Schwierigkeitsgrade wird ein Schwierigkeitsgrad- "Bandbreite" angegeben.  
            So kann z.B. für einen Klavierschüler durch folgende drei Einträge eine Schwierigkeitsgrad-Bandbreite von 1 bis 2 angegeben werden. 
            <br> Klavier 1
            <br> Klavier 1/2
            <br> Klavier 2 
        </p>


    <h3 class="chapter-title chapter-title-h3" id="erfassung_schueler_noten">Schüler: Verknüpfte Noten</h3>
        <p> Es werden Noten (Sammlungen/Musikstücke/Sätze) angezeigt, 
            die dem Schüler (über die <a href="#erfassung_satz_schueler">Satz-Erfassung</a>) zugeordnet wurden. </p>
        <p>Im Unterformular werden die vorhandenen Verknüpfungen angezeigt. 
            Die Bearbeitung der Information im Feld "Bemerkung" ist möglich.  
            Das hinzufügen neuer Musikstücke (Sätze) ist in diesem Formular nicht möglich, 
            die Zuordnung muss über die <a href="#erfassung_satz_schueler">Satz-Erfassung</a> erfolgen. 
        </p>
    <h3 class="chapter-title chapter-title-h3" id="erfassung_schueler_material">Schüler: Zuordnung Materialien</h3>
        <p>Im Unterformular werden die vorhandenen Verknüpfungen zwischen Schüler und Materialien angezeigt. 
            Die Bearbeitung sowie das Löschen der Verknüpfungs-Information ist möglich.  
        </p>
        <p> Eine Verknüpfung zwischen Schüler und Material kann auch im Formular "Material" vorgenommen werden, 
            siehe <a href="#erfassung_material_schueler">Material: Zuordnung Schüler</a>. 
        </p>

<h2 class="chapter-title chapter-title-h2" id="erfassung_stammdaten">Stammdaten</h2>
    <h3 class="chapter-title chapter-title-h3" id="erfassung_stammdaten_besetzung">Stammdaten: Besetzung</h3>

        <p> Unter Besetzungen können sowohl Ensembles als auch Einzelinstrumente (auch parallel) hinterlegt werden. 
        Die Zuordnung einer Besetzung wird <a href="#erfassung_musikstueck_besetzung">auf 
        Musikstück-Ebene vorgenommen</a> (weitere Hinweise zur Verwendung siehe dort). 

        <p> Die Einträge in der Besetzungen-Tabelle richten sich nach dem Strukturierungs-Bedarf des Anwenders, 
            es gibt keine Vorgaben. Beispiele für Besetzungen:  </p>
        <ul>    
            <li>Violine und Klavier</li>
            <li>Violine </li>
            <li>Klavier </li>    
            <li>Orchester</li>  
            <li>Klaviertrio (Violine, Violoncello und Klavier)</li>         
            <li>Violoncello</li>
        </ul>


<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

<hr>




<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>










</div> 

<!-- 
automat. Generierung Inhaltsverzeichnis 
Voraussetzung ist ein <ul> Element mit der id="table-of-contents" im Seitenkopf 

PS: bisher nur in flacher Hierarchie, Verbesserung geplant ... XXX 

 --> 
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

