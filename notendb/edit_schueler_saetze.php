<?php 
include('head_raw.php');
include_once("classes/class.schueler.php");

echo '<div style="display: grid; grid-template-columns: auto auto;">'; 

$schueler=new Schueler();
$schueler->ID=$_GET["SchuelerID"]; 
$schueler->print_table_saetze(); 

echo '</div>'; 
    
include('foot_raw.php');

?>
