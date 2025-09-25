<?php 
$PageTitle='Hilfe Suche - Beispiele';  
include_once('head.php');
?>

<p class="doc"><b>Kapitel:</b> </p>

<div class="body-doc-toc" id="inhaltsverzeichnis"></div>

<div class="body-doc"> 

<!-- <h1 class="chapter-title chapter-title-h1" id="suche_beispiele">Übungs-Beispiele zur Suche</h1> -->
    <!-- <p> Die folgenden Beispiele stammen aus dem Datenbestand des Initial-Projektes. Die verwendeten Suchbegriffe können in anderen Datenbeständen ggf. abweichen.  </p>  -->

    <h2 class="chapter-title chapter-title-h2" id="suche-besonderheiten-kombi">Übung Mehrfach-Auswahl / Einschluss-Suche / Ausschluss-Suche </h2>
    <p> Annahme: Es gibt eine Besonderheiten-Kategorie "Notenwerte" und dort die Einträge "Viertel" und "Achtel"

    <p> Suche Aufgaben: 
    <ol>
        <li>Suche Noten, wo Notenwert  "Achtel" vorkommt  </li>
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
            
    <h2 class="chapter-title chapter-title-h2" id="suche-schueler-alle-noten">Verwendung von Ansichten: Suche Schüler mit zugeordneten Noten</h2>
    <p> 1. Zeige zugeordnete Noten für einen Schüler mit Status "Idee"</p>  
    <p> 2. Zeige zugeordnete Noten für einen Schüler mit Besonderheit "Tonleiter" </p>  

    <p>! probiere verschiedene Ansichten, welche eignen sich? </p> 

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

