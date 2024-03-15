
<?php 
include('head_raw.php');

include_once("cl_musikstueck.php");

$MusikstueckID=$_GET["MusikstueckID"];

$musikstueck=new Musikstueck();
$musikstueck->ID=$MusikstueckID; 
$musikstueck->print_table_verwendungszwecke();   


echo '<p> <a href="edit_musikstueck_add_verwendungszweck.php?MusikstueckID='.$MusikstueckID.'">[Verwendungszweck hinzufügen]</a></p>'; 

include('foot_raw.php');

?>
