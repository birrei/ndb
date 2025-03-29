
<?php 
include('head_raw.php');
include_once("cl_material.php");
include_once("cl_schueler_material.php");


echo '<div style="display: grid; grid-template-columns: auto auto;">'; 

$material=new Material();
$material->ID=$_GET["MaterialID"]; 
$material->print_table_schueler(); 

echo '<p> <a href="edit_material_schueler.php?MaterialID='.$material->ID.'&option=insert" class="form-link">Hinzufügen</a> 
          <a href="edit_material_schuelers2.php?MaterialID='.$material->ID.'&option=edit" class="form-link">Schnell-Zuordnung</a></p>'; 


echo '</div>'; 
    
include('foot_raw.php');

?>
