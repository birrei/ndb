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
                <li>Unterrichtstag Geplant (Nein=Leer, Ja = X) </li>
                <li>ID</li>
             
            </ul>  

        <p>Suche / Filter: </p>
        
            <ul>
                <li>Datum (Standard-Einstellung: Heutiges Datum) (Hinweis: über den Beschriftungslink kann das Datum geöffnet werden)</li>
                <li>Schüler</li>
                <li>Übung Typ</li>
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
                

	<h2 class="chapter-title chapter-title-h1" id="uebersichten_uebungen-datum">Übersicht Übungstage</h2>

        <p>Spalten: </p>
        <ul>
         <li>Unterricht Plandatum</li>                
            <li>Schueler Name</li>
            <li>Unterricht Reihenfolge</li>
            <li>Anzahl Übungen </li>
            <li>Summe Minuten </li>
            <li>Abweichung Dauer (= Abweichung  Summe  Minuten - Schüler Unterrichtsdauer. 
                <br>Negativer Betrag: Übungen Summe Minuten zu gering. 
                <br>Positiver Betrag: Übungen Summe Minuten zu hoch) </li>
            <li>Inhalte </li>
            <li>Unterrichtstag Geplant (Nein=Leer, Ja = X) </li>           
             
        </ul>  

       <p>Sortierung: 1. Unterricht Plandatum (abwärts), 2. Unterricht Reihenfolge (aufwärts)</p>            

        <p>Suche / Filter: </p>
        
            <ul>
                <li>(*) Datum (= Kalender-Datum; Vorgabe beim öffnen der Seite: Heutiges Datum)</li>
                <li>(*) Datum bis (= Kalender-Datum; Vorgabe beim öffnen der Seite: leer)</li>
                <li>Schüler</li>
                <li>Unterricht Wochentag</li>
                <li>Geplant (Unterrichtsplanung für den Tag abgeschlossen: ja / nein)</li>                  
            </li>

            </ul> 

        <p> 
            (*) Filter Varianten:
                <br>* Ein bestimmtes Datum auswählen: Auswahl "Datum"
                <br>* Einem bestimmten Zeitraum auswählen: Auswahl "Datum" (= Datum von) und "Datum bis"
                <br>* Zeitraum von 6 Monaten bis zu einem bestimmten Datum auswählen: Auswahl "Datum bis"
            <br>
                <br>Hinweis: Es ist nicht möglich beide Datum-Filter zu leeren, 
                    um den Aufruf des kompletten hinterlegten Kalenderzeitraums zu erreichen. 
                    Werden beide Filter gelöscht, springt die Anzeige auf die Vorgabe-Einstellung (aktuelles Datum) zurück. 
        
            </p>




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
            </ul>  
            <p>XXX Hinweis: die Basisdaten wurden automatisch befüllt ... </p>

    <h2 class="chapter-title chapter-title-h1" id="uebersichten_ferien">Übersicht Ferientage</h2>
            <p>Spalten: </p>
            <ul>       
                <li>ID</li>
                <li>Bezeichnung</li>
                <li>Datum von</li>
                <li>Datum bis</li>
                <li>Schuljahr</li>
                <li>Bundesland</li>
            </ul>  

           <p>Filter: </p>
            <ul>       
                <li>Schuljahr (Standardeinstellung: Aktuelles Schuljahr)</li>
            </ul> 
            
            <p>XXX Hinweis: die Basisdaten wurden automatisch befüllt ... </p>            

    <h2 class="chapter-title chapter-title-h1" id="uebersichten_feiertage">Übersicht Feiertage</h2>
            <p>Spalten: </p>
            <ul>       
                <li>ID</li>
                <li>Bezeichnung</li>
                <li>Datum</li>
                <li>Schuljahr</li>
                <li>Bundesland</li>                
            </ul>  

           <p>Filter: </p>
            <ul>       
                <li>Schuljahr (Standardeinstellung: Aktuelles Schuljahr)</li>
            </ul> 
          
            <p>XXX Hinweis: die Basisdaten wurden automatisch befüllt ... </p>    
    <h2 class="chapter-title chapter-title-h1" id="uebersichten_schueler-kalender-vorlage">Vorlage Schüler-Kalender (Abfrage)</h2>
        <p>Die Abfrage verbindet die Tabellen "Schüler", "Kalender", "Schuljahre"", "Ferientage" und "Feiertage". 
            Sie dient als Quelle zur intialen Befüllung des "SChülerkalenders" (XXXX Hinweis einfügen): Hierfür werden die Zeilem mit Eintrag = 1 verwendet. 
        </p>
        <p>Spalten: </p>
            <ul>       
                <li>Schueler ID</li>
                <li>Schueler Name</li>
                <li>Datum</li>
                <li>Wochentag</li>
                <li>Ferientag</li>
                <li>Feiertag</li>
                <li>Schuljahr</li>
                <li>Unterrichtstag Geplant (Nein=Leer, Ja = X)</li>
                <li>Eintrag (1=Ja, 0 = nein) (*)   </li>
                <li>Quelle (**) </li>

            </ul>  
            <p>(*) Eintrag in Schülerkalender geplant, Datum verwendbar. Regeln: 
                <br>Datum wird übernommen, wenn schon "Übungen" erfasst wurden. 
                <br>Falls keine Übungen erfasst wurden: Datum wird übernommen, wenn kein Ferientag und kein Feiertag vorliegt.   

            </p>
            <p>(**) Es gibt 2 mögliche Quellen: 
                <br>1) "Plankalender aus Schüler-Wochentag". Verknüpfung: Kalender Wochentag = Schüler Wochentag).  
                <br>2) "Erfasste Unterrichte (Übungen, Verknüpfung: Kalender Datum = Übung Datum), sofern diese ausserhalb 
                  des für den Schüler üblichen Wochentags erfasst wurden.  
            </p>
            <!-- 
            	

             	
             	
             
             	
             	
             	
             
             Anzahl_Uebungen	Info -->


            <p>


            </p>



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

