<?php 
include_once("classes/class.schueler.php");
include_once("classes/class.uebung.php");
include_once("classes/class.htmlinfo.php");

$info=new HTML_Info(); 

$uebung=new Uebung();
$uebung->ID=$_REQUEST["ID"]; 

$lookups_selected=[];  

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'';

switch($option) {
    case 'update': 
        if (isset($_POST["lookups"])) {
            $lookups_selected=$_POST["lookups"]; 
            for ($i = 0; $i < count($lookups_selected); $i++) { 
                $uebung->add_lookup($lookups_selected[$i]);
            }        
            header('Location: edit_uebung_lookups.php?UebungID='.$uebung->ID );
            exit; 
        }
        break; 
}


form: 
include_once('head_raw.php');


echo '
<div style="float:left">
<form action="#" method="post">'; 

$uebung->print_table_satz_lookups_checklist(); 

echo '<br><input type="submit" class="btnSave" name="senden" value="Speichern">
    <input type="hidden" name="option" value="update">      
    <input type="hidden" name="ID" value="' . $uebung->ID. '">
    </form> '; 

include_once('foot_raw.php');

?>
