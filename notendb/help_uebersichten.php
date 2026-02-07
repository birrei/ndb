<?php 
$PageTitle='Hilfe Übersichten';  
include_once('head.php');
?>

<p class="doc-header"><b>Übersichten Kapitel:</b> </p>

<div class="doc-toc" id="inhaltsverzeichnis"></div>

<div class="doc-body"> 


	<h2 class="chapter-title chapter-title-h1" id="uebersichten_sammlungen">Übersicht Sammlungen</h2>  

        <p>Spalten: </p>
            <ul>
                <li>ID	</li>
                <li>Name</li>
                <li>Standorte</li>
                <li>Verlag</li>
                <li>Bemerkung</li>
                <li>Besonderheiten</li>
                <li>Vollständig erfasst</li>
            </ul>  

        <p>Suche / Filter: </p>
        
            <ul>
                <li>Standort</li>
                <li>Unvollständig erfasst (Sammlungen, wo die Eigenschaft "Vollständig erfasst" nicht gesetzt ist) </li>
                <li>Suchtext (Suche in Sammlung Name, Sammlung Bemerkung, Verlag, Sammlung Besonderheiten) </li>
            </ul> 

	<h2 class="chapter-title chapter-title-h1" id="uebersichten_schueler">Übersicht Schüler</h2>

        <p>Spalten: </p>
            <ul>
                <li>ID</li>
                <li>Name	</li>
                <li>Bemerkung	</li>
                <li>Instrumente	(Instrumente mit Schwierigkeitsgraden) </li>
                <li>Unterricht Wochentag</li>
                <li>Unterricht Tag Reihenfolge</li>
                <li>Unterricht Tag Reihenfolge</li>
                <li>Unterricht Dauer</li>
                <li>Geburtsdatum</li>
                <li>Verknüpfte Noten (Falls im Filter ein passender Status ausgewählt ist)</li>
                <li>Uebung Tage (Anzahl der Übungs-Tage)  </li>
                <li>Uebung zuletzt (Datum der neuesten Übung) </li>        
            </ul>  

        <p>Suche / Filter: </p>
        
            <ul>
                <li>Standort</li>
                <li>Unvollständig erfasst (Sammlungen ohne Eigenschaft "Vollständig erfasst") </li>
                <li>Suchtext (Suche in Sammlung Name, Sammlung Bemerkung, Verlag, Sammlung Besonderheiten) </li>
            </ul> 

	<h2 class="chapter-title chapter-title-h1" id="uebersichten_uebungen">Übersicht Übungen</h2>

        <p>Spalten: </p>
            <ul>
                <li>Schueler Name</li>
                <li>Übung Datum</li>
                <li>Reihenfolge (= Schüler Unterrichtstag Reihenfolge) </li>
                <li>Uebung Inhalt</li>
                <li>Noten (Sammlung / Musikstück / Satz Name)</li>
                <li>Noten Bemerkung (Inhalte aus Musikstück / Satz Bemerkung) </li>
                <li>Besonderheiten (mit Übung verknüpfte Besonderheiten)</li>
                <li>Übung Bemerkung</li>
                <li>Übung Dauer</li>
                <li>Uebung Typ</li>
                <li>ID</li>
             
            </ul>  

        <p>Suche / Filter: </p>
        
            <ul>
                <li>Datum (Vorgabe beim öffnen der Seite: Heutiges Datum)</li>
                <li>Suchtext. Durchsucht werden folgende Felder: 
                    <br>Übung Name 
                    <br>Übung Bemerkung 
                    <br>Übung Typ Name 
                    <br>Sammlung Name / Bemerkung
                    <br>Musikstück Name / Bemerkung
                    <br>Satz Name / Bemerkung
            </li>

            </ul> 



	<h2 class="chapter-title chapter-title-h1" id="uebersichten_uebungen-datum">Übersicht Übungen / Datum</h2>

    <!-- 			Inhalte -->
        <p>Spalten: </p>
            <ul>
                <li>Schueler Name</li>
                <li>Übung Datum</li>
                <li>Untericht Reihenfolge </li>
                <li>Anzahl Übungen </li>
                <li>Summe Minuten </li>
                <li>Abweichung Dauer (= Abweichung  Summe  Minuten - Schüler Unterrichtsdauer. 
                    <br>Negativer Betrag: Übungen Summe Minuten zu gering. 
                    <br>Positiver Betrag: Übungen Summe Minuten zu hoch) </li>
                <li>Inhalte </li>
             
            </ul>  

        <p>Suche / Filter: </p>
        
            <ul>
                <li>Datum (Vorgabe beim öffnen der Seite: Heutiges Datum)</li>
            </li>

            </ul> 



	<h2 class="chapter-title chapter-title-h1" id="uebersichten_verwendungszwecke">Übersicht Verwendungszwecke</h2>

        <p>Spalten: </p>
            <ul>       
                <li>ID</li>
                <li>Name</li>
            </ul>  

        <p>Zusatzspalten (Option "Berechnungen anzeigen" aktiviert) </p>
          <ul>       
                <li>Anzahl Sammlungen</li>
                <li>Anzahl Musikstücke</li>
                <li>Anzahl Sätze</li>
                <li>Summe Spieldauer </li>
            </ul>  

<hr />

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


</div>

<script src="js_toc.js"></script>
    <link rel='stylesheet' type='text/css' href='style.css'/>

<?php 
include_once('foot.php');
?>

