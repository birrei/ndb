
<?php 
include_once('head_raw.php');
include_once("classes/class.schueler.php");
include_once("classes/class.schuljahr.php");

echo '<div style="display: grid; grid-template-columns: auto auto;">'; 

$SchuelerID=$_REQUEST["SchuelerID"]; 

// $Datum=(isset($_REQUEST["Datum"])?$_REQUEST["Datum"]:date('Y-m-d')); 
$Datum=(isset($_REQUEST["Datum"])?$_REQUEST["Datum"]:''); 

$schuljahr = new Schuljahr(); 
$SchuljahrID_akt= $schuljahr->getCurrentID(); 
$SchuljahrID=(isset($_REQUEST["SchuljahrID"])?$_REQUEST["SchuljahrID"]:$SchuljahrID_akt);    
$SchuljahrID=$SchuljahrID==''?$SchuljahrID_akt:$SchuljahrID;    


echo '<form action="" method="get">'.PHP_EOL;  
echo 'Schuljahr: '.PHP_EOL; 
$schuljahr->print_preselect($SchuljahrID, '', false); 
echo '<input type="hidden" name="SchuelerID" value="'.$SchuelerID.'">'; 
echo 'Übung Datum: <input type="date" name="Datum" value="'.$Datum.'" onchange="this.form.submit()">';    
echo '</form><br>'; 

$schueler=new Schueler();
$schueler->ID=$SchuelerID; 
$schueler->print_table_uebungen2($SchuljahrID, $Datum); 

echo '</div>'; 
    
include_once('foot_raw.php');

?>
