<?php 
$PageTitle='Hilfe';  
include_once('head.php');
?>

<p class="doc"><b>Kapitel:</b> </p>

<div id="inhaltsverzeichnis"></div>

<div class="body-doc"> 

<h1 class="chapter-title chapter-title-h1" id="suche_beispiele">Übungs-Beispiele zur Suche</h1>
    <p> Die folgenden Beispiele stammen aus dem Datenbestand des Initial-Projektes. Die verwendeten Suchbegriffe können in anderen Datenbeständen ggf. abweichen.  </p> 

    <h2 class="chapter-title chapter-title-h2" id="suche-schueler-alle-noten">Suche: Noten- / Materialien zu einem Schüler</h2>
    <p> Zeige alle Noten / Materialien für einen Schüler mit Status "Idee", wo "Tonleiter" geübt wird.   </p>  
    <ul>
        <li>Ansicht: "Sammlung erweitert" (dort sind Noten + Materialien in Spalten aufgelistet) </li>
        <li>Abschnitt "Schüler" -> Auswahl "Schüler" (z.B. Anna-Luna) </li>
        <li>Abschnitt "Schüler" -> Auswahl "Status" (z.B. "01 - Idee") </li>
        <li>Abschnitt "Besonderheiten" -> Auswahl in Besonderheit "Übung sonst" -> "Tonleiter"  </li>
    </ul>

<h1 class="chapter-title chapter-title-h1" id="suche_ansicht">Ansichten</h1>
    <h2 class="chapter-title chapter-title-h2" id="suche_ansicht_noten">Noten</h2>
        <p>Sortierung: Sammlung Name, Musikstück Nr, Satz Nr</p>

        <h3 class="chapter-title chapter-title-h3" id="suche_ansicht_noten_sammlung">Noten: Sammlung</h3>
            <p>Gruppierung auf Sammlung-Ebene. 
            <br> Anzeige der Spalten:
            <br> * Sammlung ID 
            <br> * Sammlung Name  
            <br> * Sammlung Standort 
            <br> * Sammlung Verlag  
            <br> * Sammlung Bemerkung  
            </p>


        <h3 class="chapter-title chapter-title-h3" id="suche_ansicht_noten_sammlung_erweitert">Noten: Sammlung erweitert</h3>
            <p>Gruppierung auf Sammlung-Ebene. 
            <br> Anzeige der Spalten:
            <br> * Sammlung ID 
            <br> * Sammlung Name  
            <br> * Sammlung Standort 
            <br> * Sammlung Verlag  
            <br> * Sammlung Bemerkung  
            </p>


            

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
      
<!-- 
        


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


<h1 class="chapter-title chapter-title-h1" id="suche_filter">Filter </h1>

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



</div> 

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

























		<script src="js_toc.js"></script>


<?php 
include_once('foot.php');
?>

