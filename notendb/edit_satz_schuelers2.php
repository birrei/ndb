<?php 
include_once("classes/class.satz.php");
include_once("classes/class.schueler_satz.php");
include_once("cl_html_info.php");


$satz=new Satz();
$satz->ID=$_GET["SatzID"]; 

$html= new HtmlInfo(); 

$schueler_satz=new SchuelerSatz(); 

$schueler_selected=[];  

$option=$_REQUEST["option"]; 

switch($option) {
    case 'update': 
        if (isset($_POST["schueler"])) {
            $schueler_selected=$_POST["schueler"]; 
            for ($i = 0; $i < count($schueler_selected); $i++) { 
                $schueler_satz->insert_row($schueler_selected[$i],$satz->ID );
            }        
            header('Location: edit_satz_schuelers.php?SatzID='.$satz->ID );
            exit; 
        }
       
        break; 

}

include('head_raw.php');

echo '<div style="float:left">
     <form action="#" method="post">'; 

$satz->print_table_schueler_checklist(); 

echo '<input type="submit" name="senden" value="Speichern">
    <input type="hidden" name="option" value="update">      
    <input type="hidden" name="SatzID" value="' . $satz->ID. '">
    </form>
    <p> '; 
$html->print_link_backToList('edit_satz_schuelers.php?SatzID='.$satz->ID);

echo '</p></div>'; 

include_once('foot_raw.php');

?>
