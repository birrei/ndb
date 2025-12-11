
<?php 
include_once('head_raw.php');

include_once("classes/class.sammlung.php");

$sammlung=new Sammlung();
$sammlung->ID=$_GET["SammlungID"]; 

if (isset($_GET["option"])){
    if($_GET["option"]=='insert' and isset($_GET["StandortID"])) {
        if ($_GET["StandortID"]!='') {
         $sammlung->add_standort($_GET["StandortID"]); 
        }
    } 
    if($_GET["option"]=='delete') {
        $sammlung->delete_standort($_GET["ID"]); // ID = sammlung_standort.ID 
    } 
}


echo '<div style="float:left">'; 

$sammlung->print_table_standorte(basename(__FILE__)); 

echo '</div>'; 

echo '&nbsp;<a href="edit_sammlung_standort.php?SammlungID='.$sammlung->ID.'" class="form-link">Hinzufügen</a>'; 


include_once('foot_raw.php');

?>
