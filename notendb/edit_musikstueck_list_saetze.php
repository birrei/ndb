
<?php 
include('head_raw.php');
include("cl_musikstueck.php");

$musikstueck = new Musikstueck(); 
$musikstueck->ID = $_GET["MusikstueckID"]; 
$musikstueck->print_table_saetze(); 

echo '<p> <a href="edit_satz.php?MusikstueckID='.$_GET["MusikstueckID"].'&option=insert" target="_blank">Satz hinzufügen</a></p>'; 
echo '<p> <a href="edit_musikstueck_list_saetze.php?MusikstueckID='.$_GET["MusikstueckID"].'">Aktualisieren</a></p>'; 
 
 include('foot_raw.php');

?>
