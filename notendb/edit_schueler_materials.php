
<?php 
include('head_raw.php');

include_once("cl_schueler.php");
include_once("cl_schueler_material.php");

$schueler=new Schueler();
$schueler->ID=$_REQUEST["SchuelerID"]; 


if (isset($_GET["option"])){

    if($_REQUEST["option"]=='delete') {
        $schuelermaterial=new SchuelerMaterial(); 
        $schuelermaterial->ID=$_REQUEST["ID"]; 

        if (isset($_POST["confirm"])) {
            $schuelermaterial->delete(); 
        }
        else {
            echo '
            <form action="" method="post">
            <p>Material-Verknüpfung ID '.$schuelermaterial->ID.' wird gelöscht 
            <input class="btnDelete" type="submit" name="confirm" value="Löschung bestätigen">
            <input type="hidden" name="ID" value="' . $schuelermaterial->ID . '">  
            <input type="hidden" name="ID" value="' . $schuelermaterial->ID . '">              
            <input type="hidden" name="option" value="delete">        
            </form>
            </p>  '; 
        }

    }     
}



echo '<div style="float:left">'; 

$schueler->print_table_materials(); 

echo '</div>'; 

// echo '&nbsp;<a href="edit_schueler_schueler.php?MaterialID='.$schueler->ID.'&option=insert" class="form-link">Hinzufügen</a>'; 

    
include('foot_raw.php');

?>
