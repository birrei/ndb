<?php 
// ! nicht verwendet 

include_once("cl_schueler.php");
include_once("cl_schueler_material.php");
include_once("cl_html_info.php");

$html= new HtmlInfo(); 

$schueler=new Schueler();
$schueler->ID=$_GET["SchuelerID"]; 

$schueler_material=new SchuelerMaterial(); 

$materials_selected=[];  

$option=$_REQUEST["option"]; 

switch($option) {
    case 'update': 
        if (isset($_POST["material"])) {
            $materials_selected=$_POST["material"]; 
            for ($i = 0; $i < count($materials_selected); $i++) { 
                $schueler_material->insert_row($schueler->ID, $materials_selected[$i]);
            }        
            header('Location: edit_schueler_materials.php?SchuelerID='.$schueler->ID );
            exit; 
        }
       
    break; 

}

include('head_raw.php');

echo '<div style="float:left">
     <form action="#" method="post">'; 

$schueler->print_table_material_checklist(); 

echo '<input type="submit" name="senden" value="Speichern">
    <input type="hidden" name="option" value="update">      
    <input type="hidden" name="SchuelerID" value="' . $schueler->ID. '">
    </form>
    <p> '; 
$html->print_link_backToList('edit_schueler_materials.php?SchuelerID='.$schueler->ID);

echo '</p></div>'; 






include_once('foot_raw.php');

?>
