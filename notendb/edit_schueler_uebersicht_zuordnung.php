
<?php 
$PageTitle='Schueler Notenmaterial Schnellzuordnung'; 
include_once('head.php');
include_once("classes/class.schueler.php");
include_once("classes/class.materialtyp.php");
include_once("classes/class.schueler_satz.php");

echo '<h3>'.$PageTitle.' (BETA) </h3>'; 

$filter=false; // mind. 1 Filter gesetzt ja / nein 

$SchuelerID=$_REQUEST["ID"];

$schueler=new Schueler(); 
$schueler->ID=$SchuelerID; 

$MaterialtypID=''; 
$checkSchwierigkeitsgrad=0; 

if (isset($_REQUEST["MaterialtypID"])) {
    $MaterialtypID=$_REQUEST["MaterialtypID"]; 
    $filter=($MaterialtypID!=''?true:false); 
}
if (isset($_REQUEST["checkSchwierigkeitsgrad"])) {
    $checkSchwierigkeitsgrad=1;   
    $filter=true;      
}


$Aktiv=(isset($_POST["Aktiv"])?1:0);  

/************************ */

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'';

$saetze_selected=[];  

echo '<form action="" method="get">'.PHP_EOL;       
$materialtyp = new Materialtyp(); 
echo 'Materialtyp: '.PHP_EOL; 
$materialtyp->print_preselect($MaterialtypID); 
echo '
<label><input type="checkbox" name="checkSchwierigkeitsgrad" '.($checkSchwierigkeitsgrad==1?'checked':'').' onchange="this.form.submit()">Instrument / Schwierigkeitsgrad berücksichtigen</label>
<input type="hidden" name="ID" value="'.$SchuelerID.'">
<input type="hidden" name="option" value="'.$option.'">
</form>
<br>';           


switch($option) {
    case 'update': 
        if (isset($_POST["satz"])) {    
            $schueler_satz=new SchuelerSatz();             
            $saetze_selected=$_POST["satz"]; 
            for ($i = 0; $i < count($saetze_selected); $i++) { 
                $schueler_satz->insert_row($SchuelerID, $saetze_selected[$i]);
            }        
        }
       
    break; 

}


/************************ */

if (!$filter) {goto pagefoot;}


echo '<div style="float:left">
     <form action="#" method="post">'; 

$schueler->print_table_saetze_checklist($MaterialtypID, $checkSchwierigkeitsgrad);

echo '<br><input type="submit" class="btnSave" name="senden" value="Speichern">
    <input type="hidden" name="option" value="update">      
    <input type="hidden" name="ID" value="'.$SchuelerID.'">
    </form>
    <p> '; 



pagefoot: 
include_once('foot.php');
?>
