<?php 
$PageTitle='Hilfe Suche';  
include_once('head.php');
?>

<p class="doc-header"><b>Kapitel:</b> </p>

<div class="doc-toc" id="inhaltsverzeichnis"></div>

<div class="doc-body"> 

<h1 class="chapter-title chapter-title-h1" id="suche_ansichten">Auswahl und Suchlogiken (mit Beispielen) </h1>

    <h2 class="chapter-title chapter-title-h2" id="suche_info_filter_suchlogik_1_1">Auswahl eine Kategorie, eine Eigenschaft</h2>
    
        <p>Beispiel Suche (ohne Zusatz-Option): Besetzung "Violine und Klavier": Findet alle Musikstücke, bei denen diese Besetzung zugordnet ist </p>
    
        <p>Beispiel Suche mit "Einschluss-Suche": 
            (kein Unterschied gegenüber Suche ohne Zusatz-Option)
        </p>
        <p>Beispiel Suche mit "Ausschluss-Suche": Besetzung "Violine und Klavier" + "Ausschluss-Suche": 
            findet alle Musikstücke, bei denen nur diese Besetzung zugordnet ist ("Ausschluss-Suche" = andere Besetzungen werden ausgeschlossen)
        </p>

	<h2 class="chapter-title chapter-title-h2" id="suche_info_filter_suchlogik_1_2">Auswahl eine Kategorie, mehrere Eigenschaften</h2>
        <p> Beispiel Suche (ohne Zusatz-Option): Besetzungen "Violine und Klavier", "Violine und Cembalo": 
            Findet alle Musikstücke, denen mindestens eine der gewählten Besetzungen zugordnet ist 
            (also "Violine und Klavier" UND/ODER"Violine und Cembalo") 
        </p>

        <p>Beispiel Suche mit "Einschluss-Suche": Besetzung "Violine und Klavier", "Violine und Cembalo" + "Einschluss-Suche": 
            findet alle Musikstücke, denen genau diese beiden Besetzungen zugordnet sind 
            (also "Violine und Klavier" UND "Violine und Cembalo") 

        </p>
 
        <p>Beispiel Suche mit "Ausschluss-Suche": Besetzung "Violine und Klavier", "Violine und Cembalo" + "Ausschluss-Suche": 
            findet alle Musikstücke, denen mindestens eine der gewählten Besetzungen zugordnet ist 
            (also "Violine und Klavier" UND/ODER "Violine und Cembalo") sowie keine weiteren Besetzungen zugordnet sind.  
        </p>
        <p>Beispiel Suche mit "Einschluss-Suche" + "Ausschluss-Suche" : Besetzung "Violine und Klavier", "Violine und Cembalo" + "Einschluss-Suche" + "Ausschluss-Suche": 
            findet alle Musikstücke, denen nur genau diese beiden Besetzungen 
            (also "Violine und Klavier" UND "Violine und Cembalo") sowie keine weiteren Besetzungen zugordnet sind.  
        </p>

	<!-- <h2 class="chapter-title chapter-title-h2" id="suche_info_filter_suchlogik_2_1">Auswahl mehrerer Kategorien</h2>

        <p> Beispiel-Suche: 
            <br />Komponist: "Mozart" 
            <br />Besetzung: "Violine" 
            <br />Verwendungszwecke: "Hochzeit",  "Fest"
        </p> 
        
        <p>Findet alle Musikstücke </p>
            <p>XXXX</p> -->






    <hr> 

<!-- 
    <p> <b>Beispiele (Praxisfall: "Satz Besonderheiten" > "Übung Notenwerte"): </b></p>

    <p> Suche nach einer Eigenschaft (Hier: Notenwert "Achtel"): 

        <ul> 
            <li>    Finde Sätze, bei denen der Notenwert "Achtel" vorkommt: Standard-Suche, ohne Zusatz-Option bzw. mit Zusatzoption "Einschluss-Suche" (kein Unterschied)
                        </li> 
            <li>    Finde Sätze, bei denen NUR Notenwert "Achtel" vorkommt: Standard-Suche mit Option "Ausschluss-Suche"
            </li> 
        </ul>



    </p> -->

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


<?php 
include_once('foot.php');
?>

