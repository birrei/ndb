
<?php 
include('head_raw.php');

include_once("cl_satz.php");
include_once("cl_schueler_satz.php");

$satz=new Satz();
$satz->ID=$_GET["SatzID"]; 

$schueler_satz=new SchuelerSatz(); 

$schueler_selected=[];  

$option=$_REQUEST["option"]; 


switch($option) {
    case 'update': 
        if (isset($_POST["schueler"])) {
            $schueler_selected=$_POST["schueler"]; 
            for ($k = 0; $k < count($schueler_selected); $k++) { 
                $schueler_satz->insert_row($schueler_selected[$k],$satz->ID );
            }        
            header('Location: edit_satz_schuelers.php?SatzID='.$satz->ID );
            exit; 
        }
       
    break; 

}


echo 
'<div style="float:left">
<form action="#" method="post">
'; 

$satz->print_table_schueler_checklist(); 

echo '
 <input type="submit" name="senden" value="Speichern">

  <input type="hidden" name="option" value="update">      
  <input type="hidden" name="SatzID" value="' . $satz->ID. '">


</form>
</div>'; 


include('foot_raw.php');

?>
