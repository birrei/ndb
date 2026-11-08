<?php 
    $PageTitle='Hilfe Suche - Beispiele';  
    include_once('head.php');
?>

<p class="doc-header"><b>FAQ Kapitel:</b> </p>

<div class="doc-toc" id="inhaltsverzeichnis"></div>

<div class="doc-body"> 


<h1 class="chapter-title chapter-title-h1" id="suche">Suche</h1>
<!-- <h1 class="chapter-title chapter-title-h1" id="suche_beispiele">Übungs-Beispiele zur Suche</h1> -->
<!-- <p> Die folgenden Beispiele stammen aus dem Datenbestand des Initial-Projektes. Die verwendeten Suchbegriffe können in anderen Datenbeständen ggf. abweichen.  </p>  -->


<h2 class="chapter-title chapter-title-h2" id="suche-besonderheiten-kombi">Wie verwende ich Mehrfach-Auswahl / Einschluss-Suche / Ausschluss-Suche? (Beispiele?) </h2>
    <p> Annahme: Es gibt eine Besonderheiten-Kategorie "Notenwerte" und dort die Einträge "Viertel" und "Achtel"
    <p> Fragen: 
    <ol>
        <li>Suche Noten, wo Notenwert "Achtel" vorkommt  </li>
        <li>Suche Noten, wo NUR Notenwert "Achtel" vorkommt  (andere "Notenwerte" dürfen nicht vorkommen)</li>
        <li>Suche Noten, wo Notenwerte "Achtel" ODER "Viertel" vorkommen</li>
        <li>Suche Noten, wo Notenwerte "Achtel" UND "Viertel" vorkommen</li>
        <li>Suche Noten, wo NUR Notenwerte "Achtel" ODER "Viertel" vorkommen</li>
        <li>Suche Noten, wo NUR Notenwerte "Achtel" UND "Viertel" vorkommen</li> 
    </ol>
    </p>

    <p> Antworten: 
    <ol>
        <li>Auswahl "Achtel"</li>
        <li>Auswahl "Achtel" mit [Einschluss-Suche]</li>
        <li>Auswahl "Achtel" und "Viertel" </li>
        <li>Auswahl "Achtel" und "Viertel" mit [Einschluss-Suche]</li>
        <li>Auswahl "Achtel" und "Viertel" mit [Ausschluss-Suche]</li>
        <li>Auswahl "Achtel" und "Viertel" mit [Einschluss-Suche], [Ausschluss-Suche]</li>

    </ol>
    </p> 

   <h2 class="chapter-title chapter-title-h2" id="suche-trick-browsersuche">Ich will nach einer Besonderheit filtern, weiß aber grade nicht auswändig in welchem Auswahlkästchen die drin steckt?</h2>
    <p>Annahme: Du weisst den Namen der Besonderheit, hast aber vergessen, zu welchem Typ die Besonderheit gehört. 
        Trick: Nutze die Browsersuche (Aufruf: STRG + F) 
    </p>
    
    <p></p>

<h1 class="chapter-title chapter-title-h1" id="uebersichten">Übersichten</h1>

  <h2 class="chapter-title chapter-title-h2" id="uebersichten_tage_nicht_protokolliert">Wie kann ich noch nicht protokollierte Übungstage finden?</h2>
        
    <p>Gehe zu <a href="show_table4.php?ansicht=uebungstage">Übersicht Übungstage</a>.
        <br> - Filter: Schuljahr (bzw. voreingestelltes Schuljahr belassen)
        <br> - Filter: Auswahl "Protokolliert" = "nein" 
        <br> - Alle anderen Filter entfernen 
    </p> 
    
<!-- 
XXXX 

  <h2 class="chapter-title chapter-title-h2" id="suche-instrumente">Übung: Auswahl Besetzung / Instrument</h2>
    <p> Möglichkeiten am Beispiel Besetzung "Violine" und "Klavier"</p>
    
  <p> Annahme: unter "Besetzungen" können sowohl Einzel-Instrumente als auch Instrumente-Kombis erfasst sein. 

</p>
        XXX Instrumente können über  2 Auswahlfelder Weisen gesucht werden: 
        <ul>
            <li> Auswahl "Musikstück" > "Besetzung(en)"  </li>
            <li> Auswahl "Satz" > "Instrument/Schwierigkeitsgrad" </li>
        </ul>
    </p>


 -->
            
    <!-- 
    <h2 class="chapter-title chapter-title-h2" id="suche-schueler-alle-noten">Verwendung von Ansichten: Suche Schüler mit zugeordneten Noten</h2>
    <p> 1. Zeige zugeordnete Noten für einen Schüler mit Status "Idee"</p>  
    <p> 2. Zeige zugeordnete Noten für einen Schüler mit Besonderheit "Tonleiter" </p>  
    <p>! probiere verschiedene Ansichten, welche eignen sich? </p> 
     -->

    <!-- <ul>
        <li>Ansicht: "Sammlung, Musikstück, Satz " </li>
        <li>Abschnitt "Schüler" -> Auswahl "Schüler" (z.B. Anna-Luna) </li>
        <li>Abschnitt "Schüler" -> Auswahl "Status" (z.B. "01 - Idee") </li>
        <li>Abschnitt "Besonderheiten" -> Auswahl in Besonderheit "Übung sonst" -> "Tonleiter"  </li>
    </ul> -->





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

