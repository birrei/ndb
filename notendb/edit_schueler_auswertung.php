
<?php 
include_once('head_raw.php');
include_once("classes/class.schueler.php");

echo '<div style="display: grid; grid-template-columns: auto auto;">'; 

$schueler=new Schueler();
$schueler->ID=$_GET["SchuelerID"]; 
$AuswertungNr=$_GET["AuswertungNr"];


$schueler->print_table_auswertung_uebungen($AuswertungNr); 

echo '</div>'; 
    
include_once('foot_raw.php');

?>
