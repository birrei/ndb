
<?php 
include('head_raw.php');
include("cl_sammlung.php");

$sammlung=new Sammlung(); 
$sammlung->ID=$_GET["SammlungID"];  
$sammlung->print_table_musikstuecke();

// echo '<p> <a href="edit_musikstueck.php?SammlungID='.$_GET["SammlungID"].'&option=insert&title=Musikstueck" target="_blank">Musikstück hinzufügen</a></p>'; 
// echo '<p> <a href="edit_sammlung_list_musikstuecke.php?SammlungID='.$_GET["SammlungID"].'">Aktualisieren</a></p>'; 
 
include('foot_raw.php');
?>
