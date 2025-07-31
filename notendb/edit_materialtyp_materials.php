
<?php 
include_once('head_raw.php');
include_once("classes/class.materialtyp.php");
include_once("classes/class.material.php");

$materialtyp=new Materialtyp();
$materialtyp->ID=$_GET["MaterialtypID"]; 


echo '<div style="float:left">'; 

$materialtyp->print_table_materials('edit_material.php');

echo '</div>'; 

echo '&nbsp;<a href="edit_material.php?MaterialtypID='.$materialtyp->ID.'&option=insert&source=iframe" class="form-link">Hinzufügen</a>'; 

include_once('foot_raw.php');


?>
