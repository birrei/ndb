
<?php 
include_once('head_raw.php');
include_once("classes/class.musikstueck.php");

$musikstueck = new Musikstueck(); 
$musikstueck->ID = $_GET["MusikstueckID"]; 
$musikstueck->print_table_saetze(); 

// echo '<p> <a href="edit_satz.php?MusikstueckID='.$_GET["MusikstueckID"].'&option=insert&title=Satz" target="_blank">Satz hinzufügen</a></p>'; 
// echo '<p> <a href="edit_musikstueck_list_saetze.php?MusikstueckID='.$_GET["MusikstueckID"].'">Aktualisieren</a></p>'; 
 
include_once('foot_raw.php');

?>
