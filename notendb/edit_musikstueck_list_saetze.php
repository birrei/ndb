
<?php 
include('head_raw.php');
include("cl_satz.php");

$satz = new Satz(); 
$satz->MusikstueckID = $_GET["MusikstueckID"]; 
$satz->print_table_from_musikstueck(); 

echo '<p> <a href="edit_musikstueck_add_satz.php?MusikstueckID='.$_GET["MusikstueckID"].'">Satz hinzufügen</a></p>'; 
echo '<p> <a href="edit_musikstueck_list_saetze.php?MusikstueckID='.$_GET["MusikstueckID"].'">Aktualisieren</a></p>'; 
 
 include('foot_raw.php');

?>
