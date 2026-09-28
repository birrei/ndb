
<?php 
include_once('head_raw.php');
include_once("classes/class.schueler.php");
include_once("classes/class.aufgabe.php");


if (isset($_REQUEST["option"])) { 
    // aufruf aus edit_schueler_aufgabe.php     

    // print_r($_REQUEST); // test 

    $aufgabe = new Aufgabe();

    $option=isset($_REQUEST["option"])?$_REQUEST["option"]:'';
    $show_data=true; 

    switch($option) {

        case 'update': 

            $Erledigt=(isset($_GET["Erledigt"])?1:0); // POST nur verfügbar, wenn Checkbox aktiviert 
            $Datum=isset($_GET["Datum"])?$_REQUEST["Datum"]:'';
            $Beschreibung=isset($_GET["Beschreibung"])?$_REQUEST["Beschreibung"]:'';
            $SChuelerID=$_GET["SchuelerID"]; 

            $aufgabe->ID = $_GET["ID"];  
            $aufgabe->update_row($Datum, $Beschreibung, $Erledigt, $SChuelerID);  
            $Erledigt = $aufgabe->Erledigt;       

            break; 

        case 'delete_2': // nach Bestätigung aus edit_schueler_ausgabe.php 
            $aufgabe->ID=$_REQUEST["ID"]; 
            $aufgabe->delete(); 
            break; 

        default: 
            $show_data=false;       
    
    }

}

echo '<div style="display: grid; grid-template-columns: auto auto; float:left;">'; 

$schueler=new Schueler();
$schueler->ID=$_REQUEST["SchuelerID"]; 
$schueler->print_table_aufgaben(); 

echo '</div>'; 

echo '&nbsp;<a href="edit_schueler_aufgabe.php?SchuelerID='.$schueler->ID.'&option=insert" class="form-link" >Hinzufügen</a>'; 

include_once('foot_raw.php');

?>
