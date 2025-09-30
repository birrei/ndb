<?php 
include_once('head_raw.php');
include_once("classes/class.schueler.php");

echo '<div style="display: grid; grid-template-columns: auto auto;">'; 

$schueler=new Schueler();
$schueler->ID=$_GET["SchuelerID"]; 
$schueler->print_table_lookups(); 

echo '</div>'; 
    
include_once('foot_raw.php');

?>
