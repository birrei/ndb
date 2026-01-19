
<?php 
$PageTitle='Schueler Notenmaterial Schnellzuordnung'; 
include_once('head.php');
include_once("classes/class.schueler.php");
include_once("classes/class.materialtyp.php");
include_once("classes/class.schueler_satz.php");
include_once('classes/class.status.php');
include_once('classes/class.htmlinfo.php');


$filter=false; // mind. 1 Filter gesetzt ja / nein 

$SchuelerID=$_REQUEST["ID"];

$schueler=new Schueler(); 
$schueler->ID=$SchuelerID; 
$schueler->load_row(); 

$info=new HTML_Info(); 



/**** Auswahl Filter   */
$MaterialtypID=''; 
$checkSchwierigkeitsgrad=0; 

$Suchtext=''; 

if (isset($_REQUEST["MaterialtypID"])) {
    $MaterialtypID=$_REQUEST["MaterialtypID"]; 
    $filter=($MaterialtypID!=''?true:false); 
}
if (isset($_REQUEST["checkSchwierigkeitsgrad"])) {
    $checkSchwierigkeitsgrad=1;   
    $filter=true;      
}
if (isset($_REQUEST["Suchtext"])) {
    $Suchtext=$_REQUEST["Suchtext"];   
    $filter=true;      
}

$Aktiv=(isset($_POST["Aktiv"])?1:0);  

/************************ */

/**** Auswahl Speichern */

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'';

$saetze_selected=[];  

$status = new Status(); 
$StatusID=(isset($_REQUEST["StatusID"])?$_REQUEST["StatusID"]:'');

echo '<h3>'.$PageTitle.' für '.$schueler->Name.'</h3>'; 


/** Formular Filter  */

echo '<h3>Notenmaterial suchen: </h3>'; 
echo '<form action="" method="get">'.PHP_EOL;       
$materialtyp = new Materialtyp(); 
echo 'Materialtyp: '.PHP_EOL; 
$materialtyp->print_preselect($MaterialtypID); 

?>
&nbsp; &nbsp; Suchtext: <input type="text" id="Suchtext" name="Suchtext" size="30px" value="<?php echo $Suchtext; ?>" autofocus> 
<?php  

echo '
<label><input type="checkbox" name="checkSchwierigkeitsgrad" '.($checkSchwierigkeitsgrad==1?'checked':'').' onchange="this.form.submit()">Instrument / Schwierigkeitsgrad berücksichtigen</label>
<input type="hidden" name="ID" value="'.$SchuelerID.'">
<input type="hidden" name="option" value="'.$option.'">
<input type="submit" class="btnSave" name="senden" value="Suchen">
</form>
<br>';           


switch($option) {
    case 'update': 
        if (isset($_POST["satz"])) {    
            $schueler_satz=new SchuelerSatz();             
            $saetze_selected=$_POST["satz"]; 
            for ($i = 0; $i < count($saetze_selected); $i++) { 
                $schueler_satz->insert_row($SchuelerID, $saetze_selected[$i], $StatusID);
            }        
        }
       
    break; 

}


/************************ */

if (!$filter) {goto pagefoot;}

echo '<hr><h3>Zuordnungen speichern:</h3>'; 
echo '<div style="float:left">
     <form action="#" method="post">'; 

echo 'Status: '; 
$status->print_select($StatusID, '', true, false);   
// $html->print_link_edit($status->table_name,$StatusID,true);         
$info->print_link_table($status->table_name,'sortcol=Name',$status->Titles,true,'');    

echo '<br><br>';   


$schueler->print_table_saetze_checklist($MaterialtypID, $checkSchwierigkeitsgrad, $Suchtext);

echo '<br>
    <input type="submit" class="btnSave" name="senden" value="Speichern">
    <input type="hidden" name="option" value="update">      
    <input type="hidden" name="ID" value="'.$SchuelerID.'">
    </form>
    <p> '; 



pagefoot: 
include_once('foot.php');
?>
