<?php 
include_once("classes/class.satz.php");
include_once("classes/class.schueler_satz.php");
include_once('classes/class.status.php');
include_once("classes/class.htmlinfo.php");

$info=new HTML_Info(); 

$satz=new Satz();
$satz->ID=$_GET["SatzID"]; 

$html= new HTML_Info(); 

$schueler_satz=new SchuelerSatz(); 

$status = new Status(); 
$StatusID=(isset($_REQUEST["StatusID"])?$_REQUEST["StatusID"]:'');

$schueler_selected=[];  

$option=$_REQUEST["option"]; 

switch($option) {
    case 'update': 
        if (isset($_POST["schueler"])) {
            $schueler_selected=$_POST["schueler"]; 
            for ($i = 0; $i < count($schueler_selected); $i++) { 
                $schueler_satz->insert_row($schueler_selected[$i],$satz->ID, $StatusID);
            }        
            header('Location: edit_satz_schuelers.php?SatzID='.$satz->ID );
            exit; 
        }
        break; 
}

form: 
include_once('head_raw.php');


echo '
<div style="float:left">
<form action="#" method="post">'; 

echo 'Status: '; 
$status->print_select($StatusID, '', true, false);   
// $html->print_link_edit($status->table_name,$StatusID,true);         
$html->print_link_table($status->table_name,'sortcol=Name',$status->Titles,true,'');    

echo '<br>';   

$satz->print_table_schueler_checklist(); 



echo '<br><input type="submit" class="btnSave" name="senden" value="Speichern">
    <input type="hidden" name="option" value="update">      
    <input type="hidden" name="SatzID" value="' . $satz->ID. '">
    </form>
    <p> '; 



$html->print_link_backToList('edit_satz_schuelers.php?SatzID='.$satz->ID);

echo '</p></div>'; 

include_once('foot_raw.php');

?>
