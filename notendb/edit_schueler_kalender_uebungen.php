
<?php 
include_once('head_raw.php');
include_once("classes/class.schueler.php");
include_once("classes/class.kalendertag.php");
include_once("classes/class.uebung.php");

echo '<div style="display: grid; grid-template-columns: auto auto;">'; 

$SchuelerID = $_GET["SchuelerID"]; 

$Datum=(isset($_REQUEST["Datum"])?$_REQUEST["Datum"]:''); 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'';

$show_data=true; 

if(empty($Datum)){
    $show_data=false; 
    goto foot; 
}

switch($option) {
  case 'insert_uebung_default': 
    $uebung = new Uebung(); 
    $uebung->insert_row_default($SchuelerID, $Datum); 
    break; 
}

$schueler=new Schueler();
$schueler->ID=$SchuelerID; 
$schueler->print_table_uebungen($Datum); 

echo '</div>'; 

foot: 

include_once('foot_raw.php');

?>
