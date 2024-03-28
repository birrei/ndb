
<?php 
include('head_raw.php');
include_once("cl_satz.php");

$satz=new Satz();
$satz->ID=$_GET["SatzID"]; 

if (isset($_GET["NotenwertID"])) { 
    // über Link aus "edit_satz_add_notenwert.php" 
    $satz->add_notenwert($_GET["NotenwertID"]); 
}

$satz->print_table_notenwerte();   

echo '<p> <a href="edit_satz_add_notenwert.php?SatzID='.$satz->ID.'">[Notenwert hinzufügen]</a></p>'; 

include('foot_raw.php');
?>
