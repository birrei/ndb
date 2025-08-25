
<?php 
include_once('head_raw.php');

include_once("classes/class.material.php");

$material=new Material();
$material->ID=$_GET["MaterialID"]; 

if (isset($_GET["option"])){
    if($_GET["option"]=='insert') {
        if ($_GET["SchwierigkeitsgradID"]!='' & $_GET["InstrumentID"]!='') {
            $material->add_schwierigkeitsgrad($_GET["SchwierigkeitsgradID"], $_GET["InstrumentID"]); 
        } else {
            echo '<p>Bitte Instrument und Schwierigkeitsgrad auswählen!</p>'; 
        }
    } 
    if($_GET["option"]=='delete') {
        $material->delete_schwierigkeitsgrad($_GET["ID"]); // ID = material_schwierigkeitsgrad.ID 
    } 
}




echo '<div style="float:left">'; 

$material->print_table_schwierigkeitsgrade(basename(__FILE__)); 

echo '</div>'; 

echo '&nbsp;<a href="edit_material_schwierigkeitsgrad.php?MaterialID='.$material->ID.'" class="form-link">Hinzufügen</a>'; 



include_once('foot_raw.php');

?>
