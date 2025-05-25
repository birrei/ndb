
<?php 
include('head_raw.php');
include_once("cl_schueler.php");

echo '<div style="display: grid; grid-template-columns: auto auto;">'; 

$schueler=new Schueler();
$schueler->ID=$_GET["SchuelerID"]; 
$schueler->print_table_uebungen(); 

echo '</div>'; 
    
include('foot_raw.php');

?>
