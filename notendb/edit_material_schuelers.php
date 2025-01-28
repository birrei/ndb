
<?php 
include('head_raw.php');

include_once("cl_material.php");
include_once("cl_schueler_material.php");

$material=new Material();
$material->ID=$_GET["MaterialID"]; 

if (isset($_GET["option"])){

    if($_REQUEST["option"]=='delete') {
        $materialschueler=new SchuelerMaterial(); 
        $materialschueler->ID=$_REQUEST["ID"]; 

        if (isset($_POST["confirm"])) {
            $materialschueler->delete(); 
        }
        else {
            echo '
            <form action="" method="post">
            <p>Schüler-Verknüpfung ID '.$materialschueler->ID.' wird gelöscht 
            <input class="btnDelete" type="submit" name="confirm" value="Löschung bestätigen">
            <input type="hidden" name="ID" value="' . $materialschueler->ID . '">  
            <input type="hidden" name="option" value="delete">        
            </form>
            </p>  '; 
        }
    }     
}



echo '<div style="float:left">'; 

 $material->print_table_schueler(); 

echo '</div>'; 

echo '&nbsp;<a href="edit_material_schueler.php?MaterialID='.$material->ID.'&option=insert" class="form-link">Hinzufügen</a>'; 

    
include('foot_raw.php');

?>
