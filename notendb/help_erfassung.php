<?php 
$PageTitle='Hilfe';  
include_once('head.php');
?>

<p class="doc"><b>Kapitel:</b> </p>

<div id="inhaltsverzeichnis"></div>


<div class="body-doc"> 
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



	<h2 class="chapter-title chapter-title-h2" id="erfassung_satz">Satz</h2>
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

        <h3 class="chapter-title chapter-title-h3" id="erfassung_satz_schwierigkeitsgrad">Satz: Instrument/Schwierigkeitsgrad</h3>
        
        

        <p>XXX</p>

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


         
		<script src="js_toc.js"></script>


<?php 
include_once('foot.php');
?>

