
<?php 
include('head_raw.php');

include_once("cl_satz.php");

$SatzID=$_GET["SatzID"];

$satz=new Satz();
$satz->ID=$SatzID; 
$satz->print_table_sticharten();   

echo '<p> <a href="edit_satz_add_strichart.php?SatzID='.$SatzID.'">[Strichart hinzufügen]</a></p>'; 

include('foot_raw.php');

?>
