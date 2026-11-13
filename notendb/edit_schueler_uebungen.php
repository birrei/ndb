
<?php 
include_once('head_raw.php');
include_once("classes/class.schueler.php");
include_once("classes/class.schuljahr.php");

echo '<div style="display: grid; grid-template-columns: auto auto;">'; 

$Entwurf=(isset($_REQUEST["Entwurf"])?$_REQUEST["Entwurf"]:0); // wird beim Aufruf des Unterformulars übergeben  
$Datum=(isset($_REQUEST["Datum"])?$_REQUEST["Datum"]:''); 
$SchuljahrID=(isset($_REQUEST["SchuljahrID"])?$_REQUEST["SchuljahrID"]:''); 

if($Entwurf==0) {

    // $Datum=(isset($_REQUEST["Datum"])?$_REQUEST["Datum"]:date('Y-m-d')); 
    $schuljahr = new Schuljahr(); 
    $SchuljahrID_akt= $schuljahr->getCurrentID(); 
    $SchuljahrID=(isset($_REQUEST["SchuljahrID"])?$_REQUEST["SchuljahrID"]:$SchuljahrID_akt);    
    $SchuljahrID=$SchuljahrID==''?$SchuljahrID_akt:$SchuljahrID;    

    echo '<form action="" method="post">'.PHP_EOL;     
    echo 'Schuljahr: '.PHP_EOL; 
    $schuljahr->print_preselect($SchuljahrID, '', false);       
    echo 'Übung Datum: <input type="date" name="Datum" value="'.$Datum.'" onchange="this.form.submit()">'; 
    echo '</form><br>';       
}

$schueler=new Schueler();
$schueler->ID=$_GET["SchuelerID"]; 
$schueler->print_table_uebungen($SchuljahrID, $Datum, $Entwurf); 

echo '</div>'; 
    
include_once('foot_raw.php');

?>
