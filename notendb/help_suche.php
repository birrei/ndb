<?php 
$PageTitle='Hilfe Suche';  
include_once('head.php');
?>

<p class="doc-header"><b>Kapitel:</b> </p>

<div class="doc-toc" id="inhaltsverzeichnis"></div>

<div class="doc-body"> 

<h1 class="chapter-title chapter-title-h1" id="suche_ansichten">Ansichten</h1>


    <h2 class="chapter-title chapter-title-h3" id="suche_ansichten_hinweise">Hinweise zu Ansichten</h2>

        <p>Durch die "Ansichten" wird festgelegt ... </p>
        <ul>
            <li>Welche Filtermöglichkeiten eingeblendet werden </li>
            <li>Wie die Ergebnistabelle ausgegeben wird (Gruppierungs-Ebene, angezeigte Spalten)</li>
                    
            </ul>   


    
    <h2 class="chapter-title chapter-title-h3" id="suche_ansichten_gruppe_noten">Ansichten Gruppe "Noten"</h2>
            <p> Verfügbare Filterbereiche: Suchtext, Schüler (Name + Noten Status) Sammlung, Musikstück, Satz, Besonderheiten  </p>
            
        <h3 class="chapter-title chapter-title-h3" id="suche_ansichten_sammlung1">Ansicht "Sammlung"</h3>
            <p>Die Ergebnistabelle zeigt passende Sammlungen an, inklusive Sammlungen ohne Musikstücke / Sätze.</p> 

        <h3 class="chapter-title chapter-title-h3" id="suche_ansichten_sammlung2">Ansicht "Sammlung, Musikstück"</h3>
            <p>Die Ergebnistabelle passende Sammlungen und Musikstücke an. Sammlungen / Musikstücke ohne Sätze werden nicht angezeigt  
                </p> 

        <h3 class="chapter-title chapter-title-h3" id="suche_ansichten_sammlung3">Ansicht "Sammlung, Musikstück, Satz"</h3>
            <p>Die Ergebnistabelle zeigt Sammlungen, Musikstücke und Sätze an. </p> 

        <h3 class="chapter-title chapter-title-h3" id="suche_ansichten_sammlung3">Ansicht "Sammlung, Musikstück, Satz + Schüler"</h3>
            <p>Gruppierung und Abfrage entpricht "Sammlung, Musikstueck, Satz"- jedoch zeigt die Ergebnistabelle weniger 
                Noten-bezogene Informationen, dafür zusätzlich eine Spalte "Schüler" mit einer Auflistung aller zugeordneten Schüler /Status-Infos</p> 
            
    
    <h2 class="chapter-title chapter-title-h2" id="suche_ansichten_gruppe_schueler">Ansichten Gruppe "Schüler"</h2>
            <p> Verfügbare Filterbereiche: Suchtext, Schüler, Besonderheiten  </p>
            <p> </p>             
            <p> </p>             
        <h3 class="chapter-title chapter-title-h3" id="suche_ansichten_schueler1">Ansicht "Schüler"</h3>
                <p> XXX</p> 
        <h3 class="chapter-title chapter-title-h3" id="suche_ansichten_schueler1">Ansicht "Schüler erweitert"</h3>
                <p> XXX</p> 

    <h2 class="chapter-title chapter-title-h2" id="suche_ansichten_uebungen">Ansichten Gruppe "Übungen"</h2>
        <h3 class="chapter-title chapter-title-h3" id="suche_ansichten_schueler1">Ansicht "Übungen"</h3>
                <p> XXX</p> 





    <hr>


<h1 class="chapter-title chapter-title-h1" id="suche_filter_einzeln">Einzelne Filter</h1>


	<h2 class="chapter-title chapter-title-h2" id="suche_schueler_hinweise">Filter: Text-Suche</h2>

    <p>Suche nach (Teil-)Zeichenketten.  </p> 

    <p>Es hängt von der gewählten Ansicht ab, welche Felder durchsucht werden. </p> 


    <p>Noten - Ansichten (Sammlung, Musikstück, Satz ~ ) Suche in: </p>

    <ul>

            <li>Sammlung Name</li>
            <li>Sammlung Bemerkung  </li>
            <li>Musikstück Name  </li>
            <li>Musikstück Bemerkung  </li>
            <li>Musikstück Bearbeiter</li>
            <li>Musikstück Opus</li>
            <li>Musikstück Besetzungen </li>
            <li>Musikstück Verwendungszwecke </li>
            <li>Musikstück Komponist   </li>   
            <li>Musikstück Epoche </li>   
            <li>Musikstück Gattung</li>   

            <li>Satz Name  </li>
            <li>Satz Bemerkung  </li>          
            <li>Satz Tempobezeichnung  </li>          
            <li>Satz Orchesterbesetzung  </li>          
            <li>Satz Erprobt Bemerkung  </li>          
    </ul>  

        <p>Schüler-Ansichten: </p>

        <ul>
            <li>Schüler Name</li>
            <li>Schüler Bemerkung</li>
            <li>Schüler Noten-Status Bemerkung</li>
                    
            </ul>        

        <p>Übungen-Ansichten: </p>

        <ul>
            <li>Übung Inhalt </li>
            <li>Übung Bemerkung </li>
            <li>Übung > Satz Name </li>
            <li>Übung > Musikstueck Name </li>
            <li>Übung > Sammlung Name </li>
        </ul>        

	<h2 class="chapter-title chapter-title-h2" id="suche_satz_schwierigkeitsgrad">Filter: Satz: Instrument / Schwierigkeitsgrad</h2>
    <p> Hinweise: Der Filter ist nur für die Sammlung-, Musikstück- und Satz-Ansichten (Gruppe Noten) wirksam.
        Gesucht wird nach den am Satz unter "Schwierigkeitsgrad" (Instrument + Grad) erfassen Eigenschaften. 
    Die Auswahlbox enthält die in Verwendung befindlichen Kombinationen aus "Instrument" und "Schwierigkeitsgrad"</p>
    <p>Für die Suchlogik werden die Instrumente separat behandelt. </p>
        
    <p>Das funktioniert so, 
        als stünde für jedes Instrument eine eigene Auswahlbox zur Verfügung 
        (Verknüpfung der ausgewählten Instrumente mit UND, 
        Verknüpfung der Schwierigkeitsgrade innerhalb eines Instruments mit ODER). </p>

    </p>
    <p> Beispielsuche zu Besetzung "Violine und Klavier": 
        Du möchtest ein Stück finden mit einem etwas anspruchsvolleren Part für die Violine und einem 
        leichten Part für das Klavier. 
        
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


    <h2 class="chapter-title chapter-title-h2" id="suche_schueler">Filter: Schüler</h2>
        <p> Hinweise: Das Auswahlfeld "Schüler" zeigt nur aktive Schüler an (siehe auch Erfassung Schüler > Aktiv XXX )

	<h2 class="chapter-title chapter-title-h2" id="suche_schueler_schueler">Filter: Instrument</h2>    
        <p>Instrument (Einfach-Auswahl) XXX </p> 

	<h2 class="chapter-title chapter-title-h2" id="suche_schueler_schueler">Filter: Schwierigkeitsgrad</h2> 
        <p>Schwierigkeitsgrad (Mehrfachauswahl): Suche Schwierigkeitsgrad(e), unabhängig von Instrument XXX</p> 

	<h2 class="chapter-title chapter-title-h2" id="suche_satz_status">Filter: Status Schüler-Satz</h2>
        <ul>
            <li>Sammlung-, Musikstück- und Satz-Ansichten: Suche nach Status der Schüler x Satz - Verknüpfung </li>
        </ul>
  

    <hr>



<h1 class="chapter-title chapter-title-h1" id="suche_filter">Bedienung der Filter-Elemente</h1>

    <h2 class="chapter-title chapter-title-h2" id="suche_info_filter_einfach">Filter-Elemente: Klappliste mit Einfach-Auswahl</h2>
    
            <p>XXX</p>

	<h2 class="chapter-title chapter-title-h2" id="suche_info_filter_mehrfach">Filter-Elemente: Auswahlbox mit Mehrfach-Auswahl</h2>
        
        <p> Innerhalb einer Kategorie mit Mehrfach-Auswahl (z.B. Besetzung, Verwendungszweck) können ein oder mehrere Einträge ausgewählt werden.
        Bei einigen Kategorien stehen zusätzlich die Optionen  "Einschluss-Suche" und "Ausschluss-Suche" zur Verfügung. </p> 

                <p>Mehrere Einträge markieren: STRG halten und Einträge anklicken </p>
                <p>Einträge Auswahl entfernen: STRG halten und markierten Einträg anklicken </p>
                <p>Mehrere Einträge untereinander markieren: SHIFT halten und ersten sowie letzten Eintrag anklicken   </p>



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
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>

   <!-- <p>Hinweise: </p>

        
    <p id="fussnote-ansichten"> 
         (1) Auflistungen von Unterelementen (in "* erweitert-" - Ansichten) innerhalb einer Zelle können unvollständig sein, 
         da die Kapazität dieser Darstellungsform begrenzt ist. Die Anzeige der Ergebnisse kann bei einer größeren Anzahl 
         von Suchergebnissen ggf. verzögert erfolgen. 
        </p> 

 -->


</div> 

<script src="js_toc.js"></script>


<?php 
include_once('foot.php');
?>

