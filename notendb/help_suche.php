<?php
$PageTitle='Hilfe zur Suche';  
include('head.php');
?>

<div class="body-doc"> 

<h1>Suche</h1> 

<p><b>Kapitel:</b></p>

<!-- Inhaltsverzeichnis wird uber Javascript befüllt, s. Script-Teil Seite unten  --> 
<ul class="doc" id="table-of-contents"></ul>
<hr>

<h1 class="chapter-title chapter-title-h1" id="suche-noten">NOTEN-SUCHE</h1>

<h2 class="chapter-title chapter-title-h2" id="suche-ansicht">Auswahl Ansicht</h2>
    <h3 class="chapter-title chapter-title-h3" id="suche-ansicht-sammlung">Auswahl Ansicht: Sammlung</h3>
        <p>  Die Ergebnistabelle wird auf Sammlung-Ebene gruppiert (Eine Zeile pro Sammlung).
        Die Sortierung erfolgt nach Standort Name, Sammlung Name</p>

    <h3 class="chapter-title chapter-title-h3" id="suche-ansicht-sammlung-links">Auswahl Ansicht: Sammlung mit Links</h3>
        <p> Die  Ergebnistabelle wird auf Sammlung-/Link Ebene gruppiert (Eine Zeile pro Sammlung und Link).
             Die Sortierung erfolgt nach Standort Name, Sammlung Name</p>
        
    <h3 class="chapter-title chapter-title-h3" id="suche-ansicht-musickstueck">Auswahl Ansicht: Musikstück</h3>
        <p> Die  Ergebnistabelle wird auf Musikstück-Ebene gruppiert gruppiert (Eine Zeile pro Musikstück).
        Die Sortierung erfolgt nach Standort Name, Sammlung Name, Musikstück Name </p>
            
        <p>  Hinweis: In "Musikstück"-Ansichten werden nur solche Sammlungen angezeigt, denen Musikstücke zugeordnet sind. </p>
   

    <h3 class="chapter-title chapter-title-h3" id="suche-ansicht-satz">Auswahl Ansicht: Satz</h3>
        <p> Die Ergebnistabelle  wird auf Satz-Ebene gruppiert (Eine Zeile pro Satz). 
        Die Sortierung erfolgt nach Standort Name, Sammlung Name, Musikstück Name, Satz Name        </p>

        <p> In "Satz"-Ansichten werden nur Sammlungen / Musikstücke angezeigt, denen Sätze zugeordnet sind. </p> 

    <h3 class="chapter-title chapter-title-h3" id="suche-ansicht-satz-besonderheiten">Auswahl Ansicht: Satz Besonderheiten</h3>
         <p>  Die Ergebnistabelle wird auf Satz-Ebene gruppiert (Eine Zeile pro Satz)
            Es werden nur ausgewählte Spalten angezeigt, der Fokus bei dieser Ansicht ist die Spalte "Besonderheiten" - 
            Diese wird als erste Spalte angezeigt. 
            Die Ausgabe des Inhaltes in "Besonderheiten" erfolgt gruppiert mit Zeilenumbrüchen. 
            Die Sortierung erfolgt nach Standort Name, Sammlung Name, Musikstück Name, Satz Name    </p>         
                
    <h3 class="chapter-title chapter-title-h3" id="suche-ansicht-material">Auswahl Ansicht: Material</h3>
         <p>Die Ergebnistabelle zeigt Materialien sowie ggf. zugeordnete Schüler an.  
            Es werden sowohl frei erfasste als auch mit einer Sammlung verknüpfte Materalien angezeigt, in letzterem Fall wird 
            der Sammlung-Name mit angezeigt. Folgende Filter können verwendet werden: 
            <br> Such-Kategorien: Schüler, Standort 
            <br> Such-Text: Durchsucht Material-Name, Material-Bemerkung, Sammlung-Name, Sammlung-Bemerkung 

         </p>
        






<h2 class="chapter-title chapter-title-h2" id="suchlogik0">Suchlogik: Auswahl Kategorien</h2>
    
    <p> Kategorie-Arten: </p> 
    <ul> 
        <li> Einfach-Auswahl (z.B. Verlag, Komponist). Es kann nur ein Eintrag ausgewählt werden</li> 
        <li> Mehrfach-Auswahl (z.B. Besetzung, Verwendungszweck). Es können ein oder mehrere Einträge ausgewählt werden. </li>         
    </ul>

    <p> Die Suche orientiert sich an den Erfassungs-Optionen, Beispiel: Das Suchfeld Komponist bietet nur eine Einfach-Auswahl an, da einer Sammlung nur ein Komponist zugeorndet werden kann. </p>

    <p>Die Kombination mehrere Kategorien erfolgt über UND-Verknüpfung.</p> 

    <p> Beispiel: 
        <br />Komponist: "Mozart" 
        <br/> UND     
        <br />Besetzung: "Violine" 
        <br/> UND 
        <br />Verwendungszweck: "Hochzeit" ODER "Fest"
    </p> 

    <hr>

<h2 class="chapter-title chapter-title-h2" id="suchlogik2">Suchlogik: Auswahl in einer Kategorie mit Mehrfachauswahl</h2>

    <p>
    Innerhalb einer Kategorie mit Mehrfach-Auswahl (z.B. Besetzung, Verwendungszweck) können ein oder mehrere Einträge ausgewählt werden.
    Bei einigen Kategorien stehen zusätzlich die Optionen  "Einschluss-Suche" und "Ausschluss-Suche" zur Verfügung. 
    </p> 

    <p> <b>Varianten: </b></p>

    <p> <b>Standard ohne Zusatzoption</b>: 
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
        <li>Bei Auswahl eines Eintrags werden alle Zeilen gesucht, die <u>nur diese Eigenschaft aufweisen</u></li> 
        <li>Bei Auswahl mehrerer Einträge werden alle Zeilen gesucht, die <u>mind. eine der ausgewählten Eigenschaften, jedoch NUR diese</u> aufweisen </li> 
    </ul>
    </p>

    <p><b>Standard mit Zusatzoptionen "Einschluss-Suche" und "Ausschluss-Suche" </b>
    <ul> 
        <li>Bei Auswahl eines Eintrags werden alle Zeilen gesucht, die <u>NUR die auswählte Eigenschaft aufweisen</u></li> 
        <li>Bei Auswahl mehrerer Einträge werden alle Zeilen gesucht, die <u>ALLE und NUR die ausgewählten Eigenschaften</u> aufweisen </li> 
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



    <p> Suche nach mehreren Eigenschaften 
        
    <p> Beispiel: (hier: Notenwerte "Achtel" und "Viertel"): </p>

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
<h2 class="chapter-title chapter-title-h2" id="suche-satz-schwierigkeitsgrad">Suche Satz > Schwierigkeitsgrad</h2>
    <p>Die Auswahlbox enthält die in Verwendung befindlichen Kombinationen aus "Instrument" und "Schwierigkeitsgrad"</p>
    <p>Für die Suchlogik werden die Instrumente separat behandelt. Das funktioniert so, 
        als stünde für jedes Instrument eine eigene Auswahlbox zur Verfügung 
        (Verknüpfung der ausgewählten Instrumente mit UND, 
        Verknüpfung der Schwierigkeitsgrade innerhalb eines Instruments mit ODER). 
    </p>
    <p> Beispielsuche zu Besetzung "Violine und Klavier": 
        Du möchtest ein Stück finden mit einem etwas anspruchsvolleren Part für die Violine und einem 
        leichtern Part für das begleitende Klavier. 
        
        <br><br><u>Markiere in Auswahlbox</u> 
        <br>Violine 2
        <br>Violine 2/3
        <br>Violine 3
        <br>Klavier 0/1
        <br>Klavier 1

        <br><br>Daraus ergibt sich die Suchlogik: 
        <br>Violine: Schwierigkeitsgrade 2, 2/3 ODER 3 
        <br>UND
        <br>Klavier: Schwierigkeitsgrade 0/1 ODER 1 

        </p>


<h1 class="chapter-title chapter-title-h1" id="suche-schueler">SCHÜLER-SUCHE</h1>
    <p>Ergebnis-Tabelle: </p>
    <ul>
        <li>ID</li>
        <li>Name (Name des Schülers)</li>
        <li>Instrumente: Auflistung der zum Schüler erfassten Instrumente sowie (falls eingetragen) 
            die dazugehörige Schwierigkeitsgrade</li>
        <li>Bemerkung</li>
        <li>Materialien: Auflistung der mit dem Schüler verknüpften Materialien. 
            Falls es sich um mit einer Sammlung verknüpfts Material handelt, 
            ist der Sammlungsname dem Material-Namen vorangestellt.   
        </li>
        <li>Noten: Auflistung der mit dem Schüler verknüpften Noten-Sammlungen (Zusammensetzung Sammmlung-Name, Musikstück-Name, Satz-Name - jeweils falls befüllt) </li>
    </ul>
    <h2 class="chapter-title chapter-title-h2" id="suche-schueler-hinweise">Text-Suche</h2>

    <p>
        Suche Textteil Schüler-Tabelle: 
        <ul>
            <li>Schüler Name</li>
            <li>Schüler Bemerkung</li>
        </ul>
        </p>
        <p>Suche Textteil in verknüpften Daten:  
        <ul>
            <li>Sammlung Name</li>
            <li>Sammlung Bemerkung</li>
            <li>Musikstueck Name</li>
            <li>Satz Name</li>
            <li>Satz Bemerkung</li>
            <li>Material Name</li>
            <li>Material Bemerkung</li>

        </ul>        

    </p>

    <h2 class="chapter-title chapter-title-h2" id="suche-schueler-schueler">Schüler</h2>    
         <p> Auswahl 1 Schüler XXX </p> 

    <h2 class="chapter-title chapter-title-h2" id="suche-schueler-schueler">Instrument</h2>    
        <p>Instrument (Einfach-Auswahl) XXX 
        </p> 

    <h2 class="chapter-title chapter-title-h2" id="suche-schueler-schueler">Schwierigkeitsgrad</h2> 
        <p>Schwierigkeitsgrad (Mehrfachauswahl): Suche Schwierigkeitsgrad(e), unabhängig von Instrument XXX</p> 

    <h2 class="chapter-title chapter-title-h2" id="suche-schueler-status">Status Noten / Material</h2> 
        <p>
            Filter nach "Status". Es wird gesucht nach dem Status-Eintrag, der unter   
            <a href="help_erfassung.php?#erfassung_satz_schueler">"Satz" > "Schüler"</a> 
            oder <a href="help_erfassung.php?#erfassung_schueler_material">"Schüler x Material" Zuordnung</a> 
            erfasst wurde. 
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


        
    </p>
        
       
        
    


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

