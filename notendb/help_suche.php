<?php 
$PageTitle='Hilfe Suche';  
include_once('head.php');
?>

<p class="doc"><b>Kapitel:</b> </p>

<div id="inhaltsverzeichnis"></div>

<div class="body-doc"> 


<h1 class="chapter-title chapter-title-h1" id="suche_ansicht">Ansichten</h1>


    <h2 class="chapter-title chapter-title-h2" id="suche_ansicht_noten">Sammlung</h2>

        <p> Die Ergebnis-Tabellen werden auf Sammlung- Ebene gruppiert
            Die Sortierung erfolgt nach Sammlung Name. 
          
        In beiden Ergebnistabellen werden die folgenden Spalten angezeigt: 
        <br> * Sammlung ID 
        <br> * Sammlung Name  
        <br> * Sammlung Standort 
        <br> * Sammlung Verlag  
        <br> * Sammlung Bemerkung  
        <br> * Sammlung Besonderheiten   
        </p>

    <h2 class="chapter-title chapter-title-h2" id="suche-ansicht-sammlung-erweitert">Sammlung erweitert</h2>


            <p> Ergebnistabelle  "1) Sammlungen und Noten" ist auf Ebene Musikstück gruppiert und zeigt folgende Spalten an: 

            <br> * Musikstück ID	
            <br> * Sammlung Standort	
            <br> * Sammlung Name 	
            <br> * Musikstück Nr	
            <br> * Musikstück Name 	
            <br> * Musikstück Komponist	
            <br> * Musikstück Besetzungen	
            <br> * Musikstück Verwendungszwecke	
            <br> * Musikstück Saetze (Liste der Satz-Nummern, sofern vorhanden)	
            <br> * Musikstück Bearbeiter	
            <br> * Musikstück Gattung	
            <br> * Musikstück Epoche	

            </p>

           <p> Ergebnistabelle  "2) Sammlungen und Materalien" ist auf Ebene Material gruppiert und zeigt folgende Spalten an: 


            <br> * Material ID	
            <br> * Sammlung Name 	
            <br> * Material Name 	
            <br> * Material Bemerkung	
            <br> * Materialtyp	
            <br> * Material Schwierigkeitsgrade	
            <br> * Material Besonderheiten
            </p>


    <h2 class="chapter-title chapter-title-h2" id="suche-ansicht-sammlung-erweitert2">Sammlung erweitert 2</h2>

            <p> Ergebnistabelle  "1) Sammlungen und Noten" ist auf Ebene Satz gruppiert und zeigt folgende Spalten an: 

            <br> * Satz ID	
            <br> * Sammlung Standort 
            <br> * Sammlung	Name 
            <br> * Musikstueck Name 
            <br> * Musikstück Komponist	            
            <br> * Satz Nr	
            <br> * Satz Name 	
            <br> * Satz Tempobezeichnung	
            <br> * Satz Schwierigkeitsgrade	
            <br> * Satz Besonderheiten	
            <br> * Satz Orchesterbesetzung	
            <br> * Satz Bemerkung

           <p>Die Anzeige der Ergebnistabelle  "2) Sammlungen und Materalien" entpricht derjenigen bei Ansicht <a href="#suche-ansicht-sammlung-erweitert">Sammlung erweitert"</a>. 


           
<!-- 


        <h3 class="chapter-title chapter-title-h3" id="suche_ansicht_noten_sammlung_links">Sammlung Links</h3>
            <p>Gruppierung auf Sammlung-Ebene</p>

        <h3 class="chapter-title chapter-title-h3" id="suche_ansicht_noten_musikstueck">Musikstueck</h3>
            <p>Gruppierung auf Musikstück Ebene</p>
        <h3 class="chapter-title chapter-title-h3" id="suche_ansicht_noten_satz">Satz</h3>
            <p>Gruppierung auf Satz-Ebene</p>

        <h3 class="chapter-title chapter-title-h3" id="suche_ansicht_noten_satz_besonderheiten">Satz Besonderheiten</h3>
            <p>Gruppierung auf Satz-Ebene</p>        
        <h3 class="chapter-title chapter-title-h3" id="suche_ansicht_noten_satz_schueler">Satz und Schüler</h3>
            <p>Gruppierung auf Satz-Ebene</p>

        <h3 class="chapter-title chapter-title-h3" id="suche_ansicht_material_einfach">Material</h3>
            <p>Gruppierung auf Material-Ebene. Nur Sammlungen mit Materialien sind abrufbar.  </p>

        <h3 class="chapter-title chapter-title-h3" id="suche_ansicht_material_erweitert">Material erweitert</h3>
            <p>Gruppierung auf Material-Ebene. Nur Sammlungen mit Materialien sind abrufbar. </p>
            
    <h2 class="chapter-title chapter-title-h2" id="suche_ansicht_schueler">Schüler</h2>

        <h3 class="chapter-title chapter-title-h3" id="suche_ansicht_material_einfach">Schüler</h3>
        <h3 class="chapter-title chapter-title-h3" id="suche_ansicht_material_erweitert">Schüler erweitert</h3>
      

        


        <li><b>Sammlung mit Links: </b>
        Die  Ergebnistabelle wird auf Sammlung-/Link Ebene gruppiert (Eine Zeile pro Sammlung und Link).
        Die Sortierung erfolgt nach Standort Name, Sammlung Name
        </li>

        <li><b>Musikstück: </b>
        Die  Ergebnistabelle wird auf Musikstück-Ebene gruppiert gruppiert (Eine Zeile pro Musikstück).
        Die Sortierung erfolgt nach Standort Name, Sammlung Name, Musikstück Name.  
        Hinweis: In "Musikstück"-Ansichten werden nur solche Sammlungen angezeigt, denen Musikstücke zugeordnet sind.
        </li>
        <li><b>Satz: </b>
        Die Ergebnistabelle  wird auf Satz-Ebene gruppiert (Eine Zeile pro Satz). 
        Die Sortierung erfolgt nach Standort Name, Sammlung Name, Musikstück Name, Satz Name 
        In "Satz"-Ansichten werden nur Sammlungen / Musikstücke angezeigt, denen Sätze zugeordnet sind. 
        </li>
        <li><b>Satz Besonderheiten: </b>
        Die Ergebnistabelle wird auf Satz-Ebene gruppiert (Eine Zeile pro Satz), die Sortierung entspricht der Ansicht "Satz". 
                Es werden nur ausgewählte Spalten angezeigt. 
                Die Spalte "Besonderheiten" wird vorne angezeigt, die Ausgabe des Inhaltes in "Besonderheiten" 
                erfolgt gruppiert nach Typ mit Zeilenumbrüchen. 
            </li>
            <li><b>Satz Schüler: </b>
            Die Ergebnistabelle wird auf Satz-Ebene gruppiert (Eine Zeile pro Satz), die Sortierung entspricht der Ansicht "Satz". 
                    Es werden nur ausgewählte Spalten angezeigt. 
                   In der Spalte "Schüler" werden die Schüler komma-separiert aufgelistet. 
            </li>
            <li><b>Material: </b>
                 Die Ergebnistabelle zeigt Materialien sowie ggf. zugeordnete Schüler an.  
                Es werden sowohl frei erfasste als auch mit einer Sammlung verknüpfte Materalien angezeigt, in letzterem Fall wird 
                der Sammlung-Name mit angezeigt. Folgende Filter können verwendet werden: 
                <br> Such-Kategorien: Schüler, Standort
                <br> Such-Text: Durchsucht Material-Name, Material-Bemerkung, Sammlung-Name, Sammlung-Bemerkung 
            </li> 



            </ul>
 -->


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

