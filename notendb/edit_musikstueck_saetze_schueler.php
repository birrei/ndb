
<?php 
include_once('head_raw.php');
include_once("classes/class.musikstueck.php");

$musikstueck = new Musikstueck(); 
$musikstueck->ID = $_GET["MusikstueckID"]; 
$musikstueck->print_table_saetze_schueler(); 

include_once('foot_raw.php');

?>
