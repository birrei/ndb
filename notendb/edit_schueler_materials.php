
<?php 
include('head_raw.php');

include_once("cl_schueler.php");
include_once("cl_schueler_material.php");

$schueler=new Schueler();
$schueler->ID=$_REQUEST["SchuelerID"]; 

$schuelermaterial=new SchuelerMaterial(); 

if (isset($_REQUEST["option"])) {
    switch($_REQUEST["option"]) {

        case "delete": 
            $schuelermaterial->ID=$_REQUEST["ID"]; 
            $schuelermaterial->delete(); 
        break; 

        case "insert": 
             $schuelermaterial->insert_row( $_REQUEST["SchuelerID"], $_GET["MaterialID"]);   
        break; 

    }
}



echo '<div style="float:left">'; 

$schueler->print_table_materials(); 

echo '</div>'; 

echo '&nbsp;<a href="edit_schueler_material.php?SchuelerID='.$schueler->ID.'&option=insert" class="form-link">Hinzufügen</a>'; 

    
include('foot_raw.php');

?>
