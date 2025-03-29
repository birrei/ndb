<?php 
$PageTitle='Hilfe zur Erfassung';  
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
    <h3 class="chapter-title chapter-title-h3" id="erfassung_sammlung_kopieren">Sammlung: kopieren</h3>

        <p>Button "Sammlung kopieren": Die Sammlung inklusive  aller Eigenschaften und Untereinheiten 
            wird kopiert. Die Kopie wird im aktuellen Formular geöffnet. Am Zusatz  
            " (Kopie)" im Feld "Name" ist die Kopie erkennbar. 
            Im Seitenkopf erscheint ein Hinweis auf den Kopiervorgang (Neue ID, alte ID mit Link).
            Über den Link kann bei Bedarf die Quelle in neuem Fenster geöffnet werden.  
            
            
        </p>

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


    <h3 class="chapter-title chapter-title-h3" id="erfassung_musikstueck_kopieren">Musikstueck: kopieren</h3>

        <p>Button "Musikstück kopieren": Die Sammlung inklusive  aller Eigenschaften und Untereinheiten 
            wird kopiert. Die Kopie wird im aktuellen Formular geöffnet. Am Zusatz  
            " (Kopie)" im Feld "Name" ist die Kopie erkennbar. 
            Im Seitenkopf erscheint ein Hinweis auf den Kopiervorgang (Neue ID, alte ID mit Link).
            Über den Link kann bei Bedarf die Quelle in neuem Fenster geöffnet werden.  
            
            
        </p>

   
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
        
        <p>Vorgehensweisen:   
        <ul>    
        <li>Button "Hinzufügen": Öffnet das Formular zum Anlegen einer Schüler-Zuordnung</li>
        <li>Button "Schnell-Zuordnung": Hier können mehrere Schüler auf einen Rutsch zugeordnet werden. 
            Markiere alle gewünschten Schüler und klicke auf "Speichern" (unter der Liste).  
            Die Zuordnung erfolgt automatisiert mit dem niedrigsten Status (kleinste ID in der Status-Tabelle).   
        </li>
        </ul>
    
        <p>Verfügbare Felder: 
        <ul>    
            <li>Schüler</li>
            <li>Status XXX</li>
            <li>Datum von</li>
            <li>Datum bis</li>
            <li>Bemerkung</li>
        </ul>
        </p>
        <p>Die erfassten Zuordnungen sind auch über das Formular "Schüler"  (<a href="#erfassung_schueler_noten">Schüler: Verknüpfte Noten</a>) sichtbar. </p>

    <h3 class="chapter-title chapter-title-h3" id="erfassung_satz_kopieren">Satz: kopieren</h3>

        <p>Button "Satz kopieren": Die Sammlung inklusive  aller Eigenschaften und Untereinheiten 
            wird kopiert. Die Kopie wird im aktuellen Formular geöffnet. Am Zusatz  
            " (Kopie)" im Feld "Name" ist die Kopie erkennbar. 
            Im Seitenkopf erscheint ein Hinweis auf den Kopiervorgang (Neue ID, alte ID mit Link).
            Über den Link kann bei Bedarf die Quelle in neuem Fenster geöffnet werden.  
        </p>           
<h2 class="chapter-title chapter-title-h2" id="erfassung_material">Material</h2>
    <p> Materialien können zu einer Sammlung, aber auch unabhängig von einer Sammlung angelegt werden. </p>
    <p> Felder: 
        <ul> 
            <li>Name: XXX </li>
            <li>Materialtyp: XXX </li>
            <li>Bemerkung: XXX </li>
            <li>Sammlung: Das Feld wird  angezeigt, wenn das Material von einer Sammlung aus angelegt wurde. 
                Eine Änderung des Feld-Wertes ist im Material-Formular nicht möglich. 
            </li>
            <li>Schüler: Im Unterformular werden die vorhandenen Verknüpfungen zwischen Material und Schülern angezeigt. 
            Die Bearbeitung sowie das Löschen der Verknüpfungs-Information ist möglich.  
            Eine Verknüpfung zwischen Schüler und Material kann auch im Formular "Schüler" vorgenommen werden, 
            siehe <a href="#erfassung_schueler_material">Schüler: Zuordnung Materialien</a>
            </li>
        </ul>

<h2 class="chapter-title chapter-title-h2" id="erfassung_schueler">Schüler</h2>
      <p>Hinweis: Das Name-Feld sollte - aus Datenschutzgründen - nur den Vornamen enthalten. Die Tabelle 
        ist nicht zum Aufbau einer umfassenden Schüler-Verwaltung gedacht. 
      </p> 

    <h3 class="chapter-title chapter-title-h3" id="erfassung_schueler_schwierigkeitsgrade">Schüler: Instrumente und Schwierigkeitsgrade</h3>
        <p>Optionen: </p>
        <ul>
            <li>Nur Instrument(e): Das Feld Schwierigkeitsgrad kann leer bleiben</li>
            <li>Instrument(e) und Schwierigkeitsgrad(e). Es können mehrere Schwierigkeitsgrade pro Instrument eingetragen werden</li>
        </ul>

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
    <h3 class="chapter-title chapter-title-h3" id="erfassung_schueler_kopieren">Schüler kopieren</h3>
        <p>Schüler wird inklusive Instrumente/Schwierigkeitsgrade sowie aller Material- und Satzverknüpfungen kopiert. 
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

    <h3 class="chapter-title chapter-title-h3" id="erfassung_besonderheiten">Stammdaten: Besonderheiten</h2>

        <p> Besonderheit-Typen können für Sammlungen und Sätze erfasst werden. 
        Eine Besonderheit kann einem übergeordneten Besonderheit-Typ zugeordnet werden
        </p> 
        
               
        <p> Besonderheiten - Felder: 
        <ul> 
            <li>Name </li>
            <li>Typ: Auswahl Besonderheit-Typ </li>

        </ul>
        <p> Besonderheit-Typen - Felder: 
        <ul> 
            <li>Name </li>
            <li>Relation: Daten-Art, welcher die Besonderheiten des Typs zugeordnet werden können. Möglich sind Satz (Voreinstellung) oder Sammlung </li>
            <li>Besonderheiten: Über "hinzufügen" können Besonderheiten für den Typ angelegt werden.  </li>            
            <li>Konfiguration Suche, Type Key: Das Feld wird automatisch befüllt.  
            Der Wert muss eindeutig innerhalb der Tabelle sein.  
            Der Wert kann auch manuell angepasst werden (z.b. weil zwecks Prüfung im HTML-Quelltext einen sprechender Begriff gewünscht wird) 
        </li>
        <li>Konfiguration Suche, Type Key: Anzahl Zeilen: Legt fest, wieviele Zeilen die Suchbox im Suchformular angezeigt werden sollen.  
        </li>
   
        </ul>
         
         


        </p>


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

