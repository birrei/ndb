
<?php 
include('head_raw.php');

include_once("cl_satz.php");
include_once("cl_schueler_satz.php");

$satz=new Satz();
$satz->ID=$_GET["SatzID"]; 

if (isset($_GET["option"])){

    if($_REQUEST["option"]=='delete') {
        $satzschueler=new SchuelerSatz(); 
        $satzschueler->ID=$_REQUEST["ID"]; 

        if (isset($_POST["confirm"])) {
            $satzschueler->delete(); 
        }
        else {
            echo '
            <form action="" method="post">
            <p>Schüler-Verknüpfung ID '.$satzschueler->ID.' wird gelöscht 
            <input class="btnDelete" type="submit" name="confirm" value="Löschung bestätigen">
            <input type="hidden" name="ID" value="' . $satzschueler->ID . '">  
            <input type="hidden" name="option" value="delete">        
            </form>
            </p>  '; 
        }

    }     
}



echo '<div style="float:left">'; 

$satz->print_table_schueler(); 

echo '</div>'; 

echo '&nbsp;<a href="edit_satz_schueler.php?SatzID='.$satz->ID.'&option=insert" class="form-link">Hinzufügen</a>'; 

    
include('foot_raw.php');

?>
