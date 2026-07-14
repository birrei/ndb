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

        <p>Spalten: </p>
            <ul>
                <li>Schueler Name</li>
                <li>Übung Datum</li>
                <li>Schüler Reihenfolge </li>
                <li>Übung Reihenfolge </li>
                <li>Uebung Inhalt</li>
                <li>Noten (Sammlung / Musikstück / Satz Name)</li>
                <li>Noten Bemerkung (Inhalte aus Musikstück / Satz Bemerkung) </li>
                <li>Besonderheiten (mit Übung verknüpfte Besonderheiten)</li>
                <li>Übung Bemerkung</li>
                <li>Übung Dauer</li>
                <li>Uebung Typ</li>
                <li>Bewertung</li>
                <li>Unterrichtstag Geplant (Nein=Leer, Ja = X) </li>
                <li>ID</li>
             
            </ul>  

        <p>Suche / Filter: </p>
        
            <ul>
                <li>Datum (Standard-Einstellung: Heutiges Datum) (Hinweis: über den Beschriftungslink kann das Datum geöffnet werden)</li>
                <li>Schüler</li>
                <li>Übung Typ</li>
                <li>Bewertung</li>
                <li>Suchtext. Durchsucht werden folgende Felder: 
                        Übung Name, Übung Bemerkung, Übung Typ Name, Sammlung Name / Bemerkung, 
                        Musikstück Name / Bemerkung, Satz Name / Bemerkung
                <li>Geplant (Unterrichtsplanung für den Tag abgeschlossen: ja / nein)</li>    
            </li>

            </ul> 

        <p>Link "Neu einfügen": 
            <br> Einfügen einer neuen Übung für den im Filter ausgewählten Schüler.
            <br> Falls im Filter ein Datum ausgewählt ist, wird dieses Datum als Vorgabe für die neue Übung übernommen. 
                </p>
	<h2 class="chapter-title chapter-title-h1" id="uebersichten_uebungstage">Übersicht Übungstage</h2>

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
        <li>Übungen Inhalte</li>
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
                <li>Suchtext (Durchsucht werden "Schüler Bemerkung" und "Übungstag Bemerkung") 
            </li>

            </ul> 

        <p>Link "Neu erfassen": 
            <br> Einfügen einer neuen Übung für den im Filter ausgewählten Schüler.</p>
                                
    <h2 class="chapter-title chapter-title-h1" id="uebersichten_bewertungen">Übersicht Bewertungen</h2>
            <p>Spalten: </p>
            <ul>       
                <li>ID</li>
                <li>Name</li>
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


    <h2 class="chapter-title chapter-title-h1" id="uebersichten_schueler-kalender-vorlage">Vorlage Übungstage ("Schüler Plan-Kalender")</h2>
        <p>
            Die Übersicht dient der - optionalen - Kontrolle vor dem XXXX Einlesen der Schüler-spezifischen Übungstage. 
            Die Übersicht zeigt an, ob der Unterrichts-Tag des Schülers für die Übungstage verwendbar ist (Eintrag = 1) oder nicht (Eintrag = 0). 
            Er ist dann nicht verwendbar, wenn er in eine Ferienzeit oder auf einen Feiertag. 
            Für das spätere Einlesen in die Übungstage werden die Zeilen mit "Eintrag = 1" verwendet. 
            
            
            <br><br>Die Übersicht ist ein Abfrage auf Grundlage folgender Daten: 
            <br>* Schüler > "Unterricht Wochentag" 
            <br>* Schuljahr 
            <br>* Ferienzeiten
            <br>* Feiertage
            
            <br> <br> 
   

        </p>

        <p>Spalten: </p>
            <ul>       
                <li>Schueler </li>
                <li>Datum</li>
                <li>Wochentag (= Unterrichts- Wochentag des Schülers)</li>
                <li>Schuljahr</li>
                <li>Eintrag (1=Ja, 0 = nein)   </li>
                <li>Nicht-Eintrag Ausschlussgrund (Ferien, Feiertag)</li>
                

            </ul>  



        <p>Filter: </p>
            <ul>       
                <li>Schuljahr</li>
                <li>Schüler </li>
                <li>Eintrag</li>
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

