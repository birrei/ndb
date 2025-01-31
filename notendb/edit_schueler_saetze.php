
<?php 
include('head_raw.php');

include_once("cl_schueler.php");
include_once("cl_schueler_satz.php");

$schueler=new Schueler();
$schueler->ID=$_REQUEST["SchuelerID"]; 


if (isset($_GET["option"])){

    if($_REQUEST["option"]=='delete') {
        $schuelersatz=new SchuelerSatz(); 
        $schuelersatz->ID=$_REQUEST["ID"]; 

        if (isset($_POST["confirm"])) {
            $schuelersatz->delete(); 
        }
        else {
            echo '
            <form action="" method="post">
            <p>Satz-Verknüpfung ID '.$schuelersatz->ID.' wird gelöscht 
            <input class="btnDelete" type="submit" name="confirm" value="Löschung bestätigen">
            <input type="hidden" name="ID" value="' . $schuelersatz->ID . '">  
            <input type="hidden" name="option" value="delete">        
            </form>
            </p>  '; 
        }

    }     
}



echo '<div style="float:left">'; 

$schueler->print_table_saetze(); 

echo '</div>'; 

// echo '&nbsp;<a href="edit_schueler_schueler.php?SatzID='.$schueler->ID.'&option=insert" class="form-link">Hinzufügen</a>'; 

    
include('foot_raw.php');

?>
