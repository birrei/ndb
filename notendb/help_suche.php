<?php 
$PageTitle='Hilfe Suche';  
include_once('head.php');
?>

<p class="doc"><b>Kapitel:</b> </p>

<div id="inhaltsverzeichnis"></div>

<div class="body-doc"> 

<h1 class="chapter-title chapter-title-h1" id="suche_ansichten">Ansichten</h1>

    <h2 class="chapter-title chapter-title-h2" id="suche_ansichten_sammlung">Grundsätzliches</h2>

    <p>Durch die "Ansichten" wird festgelegt ... 
        <br> ... welche Ergebnis-Tabellen angezeigt werden 
        <br> ... welche Gruppierungs-Ebene bei der Ausgabe der jeweiligen Ergebnistabelle wirksam wird 
        <br> ... welche Zusatz-Spalten zusätzlich (in welcher Weise) angezeigt werden.          
        </p>
    

    <h2 class="chapter-title chapter-title-h2" id="suche_ansichten_sammlung">Sammlung-Ansichten</h2>

    <p>Für die Sammlung*-Ansichten ist definiert, das (je nach Filtereinstellung) folgende Ergebnistabellen sichtbar sein können: 
        <br>  * <b>Sammlungen und Noten</b> 
        <br>  * <b>Sammlungen und Material</b> 
        </p>
        

    <p> Folgende Varianten sind für Sammlung*-Ansichten möglich: 
    <ul> 
        <li>Ansicht <b>"Sammlung"</b>: Beide Ergebnistabellen werden auf Ebene "Sammlung" angezeigt. </li>
         <br>
          
        <li>Ansicht <b>"Sammlung erweitert"</b>: 
            <br> Ergebnistabelle "Sammlungen und Noten" wird auf  Ebene "Sammlung > Musikstück" angezeigt. 
            <br> Ergebnistabelle "Sammlungen und Material" wird auf  Ebene "Sammlung > Material" angezeigt. 
             <br>
             <br> 
        </li>
        <li>Ansicht <b>"Sammlung erweitert 2"</b>: 
            <br> Ergebnistabelle "Sammlungen und Noten" wird auf  Ebene "Sammlung > Musikstück > Satz" angezeigt. 
            <br> Ergebnistabelle "Sammlungen und Material" wird auf  Ebene "Sammlung > Material" angezeigt 
             <br> 
             <br>   
        </li>
        <li>Ansicht <b>"Sammlung erweitert 3"</b>: 
            <br> 
               In einer zusätzliche Spalte wird die Liste der zugeordneten Schüler (inkl. Status) angezeigt. 
               Die Gruppierungsebene entspricht der Ansicht "Sammlung erweitert 2" 
                 
                <br>    
        </li>

    </ul>


<h1 class="chapter-title chapter-title-h1" id="suche_filter">Wirkung von Filtern</h1>

    <h2 class="chapter-title chapter-title-h2" id="suchlogik-ansichten">Ansichten und Filter </h2>
    <p>Such-Filter, die gleichzeitig Muskstücke/Sätze sowie Materialien einschließen sollen, 
        müssen auf Sammlung-Ebene (Anschten "Sammlung *") ausgeführt werden. Wenn ein Musikstück*-Ansicht bzw. eine Satz*-Ansicht ausgewählt ist ausgewählt ist, werden ausgewählte Filter nur auf Sammlung, Musikstück  oder Satz angewandt, nicht jedoch auf Materialien 
        (auch dann nicht, wenn nach einer Eigenschaft gefiltert wird, die grundsätzlich auch für Materialien zur Verfügung steht)  </p>

    <h2 class="chapter-title chapter-title-h2" id="suchlogik-auswahl-einfach">Suchlogik bei Einfach-Auswahl</h2>
    
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

	<h2 class="chapter-title chapter-title-h2" id="suchlogik-auswahl-mehrfach">Suchlogik bei Mehrfachauswahl</h2>

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



    <hr>


<h1 class="chapter-title chapter-title-h1" id="suche_filter_einzeln">Einzelne Filter</h1>


	<h2 class="chapter-title chapter-title-h2" id="suche_noten_text">Filter: Textsuche</h2>
    <p> Hinweis: Die Verwendung der Textsuche kann zu einer verzögerten Ergebnisanzeige führen! </p>
    <p> Folgende Felder werden durchsucht: XXX </p>

	<h2 class="chapter-title chapter-title-h2" id="suche_satz_schwierigkeitsgrad">Filter: Satz: Instrument / Schwierigkeitsgrad</h2>
    <p> Hinweise: Der Filter ist nur für die Sammlung-, Musikstück- und Satz-Ansichten (Gruppe Noten) wirksam.
        Gesucht wird nach den am Satz unter "Schwierigkeitsgrad" (Instrument + Grad) erfassen Eigenschaften. 
    Die Auswahlbox enthält die in Verwendung befindlichen Kombinationen aus "Instrument" und "Schwierigkeitsgrad"</p>
    <p>Für die Suchlogik werden die Instrumente separat behandelt. Das funktioniert so, 
        als stünde für jedes Instrument eine eigene Auswahlbox zur Verfügung 
        (Verknüpfung der ausgewählten Instrumente mit UND, 
        Verknüpfung der Schwierigkeitsgrade innerhalb eines Instruments mit ODER). 
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
	<h2 class="chapter-title chapter-title-h2" id="suche_satz_status">Filter: Status Schüler-Satz</h2>
        <ul>
            <li>Sammlung-, Musikstück- und Satz-Ansichten: Suche nach Status der Schüler x Satz - Verknüpfung </li>
            <li>Material-Ansichten: Suche nach Status der Schüler x Material - Verknüpfung</li>
        </ul>
  


    <h2 class="chapter-title chapter-title-h2" id="suche_schueler">Filter: Schüler</h2>
        <p> Das Auswahlfeld "Schüler" zeigt nur aktive Schüler an (siehe auch Erfassung Schüler > Aktiv XXX )
	<h2 class="chapter-title chapter-title-h2" id="suche_schueler_ergebnistabelle">Filter: Status Schüler Noten/Material</h2>

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


	<h2 class="chapter-title chapter-title-h2" id="suche_schueler_hinweise">Filter: Text-Suche</h2>

    <p>Textsuche in folgenden Feldern: 
        <ul>
            <li>Schüler Name</li>
            <li>Schüler Bemerkung</li>
            <li>Sammlung Name (nur mit Schülern verknüpfte Sammlungen) </li>
            <li>Sammlung Bemerkung (nur mit Schülern verknüpfte Sammlungen) </li>
            <li>Musikstück Name (nur mit Schülern verknüpfte Musikstücke) </li>
            <li>Satz Name (nur mit Schülern verknüpfte Sätze) </li>
            <li>Satz Bemerkung (nur mit Schülern verknüpfte Sätze) </li>
            <li>Schüler x Satz Verknüpfung Bemerkung  </li>             
            <li>Material Name  (nur mit Schülern verknüpfte Materialen) </li>
            <li>Material Bemerkung (nur mit Schülern verknüpfte Materialen) </li>
            <li>Schüler x Material Verknüpfung Bemerkung  </li>    
        </ul>        
    </p>

	<h2 class="chapter-title chapter-title-h2" id="suche_schueler_schueler">Filter: Schüler</h2>    
        <p> Auswahl 1 Schüler XXX </p> 

	<h2 class="chapter-title chapter-title-h2" id="suche_schueler_schueler">Filter: Instrument</h2>    
        <p>Instrument (Einfach-Auswahl) XXX </p> 

	<h2 class="chapter-title chapter-title-h2" id="suche_schueler_schueler">Filter: Schwierigkeitsgrad</h2> 
        <p>Schwierigkeitsgrad (Mehrfachauswahl): Suche Schwierigkeitsgrad(e), unabhängig von Instrument XXX</p> 

	<h2 class="chapter-title chapter-title-h2" id="suche_schueler_status">Filter: Status Noten / Material</h2> 
    <p>
        Filter nach "Status". Es wird gesucht nach dem Status-Eintrag, der unter   
        <a href="help_erfassung.php?#erfassung_satz_schueler">"Satz" > "Schüler"</a> 
        oder <a href="help_erfassung.php?#erfassung_schueler_material">"Schüler x Material" Zuordnung</a> 
        erfasst wurde. 
    </p>

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

   <p>Hinweise: </p>

        
    <p id="fussnote-ansichten"> 
         (1) Auflistungen von Unterelementen (in "* erweitert-" - Ansichten) innerhalb einer Zelle können unvollständig sein, 
         da die Kapazität dieser Darstellungsform begrenzt ist. Die Anzeige der Ergebnisse kann bei einer größeren Anzahl 
         von Suchergebnissen ggf. verzögert erfolgen. 
        </p> 




</div> 



		<script src="js_toc.js"></script>


<?php 
include_once('foot.php');
?>

