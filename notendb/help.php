<?php 
include('head.php');
?>

<h2>Suche</h2> 
<p> <a href="search_musikstueck.php" target="_blank">Suche</a> </p>

<h3>Auswahlbox mit Mehrfach-auswahl</h3>
<p>Auswahl mehrerer Kategorie-Einträge: während der Auswahl STRG-Taste bzw. SHIFT-Taste gedrückt halten </p> 

<p> Hinweis zur Suchlogik: 
<br />Filtereinträge innerhalb einer Kategorie (innerhalb einer Auswahlbox) werden per ODER verknüpft. 
<br />Die Kombination von Kategorien erfolgt über UND-Verknüpfung. 

<br />Beispiel:
    <br /> "Violine" ODER "Violine und Klavier" (2 Einträge in Auswahlbox markiert)
    <br/> UND 
    <br />Verwendungszweck: "Hochzeit" ODER "Fest"


<?php 
include('foot.php');
?>

