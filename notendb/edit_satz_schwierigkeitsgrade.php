
<?php 
include('head_raw.php');

include_once("cl_satz.php");

$satz=new Satz();
$satz->ID=$_GET["SatzID"]; 

if (isset($_GET["option"])){
    if($_GET["option"]=='insert') {
        if ($_GET["SchwierigkeitsgradID"]!='' & $_GET["InstrumentID"]!='') {
            $satz->add_schwierigkeitsgrad($_GET["SchwierigkeitsgradID"], $_GET["InstrumentID"]); 
        } else {
            echo '<p>Bitte Instrument und Schwierigkeitsgrad auswählen!</p>'; 
        }
    } 
    if($_GET["option"]=='delete') {
        $satz->delete_schwierigkeitsgrad($_GET["ID"]); // ID = satz_schwierigkeitsgrad.ID 
    } 
}




echo '<div style="float:left">'; 

$satz->print_table_schwierigkeitsgrade(basename(__FILE__)); 

echo '</div>'; 

echo '&nbsp;<a href="edit_satz_schwierigkeitsgrad.php?SatzID='.$satz->ID.'" class="form-link">Hinzufügen</a>'; 



include('foot_raw.php');

?>
