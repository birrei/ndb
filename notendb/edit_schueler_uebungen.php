
<?php 
include_once('head_raw.php');
include_once("classes/class.schueler.php");

echo '<div style="display: grid; grid-template-columns: auto auto;">'; 

// $Datum=(isset($_REQUEST["Datum"])?$_REQUEST["Datum"]:date('Y-m-d')); 
$Datum=(isset($_REQUEST["Datum"])?$_REQUEST["Datum"]:''); 

$Entwurf=$_REQUEST["Entwurf"]; 

if($Entwurf==0) {
    echo '<form action="" method="post">'.PHP_EOL;       
    echo 'Übung Datum: <input type="date" name="Datum" value="'.$Datum.'" onchange="this.form.submit()">'; 
    echo '</form><br>';       
}

$schueler=new Schueler();
$schueler->ID=$_GET["SchuelerID"]; 

$schueler->print_table_uebungen($Datum, $Entwurf); 

echo '</div>'; 
    
include_once('foot_raw.php');

?>
