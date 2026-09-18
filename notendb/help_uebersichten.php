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

	<h2 class="chapter-title chapter-title-h1" id="uebersichten_besonderheiten">Übersicht Besonderheiten</h2>  

        <p>Spalten: </p>
            <ul>
                <li>ID	</li>
                <li>Besonderheit </li>
                <li>Besonderheit Typ </li>

            </ul>  

        <p>Suche / Filter: </p>
        
            <ul>
                <li>Besonderheit Typ</li>
                <li>Suchtext (Sucht in Besonderheit Name) (sucht nicht in Lookuptyp-Name!) </li>
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
                <li>Unterricht Dauer</li>
                <li>Geburtsdatum</li>
                <li>Verknüpfte Noten (Falls im Filter ein passender Status ausgewählt ist)</li>
                <li>Uebung Tage (Anzahl der Übungs-Tage)  </li>
                <li>Uebung zuletzt (Datum der neuesten Übung) </li>        
            </ul>  

        <p>Suche / Filter: </p>
        
            <ul>
                <li>Aktiv</li>
                <li>Status Satz Verknüpfung (+ Umkehrsuche)</li>
                <li>Übung Datum</li>
                <li>Unterricht Wochentag</li>
    

            </ul> 

	<h2 class="chapter-title chapter-title-h1" id="uebersichten_uebungen">Übersicht Übungen</h2>

        <p> Einschränkungen: Es werden werden nur die Übungen aktiver Schüler angezeigt. </p> 
                <p> Hinweis: Je nach Filtereinstellung werden verstärkte Zeilenrahmen angezeigt, 
                    die eine optische Gruppierung bieten (z.B. erscheint bei Filter nach Datum 
                    eine verstärkte Linie über der ersten Übung eines Schülers). 
                </p> 
        <p>Spalten: </p>
            <ul>
                <li>Schueler Name</li>
                <li>Übung Datum (bei Entwürfen leer) </li>
                <li>Schüler Reihenfolge </li>
                <li>Übung Reihenfolge (Bei Entwürfen leer)</li>
                <li>Uebung Inhalt</li>
                <li>Noten (Sammlung / Musikstück / Satz Name)</li>
                <li>Noten Bemerkung (Inhalte aus Musikstück / Satz Bemerkung) </li>
                <li>Besonderheiten (mit Übung verknüpfte Besonderheiten)</li>
                <li>Übung Bemerkung</li>
                <li>Übung Dauer</li>
                <li>Uebung Typ</li>
                <li>Bewertung (bei Enwürfen leer)</li>
                <li>ID</li>
             
            </ul>  

        <p>Suche / Filter: </p>

            <ul>
                <li>Datum (Standard-Einstellung: Heutiges Datum). 
                    <br>Hinweis: über den Beschriftungslink kann das Datum geöffnet werden)</li>
                <li>Schüler</li>
                <li>Übung Typ</li>
                <li>Bewertung</li>
                <li>Entwurf (Standard-Einstellung: nein)</li>
                <li>Suchtext. Durchsucht werden folgende Felder: 
                        Übung Name, Übung Bemerkung, Übung Typ Name, Sammlung Name / Bemerkung, 
                        Musikstück Name / Bemerkung, Satz Name / Bemerkung
            </li>

            </ul> 

        <p>Link "Neu einfügen": 
            <br> Einfügen einer neuen Übung für den im Filter ausgewählten Schüler.
            <br> Falls im Filter ein Datum ausgewählt ist, wird dieses Datum als Vorgabe für die neue Übung übernommen. 
                </p>
	
    <h2 class="chapter-title chapter-title-h1" id="uebersichten_uebungstage">Übersicht Übungstage</h2>

        <p> Einschränkungen: Es werden werden nur die Übungen aktiver Schüler angezeigt.</p> 

        <p> Hinweis: Je nach Filtereinstellung werden verstärkte Zeilenrahmen angezeigt, 
            die eine optische Gruppierung bieten (z.B. erscheint  
            eine verstärkte Linie über dem ersten Schüler / Datum, wenn nur nach Schuljahr gefiltert wird). 
        </p>             

        <p>Spalten: </p>
        <ul>
        <li>Schüler Name</li>
        <li>Schueler Bemerkung</li>
        <li>Datum</li>
        <li>Kalender Wochentag</li>
        <li>Übungstag Bemerkung</li>
        <li>Unterricht Reihenfolge</li>
        <li>Anzahl Übungen</li>
        <li>Summe Minuten</li>
        <li>Abweichung Dauer</li>
        <li>Übungen Inhalte (nur echte Übungen, keine Übungsentwürfe)</li>
        <li>Unterricht geplant</li>
        <li>Unterricht protokolliert</li>
        <li>Ferientag</li>
        <li>Feiertag</li>
        <li>Schuljahr</li>
        <li>Übungstag ID</li>
        </ul>

        <p>Suche / Filter: </p>
        
            <ul>
                <li>Datum (Standard-Einstellung: Heutiges Datum) (Hinweis: über den Beschriftungslink kann das Datum geöffnet werden)</li>
                <li>Schüler</li>
                <li>Schuljahr</li>
                <li>Geplant </li>
                <li>Protokolliert </li>
                <li>Suchtext (Durchsucht werden "Schüler Bemerkung" und "Übungstag Bemerkung") </li>

            </ul> 

        <p>Link "Neu erfassen": 
            <br> Einfügen einer neuen Übung für den im Filter ausgewählten Schüler. Sollte ein Datum ausgewählt sein, wird dieses für die neue Übung übernommen. </p>
                                
    <h2 class="chapter-title chapter-title-h1" id="uebersichten_bewertungen">Übersicht Bewertungen</h2>
            <p>Spalten: </p>
            <ul>       
                <li>ID</li>
                <li>Name</li>
            </ul>  
    <h2 class="chapter-title chapter-title-h1" id="uebersichten_uebungstypen">Übersicht Übungstypen</h2>
            <p>Spalten: </p>
            <ul>       
                <li>ID</li>
                <li>Name</li>
            </ul>  
    <h2 class="chapter-title chapter-title-h1" id="uebersichten_linktypen">Übersicht Linktypen</h2>
            <p>Spalten: </p>
            <ul>       
                <li>ID</li>
                <li>Name</li>
            </ul>  
    <h2 class="chapter-title chapter-title-h1" id="uebersichten_status">Übersicht Status-Ausprägungen</h2>
            <p>Spalten: </p>
            <ul>       
                <li>ID</li>
                <li>Name</li>
            </ul> 

    <h2 class="chapter-title chapter-title-h1" id="uebersichten_abfragetypen">Übersicht Abfrage-Typen</h2>
            <p>Spalten: </p>
            <ul>       
                <li>ID</li>
                <li>Name</li>
            </ul>  
    <h2 class="chapter-title chapter-title-h1" id="uebersichten_abfragen">Übersicht Abfragen</h2>
            <p>Spalten: </p>
            <ul>       
                <li>ID</li>
                <li>Name</li>
                <li>Beschreibung</li>
                <li>Abfragetyp</li>
            </ul>  
            <p>Filter: Abfragetyp </p>
            
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
	
    <h2 class="chapter-title chapter-title-h1" id="uebersichten_standorte">Übersicht Standorte</h2>

        <p>Spalten: </p>
            <ul>       
                <li>ID</li>
                <li>Name</li>
            </ul>  


    <h2 class="chapter-title chapter-title-h1" id="uebersichten_verlage">Übersicht Verlage</h2>

        <p>Spalten: </p>
            <ul>       
                <li>ID</li>
                <li>Name</li>
            </ul>
            
    <h2 class="chapter-title chapter-title-h1" id="uebersichten_besetzungen">Übersicht Besetzungen</h2>

        <p>Spalten: </p>
            <ul>       
                <li>ID</li>
                <li>Name</li>
            </ul>
            
    <h2 class="chapter-title chapter-title-h1" id="uebersichten_gattungen">Übersicht Gattungen</h2>

        <p>Spalten: </p>
            <ul>       
                <li>ID</li>
                <li>Name</li>
            </ul>

    <h2 class="chapter-title chapter-title-h1" id="uebersichten_epochen">Übersicht Epochen</h2>

        <p>Spalten: </p>
            <ul>       
                <li>ID</li>
                <li>Name</li>
            </ul>
            
    <h2 class="chapter-title chapter-title-h1" id="uebersichten_epochen">Übersicht Material-Typen</h2>

        <p>Spalten: </p>
            <ul>       
                <li>ID</li>
                <li>Name</li>
            </ul>
            
    <h2 class="chapter-title chapter-title-h1" id="uebersichten_komponisten">Übersicht Komponisten</h2>


        <p>Spalten: </p>
            <ul>       
                <li>ID</li>
                <li>Vorname</li>
                <li>Nachname</li>
                <li>Geburtsjahr</li>
                <li>Sterbejahr</li>
                <li>Bemerkung</li>
            </ul>
            
                        
       <p>Suche / Filter: </p>
        
            <ul>
                <li>Suchtext (Suche in Vorname, Nachname, Geburtsjahr, Sterbejahr)</li>
            </ul> 
    <h2 class="chapter-title chapter-title-h1" id="uebersichten_schwierigkeitsgrade">Übersicht Schwierigkeitsgrade</h2>

        <p>Spalten: </p>
            <ul>       
                <li>ID</li>
                <li>Name</li>
            </ul>
                        
    <h2 class="chapter-title chapter-title-h1" id="uebersichten_instrumente">Übersicht Instrumente</h2>

        <p>Spalten: </p>
            <ul>       
                <li>ID</li>
                <li>Name</li>
            </ul>
                        
    <h2 class="chapter-title chapter-title-h1" id="uebersichten_erprobt">Übersicht Erprobt</h2>

        <p>Spalten: </p>
            <ul>       
                <li>ID</li>
                <li>Name</li>
            </ul>
                        
        
    <h2 class="chapter-title chapter-title-h1" id="uebersichten_kalender">Übersicht Kalender</h2>
            <p>Spalten: </p>
            <ul>       
                <li>ID</li>
                <li>Datum</li>
                <li>Wochentag</li>
                <li>Kalenderwoche</li>
                <li>Unterrichtstag geplant (Nein=Leer, Ja = X) </li>
                <li>Unterrichtstag protokolliert (Nein=Leer, Ja = X) </li>
            </ul>  


    <h2 class="chapter-title chapter-title-h1" id="uebersichten_schuljahre">Übersicht Schuljahre</h2>
            <p>Spalten: </p>
            <ul>       
                <li>ID</li>
                <li>Bezeichnung</li>
                <li>Datum von</li>
                <li>Datum bis</li>
                <li>Ferien (Auflistung) </li>
                <li>Feiertage (Auflistung) </li>
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

