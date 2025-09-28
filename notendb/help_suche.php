<?php 
$PageTitle='Hilfe Suche';  
include_once('head.php');
?>

<p class="doc"><b>Kapitel:</b> </p>

<div id="inhaltsverzeichnis"></div>

<div class="body-doc"> 

<h1 class="chapter-title chapter-title-h1" id="suche_ansichten">Ansichten</h1>

    <h2 class="chapter-title chapter-title-h2" id="suche_ansichten_sammlung">Grundsätzliches</h2>


    <p>Durch die "Ansichten" wird festgelegt ... </p>
    <ul>
        <li>Welche Filtermöglichkeiten eingeblendet werden </li>
        <li>Wie die Ergebnistabelle ausgegeben wird (Gruppierungsegbene, angezeigte Spalten)</li>
        <li>Schüler Status Bemerkung</li>
                   
        </ul>   



    <h2 class="chapter-title chapter-title-h3" id="suche_ansichten_gruppe_noten">Ansichten Gruppe "Noten"</h2>
            <p> Verfügbare Filterbereiche: Suchtext, Schüler (Name + Noten Status) Sammlung, Musikstück, Satz, Besonderheiten  </p>
            
        <h3 class="chapter-title chapter-title-h3" id="suche_ansichten_sammlung1">Ansicht "Sammlung"</h3>
            <p> XXX</p> 
        <h3 class="chapter-title chapter-title-h3" id="suche_ansichten_sammlung2">Ansicht "Sammlung, Musikstück"</h3>
            <p> XXX</p> 

        <h3 class="chapter-title chapter-title-h3" id="suche_ansichten_sammlung3">Ansicht "Sammlung, Musikstück, Satz"</h3>
            <p> XXX</p> 

        <h3 class="chapter-title chapter-title-h3" id="suche_ansichten_sammlung3">Ansicht "Sammlung, Musikstück, Satz + Schüler"</h3>
            <p> XXX</p> 
            
    
    <h2 class="chapter-title chapter-title-h2" id="suche_ansichten_gruppe_schueler">Ansichten Gruppe "Schüler"</h2>
            <p> Verfügbare Filterbereiche: Suchtext, Schüler, Besonderheiten  </p>
            <p> </p>             
        <h3 class="chapter-title chapter-title-h3" id="suche_ansichten_schueler1">Ansicht "Schüler"</h3>
                <p> XXX</p> 
        <h3 class="chapter-title chapter-title-h3" id="suche_ansichten_schueler1">Ansicht "Schüler erweitert"</h3>
                <p> XXX</p> 


<h1 class="chapter-title chapter-title-h1" id="suche_filter">Arten von Filtern</h1>

    <h2 class="chapter-title chapter-title-h2" id="suchlogik-auswahl-einfach">Klappliste mit Einfach-Auswahl</h2>
    
            <p>XXX</p>

	<h2 class="chapter-title chapter-title-h2" id="suchlogik-auswahl-mehrfach">Klappliste mit Mehrfachauswahl</h2>

            <p>Mehrere Einträge markieren: STRG halten und Einträge anklicken </p>
            <p>Einträge Auswahl entfernen: STRG halten und markierten Einträg anklicken </p>
            <p>Mehrere Einträge untereinander markieren: SHIFT halten und ersten sowie letzten Eintrag anklicken   </p>


        <!-- 
    <p> Die Suche orientiert sich an den Erfassungs-Optionen, 
        Beispiel: Das Suchfeld Komponist bietet nur eine Einfach-Auswahl an, 
        da einer Sammlung nur ein Komponist zugeorndet werden kann. </p> -->

<h1 class="chapter-title chapter-title-h1" id="suche_logik">Erklärungen zu Suchlogiken </h1>

    <h2 class="chapter-title chapter-title-h2" id="suchlogik-filter-kombination">Kombination der Filter</h2>


    <p>Die Kombination mehrere Filter erfolgt über UND-Verknüpfung.</p> 

    <p> Beispiel: 
        <br />Komponist: "Mozart" 
        <br/> UND     
        <br />Besetzung: "Violine" 
        <br/> UND 
        <br />Verwendungszweck: "Hochzeit" ODER "Fest"
    </p> 

    <h2 class="chapter-title chapter-title-h2" id="suchlogik-filter-kombination">Suchlogik bei Mehrfach-Auswahlfiltern</h2>


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





    <hr>


<h1 class="chapter-title chapter-title-h1" id="suche_filter_einzeln">Einzelne Filter</h1>


	<h2 class="chapter-title chapter-title-h2" id="suche_schueler_hinweise">Filter: Text-Suche</h2>

    <p>Bei Aktivierung einer Ansicht aus der Gruppe "Noten" (Sammlung, Musikstück, Satz ~ ) 
        werden folgende Felder durchsucht: </p>

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

    <p>Bei Aktivierung einer Ansicht aus der Gruppe "Schüler" werden folgende Felder durchsucht </p>

    <ul>
        <li>Schüler Name</li>
        <li>Schüler Bemerkung</li>
        <li>Schüler Status Bemerkung</li>
                   
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

