
<?php 
include_once('head_raw.php');
include_once("classes/class.schueler.php");
include_once("classes/class.kalendertag.php");

echo '<div style="display: grid; grid-template-columns: auto auto;">'; 

// $Datum=(isset($_REQUEST["Datum"])?$_REQUEST["Datum"]:date('Y-m-d')); 
$Datum=(isset($_REQUEST["Datum"])?$_REQUEST["Datum"]:''); 

if(!empty($Datum)) {
    $schueler=new Schueler();
    $schueler->ID=$_GET["SchuelerID"]; 
    $schueler->print_table_uebungen($Datum); 

} 


echo '</div>'; 
    
include_once('foot_raw.php');

?>
