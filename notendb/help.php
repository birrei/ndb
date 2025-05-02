<?php 
$PageTitle='Hilfe';  
include('head.php');
?>

<p> Entwurf, nicht auf aktuellstem Stand! </p> 

<p class="doc"><b>Kapitel:</b> </p>

<div id="inhaltsverzeichnis"></div>


<div class="body-doc"> 
<h1 class="chapter-title chapter-title-h1" id="suche_erfassung">Erfassung</h1>
	<h2 class="chapter-title chapter-title-h2" id="erfassung_sammlung">Sammlung</h2>  
        <h3 class="chapter-title chapter-title-h3" id="erfassung_sammlung_erfasst">Sammlung: (vollständig) Erfasst</h3>

            <p>Das Feld kann aktiviert werden, wenn die Erfassung der Sammlung (inklusive Musikstücke/Sätze) komplett abgeschlossen ist. 
            <p> Hinweis: Die Datenprüfungen unter <a href="tests.php?title=Tests">Tests</a> enthalten nur Abfragen auf vollständig erfasste Sammlungen. </p>
            .... 
        <h3 class="chapter-title chapter-title-h3" id="erfassung_sammlung_kopieren">Sammlung: kopieren</h3>
            <p>Button "Sammlung kopieren": Die Sammlung inklusive  aller Eigenschaften und Untereinheiten 
                wird kopiert. Die Kopie wird im aktuellen Formular geöffnet. Am Zusatz  
                " (Kopie)" im Feld "Name" ist die Kopie erkennbar. 
                Im Seitenkopf erscheint ein Hinweis auf den Kopiervorgang (Neue ID, alte ID mit Link).
                Über den Link kann bei Bedarf die Quelle in neuem Fenster geöffnet werden.  
            </p>

            <h3 class="chapter-title chapter-title-h3" id="erfassung_sammlung_material">Sammlung: Material</h3>
                <p>Beschreibung Material zu Sammlung XXX ... </p> 
                <p>Ein Material kann auch unabhängig von einer Sammlung angelegt werden, siehe dazu Kapitel <a href="#erfassung_material">Material</a></p> 

	<h2 class="chapter-title chapter-title-h2" id="erfassung_musikstueck">Musikstück</h2>
        <h3 class="chapter-title chapter-title-h3" id="erfassung_musikstueck_nummer">Musikstück: Nummer</h3>
            <p>Enthält ein ganzzahligen Wert, der die Reihenfolge der Musikstück innerhalb der Sammlung abbildet. 
                Der Wert wird bei Neuanlage eines Musikstücks automatisch vergeben (hochgezählt), kann danach aber manuell angepasst werden.
                Es können nur ganzzahlige Werte verwendet werden (nicht möglich sind z.B: 1.1 oder 1b etc) 
        
        <h3 class="chapter-title chapter-title-h3" id="erfassung_musikstueck_besetzung">Musikstück: Besetzung(en)</h3>
        <p>Die Einträge für die Zuordnung stammen aus der Stammdaten-Tabelle <a href="#erfassung_stammdaten_besetzung">"Besetzung"</a> </p>
            
        <p>Für feste Besetzungen (z.B. Violine, Viola und Klavier = "Klaviertrio"), bei der keines der Instrument weggelassen werden kann, 
                sollte als ein Ensemble-Eintrag vorgenommen werden. Die Erfassung von Einzelinstrumenten ist nur 
                dann sinnvoll, wenn die Instrumente bei einem Musikstück variieren können  
                - z.B. wenn ein Sammelhelft mit gleichen 
                Musikstücken für verschiedene Instrumenten besetzt werden kann (kommt z.B. bei Lehr-Werken vor)
            </p>

            <p>Die Art der Zuordnung wirkt auf das Vorgehen bei der Suche aus (XXX Verweis hier später einfügen) </p>
            <p>XXX </p>


        <h3 class="chapter-title chapter-title-h3" id="erfassung_musikstueck_kopieren">Musikstück: kopieren</h3>

            <p>Button "Musikstück kopieren": Die Sammlung inklusive  aller Eigenschaften und Untereinheiten 
                wird kopiert. Die Kopie wird im aktuellen Formular geöffnet. Am Zusatz  
                " (Kopie)" im Feld "Name" ist die Kopie erkennbar. 
                Im Seitenkopf erscheint ein Hinweis auf den Kopiervorgang (Neue ID, alte ID mit Link).
                Über den Link kann bei Bedarf die Quelle in neuem Fenster geöffnet werden.  
                
                
            </p>

    
            <!-- <h3 class="chapter-title chapter-title-h3" id="erfassung_musikstueck_verwendungszweck">Musikstück: Verwendungszwecke</h3>    -->



	<h2 class="chapter-title chapter-title-h2" id="erfassung_musikstueck">Satz</h2>
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
            <p> XXX </p>

        <h3 class="chapter-title chapter-title-h3" id="erfassung_satz_schueler">Satz: Schüler</h3>
    
                <p>Im Unterformular werden die mit dem Satz verknüpften Schüler angezeigt.</p>

                <p>Über "hinzufügen" kann eine neue Verknüpfung zu einem Schüler erstellt werden, 
                    über "Schnell-Zuordnung" können mehrere Schüler in einem Arbeitsgang zugeordnet werden.</p>
                    
                <p>Die erstellten Verknüpfungen sind auch im <a href="#erfassung_schueler_noten">Schüler-Formular, Unterformular "Verknüpfte Noten"</a> sichtbar. </p>

                <p>Eigenschaften der Schüler-Satz - Verknüpfung: 
                    <ul>    
                            <li>Status (Auswahl aus den unter <a href="#erfassung_status">Stammdaten: Status</a> erfassten Einträgen). 
                                    Bei der "Schnell-Zuordnung" wird automatisch der Status mit der niedrigsten ID als Vorgabe gespeichert. 
                            </li>
                            <li>Datum von</li>
                            <li>Datum bis</li>
                            <li>Bemerkung</li>
                    </ul>
                    </p>
                                
        <h3 class="chapter-title chapter-title-h3" id="erfassung_satz_kopieren">Satz kopieren</h3>

            <p>Button "Satz kopieren": Die Sammlung inklusive  aller Eigenschaften und Untereinheiten 
                wird kopiert. Die Kopie wird im aktuellen Formular geöffnet. Am Zusatz  
                " (Kopie)" im Feld "Name" ist die Kopie erkennbar. 
                Im Seitenkopf erscheint ein Hinweis auf den Kopiervorgang (Neue ID, alte ID mit Link).
                Über den Link kann bei Bedarf die Quelle in neuem Fenster geöffnet werden.  
            </p>     


          
	<h2 class="chapter-title chapter-title-h2" id="erfassung_material">Material</h2>
		<h3 class="chapter-title chapter-title-h3" id="erfassung_material_sammlung">Material: Sammlung</h3>
			<p>Materialien können zu einer Sammlung, aber auch unabhängig von einer Sammlung angelegt werden</p>
			<p>Die Erfassung eines Materials zu einer Sammlung wird <a href="#erfassung_sammlung_kopieren">von der Sammlung aus</a> durchgeführt</p>
			<p>Falls ein Material separat angelegte wird, wird das Feld "Sammlung" nicht angezeigt und bleibt intern leer. </p>

		<h3 class="chapter-title chapter-title-h3" id="erfassung_material_materialtyp">Material: Materialtyp</h3>
			<p>XXX
		<h3 class="chapter-title chapter-title-h3" id="erfassung_material_schueler">Material: Schüler</h3>		

			<p>Im Unterformular werden die mit dem Material verknüpften Schüler angezeigt.</p>

			<p>Über "hinzufügen" kann eine neue Verknüpfung zu einem Schüler erstellt werden, 
				über "Schnell-Zuordnung" können mehrere Schüler in einem Arbeitsgang zugeordnet werden.</p>
				
			<p>Die erstellten Verknüpfungen sind auch im <a href="#erfassung_schueler_material">Schüler-Formular, Unterformular "Verknüpfte Materalien"</a> sichtbar. </p>

			<p>Eigenschaften der Schüler-Material - Verknüpfung: 
				<ul>    
						<li>Status (Auswahl aus den unter <a href="#erfassung_status">Stammdaten: Status</a> erfassten Einträgen). 
								Bei der "Schnell-Zuordnung" wird automatisch der Status mit der niedrigsten ID als Vorgabe gespeichert. 
						</li>
						<li>Datum von</li>
						<li>Datum bis</li>
						<li>Bemerkung</li>
				</ul>
				</p>
											

    <h2 class="chapter-title chapter-title-h2" id="erfassung_schueler">Schüler</h2>
        <h3 class="chapter-title chapter-title-h3" id="erfassung_schueler_aktiv">Schüler: Aktiv</h3>
            <p> Schnellinfo: Über das Feld "Aktiv" kann der Schüler durch entfernen des Hakens auf inaktiv gesetzt werden. 
                Übersicht: Zeigt Filter "Aktiv", sodass standardmäßig nur aktive Schüler gezeigt werden. Durch entfernen des Hakens schaltet der 
                Filter um und zeigt dann nur inaktive Schüler. 
                Bei der Anlage eines neuen Schülers ist das Feld standardmäßig auf Aktiv gesetzt. 
                Unter "Suche": Das Auswahlfeld "Schüler" zeigt nur aktive Schüler an.  

            </p>    
        <h3 class="chapter-title chapter-title-h3" id="erfassung_schueler_schwierigkeitsgrade">Schüler: Instrumente und Schwierigkeitsgrade</h3>
            <p>Optionen: </p>
            <ul>
                <li>Nur Instrument(e): Das Feld Schwierigkeitsgrad kann leer bleiben</li>
                <li>Instrument(e) und Schwierigkeitsgrad(e). Es können mehrere Schwierigkeitsgrade pro Instrument eingetragen werden</li>
            </ul>

        <h3 class="chapter-title chapter-title-h3" id="erfassung_schueler_noten">Schüler: Verknüpfte Noten</h3>
            <p> Im Unterformular werden die mit dem Schüler verknüpften Noten (Sammlungen/Musikstücke/Sätze) angezeigt. </p> 
                    <p> Die Verknüpfungen können im Unterformular bearbeitet werden, das hinzufügen neuer Verknüpfungen muss jedoch über 
                        über <a href="#erfassung_satz_schueler">das "Satz"-Formular / Unterformular "Schüler"</a> erfolgen 
                        (weitere Informationen zu Eigenschaften einer Verknüpfung siehe dort)</p>

        <h3 class="chapter-title chapter-title-h3" id="erfassung_schueler_material">Schüler: Verknüpfte Materialien</h3>

                <p> Im Unterformular werden die mit dem Schüler verknüpften Materialien angezeigt. </p> 
                    <p> Die Verknüpfungen können im Unterformular bearbeitet werden, das hinzufügen neuer Verknüpfungen muss jedoch über 
                        über <a href="#erfassung_material_schueler">das "Material"-Formular / Unterformular "Schüler"</a> erfolgen 
                        (weitere Informationen zu Eigenschaften einer Verknüpfung siehe dort)</p>

        <h3 class="chapter-title chapter-title-h3" id="erfassung_schueler_kopieren">Schüler kopieren</h3>
            <p>Die Daten eines Schüler werden inklusive Instrumente/Schwierigkeitsgrade sowie aller Material- und Satzverknüpfungen kopiert. </p>




	<h2 class="chapter-title chapter-title-h3" id="erfassung_stammdaten_besetzung">Stammdaten: Besetzung</h2>

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

    
	<h2 class="chapter-title chapter-title-h3" id="erfassung_besonderheiten">Stammdaten: Besonderheiten</h2>

    <p> Besonderheiten sind Kategorien, die vom Anwender eingerichtet werden können. 



        
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
         

	<h2 class="chapter-title chapter-title-h2" id="erfassung_status">Stammdaten: Status</h2>
        <!-- XXXX  -->


        <p>Die Status-Einträge können bei Zuordnung von 
                Schülern zu Sätzen 
                bzw. 
                Schülern zu Materialen 
                verwendet werden </p>

<h1 class="chapter-title chapter-title-h1" id="suche_noten">Suche: Allgemeine Erläuterungen</h1>



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

<h1 class="chapter-title chapter-title-h1" id="suche_noten">Suche Noten</h1>
	<h2 class="chapter-title chapter-title-h2" id="suche_ansicht">Ansichten</h2>
      
    <ul>
        <li><b>Sammlung: </b>
        Die Ergebnistabelle wird auf Sammlung-Ebene gruppiert (Eine Zeile pro Sammlung).
        Die Sortierung erfolgt nach Standort Name, Sammlung Name
        </li>

        <li><b>Sammlung Material: </b>
        Die Ergebnistabelle ist bei dieser Ansicht grundsätzlich auf Sammlungen mit enthaltenen Materialien beschränkt. 
        Die  Ergebnistabelle wird auf Sammlung-Ebene gruppiert (Eine Zeile pro Sammmlung). 
        Die Sortierung erfolgt nach Standort Name, Sammlung Name. 
        Materialen ohne Verbindung zu einer Sammlung werden nicht angezeigt. 
        </li>


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
            <!-- <li><b>Material: </b>
                 Die Ergebnistabelle zeigt Materialien sowie ggf. zugeordnete Schüler an.  
                Es werden sowohl frei erfasste als auch mit einer Sammlung verknüpfte Materalien angezeigt, in letzterem Fall wird 
                der Sammlung-Name mit angezeigt. Folgende Filter können verwendet werden: 
                <br> Such-Kategorien: Schüler, Standort
                <br> Such-Text: Durchsucht Material-Name, Material-Bemerkung, Sammlung-Name, Sammlung-Bemerkung 
            </li> -->



            </ul>




	<h2 class="chapter-title chapter-title-h2" id="suche_noten_text">Filter: Textsuche</h2>
    <p> Hinweis: Die Verwendung der Textsuche kann zu einer verzögerten Ergebnisanzeige führen! </p>
    <p> Folgende Felder werden durchsucht: XXX </p>

	<h2 class="chapter-title chapter-title-h2" id="suche_satz_schwierigkeitsgrad">Filter: Instrument / Schwierigkeitsgrad</h2>
    <p> Hinweise: Der Filter ist nur für die Sammlung-, Musikstück- und Satz-Ansichten wirksam.
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
  
<h1 class="chapter-title chapter-title-h1" id="suche_schueler">Suche Schüler</h1>
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
include('foot.php');
?>

