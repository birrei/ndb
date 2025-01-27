
<?php 
include('head_raw.php');
include_once("cl_materialtyp.php");
include_once("cl_material.php");

$materialtyp=new Materialtyp();
$materialtyp->ID=$_GET["MaterialtypID"]; 


echo '<div style="float:left">'; 

$materialtyp->print_table_materials('edit_material.php');

echo '</div>'; 

echo '&nbsp;<a href="edit_material.php?MaterialtypID='.$materialtyp->ID.'&option=insert&source=iframe" class="form-link">Hinzufügen</a>'; 




include('foot_raw.php');


?>
