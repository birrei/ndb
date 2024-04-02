
<?php 
include('head_raw.php');
include_once("cl_satz.php");

$satz=new Satz();
$satz->ID=$_GET["SatzID"]; 

if (isset($_GET["option"])){
    if($_GET["option"]=='insert') {
        $satz->add_notenwert($_GET["NotenwertID"]); 
    } 
    if($_GET["option"]=='delete') {
        $satz->delete_notenwert($_GET["ID"]); // ID = satz_notenwert.ID 
    } 
}

$satz->print_table_notenwerte(basename(__FILE__));  

echo '<p> <a href="edit_satz_add_notenwert.php?SatzID='.$satz->ID.'">[Notenwert hinzufügen]</a></p>'; 

include('foot_raw.php');
?>
