
<?php 
include('head_raw.php');

include_once("cl_musikstueck.php");

$MusikstueckID=$_GET["MusikstueckID"];

$musikstueck=new Musikstueck();
$musikstueck->ID=$MusikstueckID; 
$musikstueck->print_table_besetzungen();   

echo '<p> <a href="edit_musikstueck_add_besetzung.php?MusikstueckID='.$MusikstueckID.'">[Besetzung hinzufügen]</a></p>'; 


include('foot_raw.php');

?>
