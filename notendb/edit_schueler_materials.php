
<?php 
include('head_raw.php');
include_once("cl_schueler.php");

echo '<div style="display: grid; grid-template-columns: auto auto;">'; 

$schueler=new Schueler();
$schueler->ID=$_GET["SchuelerID"]; 
$schueler->print_table_materials(); 

// verworfen 
// echo '<p> <a href="edit_schueler_material.php?SchuelerID='.$schueler->ID.'&option=insert" class="form-link">Hinzufügen</a> 
//           <a href="edit_schueler_materials2.php?SchuelerID='.$schueler->ID.'&option=edit" class="form-link">Schnell-Zuordnung</a></p>'; 


echo '</div>'; 
    
include('foot_raw.php');

?>
