<?php 
$PageTitle='Hilfe Suche - Beispiele';  
include_once('head.php');
?>

<p class="doc"><b>Kapitel:</b> </p>

<div class="body-doc-toc" id="inhaltsverzeichnis"></div>

<div class="body-doc"> 

<!-- <h1 class="chapter-title chapter-title-h1" id="suche_beispiele">Übungs-Beispiele zur Suche</h1> -->
    <!-- <p> Die folgenden Beispiele stammen aus dem Datenbestand des Initial-Projektes. Die verwendeten Suchbegriffe können in anderen Datenbeständen ggf. abweichen.  </p>  -->

    <h2 class="chapter-title chapter-title-h2" id="suche-besonderheiten-kombi">Suche Noten & Material mit bestimmten Besonderheiten</h2>

    <ul>
        <li>Suche Noten / Materialien, wo  Notenwert  "Achtel" vorkommt </li>
        <li>Suche Noten / Materialien, wo NUR Notenwert "Achtel" vorkommt  (andere Notenwerte dürfen nicht vorkommen)</li>
        <li>Suche Noten / Materialien, wo Notenwerte "Achtel" ODER "Viertel" vorkommen</li>
        <li>Suche Noten / Materialien, wo Notenwerte "Achtel" UND "Viertel" vorkommen</li>
        <li>Suche Noten / Materialien, wo NUR Notenwerte "Achtel" ODER "Viertel" vorkommen</li>
        <li>Suche Noten / Materialien, wo NUR Notenwerte "Achtel" UND "Viertel" vorkommen</li>

    </ul>


    <h2 class="chapter-title chapter-title-h2" id="suche-schueler-alle-noten">Suche Schüler mit verknüpften Noten- / Materialien </h2>
    <p> Zeige alle Noten / Materialien für einen Schüler mit Status "Idee" und Besonderheit "Übung Sonst" = "Tonleiter"</p>  
    <ul>
        <li>Ansicht: "Sammlung erweitert 2" </li>
        <li>Abschnitt "Schüler" -> Auswahl "Schüler" (z.B. Anna-Luna) </li>
        <li>Abschnitt "Schüler" -> Auswahl "Status" (z.B. "01 - Idee") </li>
        <li>Abschnitt "Besonderheiten" -> Auswahl in Besonderheit "Übung sonst" -> "Tonleiter"  </li>
    </ul>





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

