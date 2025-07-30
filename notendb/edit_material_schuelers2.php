<?php 
include_once("classes/class.material.php");
include_once("classes/class.schueler_material.php");
include_once("classes/class.htmlinfo.php");

$html= new HtmlInfo(); 

$material=new Material();
$material->ID=$_GET["MaterialID"]; 

$schueler_material=new SchuelerMaterial(); 

$schueler_selected=[];  

$option=$_REQUEST["option"]; 

switch($option) {
    case 'update': 
        if (isset($_POST["schueler"])) {
            $schueler_selected=$_POST["schueler"]; 
            for ($i = 0; $i < count($schueler_selected); $i++) { 
                $schueler_material->insert_row($schueler_selected[$i],$material->ID );
            }        
            header('Location: edit_material_schuelers.php?MaterialID='.$material->ID );
            exit; 
        }
       
    break; 

}

include('head_raw.php');

echo '<div style="float:left">
     <form action="#" method="post">'; 

$material->print_table_schueler_checklist(); 

echo '<input type="submit" name="senden" value="Speichern">
    <input type="hidden" name="option" value="update">      
    <input type="hidden" name="MaterialID" value="' . $material->ID. '">
    </form>
    <p> '; 
$html->print_link_backToList('edit_material_schuelers.php?MaterialID='.$material->ID);

echo '</p></div>'; 






include_once('foot_raw.php');

?>
