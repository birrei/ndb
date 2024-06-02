
<?php 
include('head_raw.php');
include("cl_sammlung.php");

$sammlung=new Sammlung(); 
$sammlung->ID=$_GET["SammlungID"];  
$sammlung->print_table_links();

echo '<p> <a href="edit_sammlung_add_link.php?SammlungID='.$_GET["SammlungID"].'">Link hinzufügen</a></p>'; 

include('foot_raw.php');
?>
