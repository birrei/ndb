
<?php 
include_once('head_raw.php');
include_once("classes/class.schueler.php");
include_once("classes/class.schuljahr.php");

echo '<div style="display: grid; grid-template-columns: auto auto;">'; 

$SchuelerID=$_REQUEST["SchuelerID"]; 
$SchuljahrID=(isset($_REQUEST["SchuljahrID"])?$_REQUEST["SchuljahrID"]:''); 

if($SchuljahrID=='') {
    $schuljahr= new Schuljahr(); 
    $SchuljahrID= $schuljahr->getCurrentID(); 
}

echo '<form action="" method="get">'.PHP_EOL;  
$schuljahr = new Schuljahr(); 
echo 'Schuljahr: '.PHP_EOL; 
$schuljahr->print_preselect($SchuljahrID, '', false); 
echo '<input type="hidden" name="SchuelerID" value="'.$SchuelerID.'">'; 

echo '</form><br>';    

$schueler=new Schueler();
$schueler->ID=$_REQUEST["SchuelerID"]; 
$schueler->print_table_uebungen_datum($SchuljahrID); 

echo '</div>'; 
    
include_once('foot_raw.php');

?>
