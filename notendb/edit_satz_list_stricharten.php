
<?php 
include('head_raw.php');

include_once("cl_satz.php");

$satz=new Satz();
$satz->ID=$_GET["SatzID"]; 

if (isset($_GET["option"])){
    if($_GET["option"]=='insert') {
        $satz->add_strichart($_GET["StrichartID"]); 
    } 
    if($_GET["option"]=='delete') {
        $satz->delete_strichart($_GET["ID"]); // ID = satz_strichart.ID 
    } 
}

$satz->print_table_sticharten(basename(__FILE__));  

echo '<p> <a href="edit_satz_add_strichart.php?SatzID='.$satz->ID.'">[Strichart hinzufügen]</a></p>'; 

include('foot_raw.php');

?>
