
<?php 
include('head_raw.php');

include_once("classes/class.schueler.php");

$schueler=new Schueler();
$schueler->ID=$_GET["SchuelerID"]; 

if (isset($_REQUEST["option"])) {
    switch($_REQUEST["option"]) {

        case "insert": 
            if ($_GET["InstrumentID"]!='') {
                $schueler->add_schwierigkeitsgrad($_GET["SchwierigkeitsgradID"], $_GET["InstrumentID"]); 
            } else {
                echo '<p>Bitte Instrument auswählen!</p>'; 
            }
        break; 

        case "delete": 
            $schueler->delete_schwierigkeitsgrad($_GET["ID"]); // 
        break; 


    }
}

echo '<div style="float:left">'; 

$schueler->print_table_schwierigkeitsgrade(basename(__FILE__)); 

echo '</div>'; 

echo '&nbsp;<a href="edit_schueler_schwierigkeitsgrad.php?SchuelerID='.$schueler->ID.'" class="form-link">Hinzufügen</a>'; 

include('foot_raw.php');

?>
