
<?php 
include_once('head_raw.php');
include_once("classes/class.sammlung.php");
include_once("classes/class.link.php");

$sammlung=new Sammlung(); 
$sammlung->ID=$_GET["SammlungID"];  

echo '<div style="float:left">'; 

$sammlung->print_table_links();

echo '</div>'; 

echo '&nbsp;<a href="edit_sammlung_link.php?SammlungID='.$sammlung->ID.'&option=insert" class="form-link">Hinzufügen</a>'; 

include_once('foot_raw.php');
?>
