<?php 

$PageTitle='Übungstage einlesen'; 

include_once('head.php');
include_once("classes/class.htmlinfo.php");
include_once("classes/class.schuljahr.php");
include_once("classes/class.schueler.php");
include_once("classes/class.kalender.php");

echo '<h3>'.$PageTitle.'</h3>'.PHP_EOL; 

$SchuljahrID=(isset($_REQUEST["SchuljahrID"])?$_REQUEST["SchuljahrID"]:'');   
$SchuelerID=(isset($_REQUEST["SchuelerID"])?$_REQUEST["SchuelerID"]:'');   


if(isset($_REQUEST["insert"])) {
  $schueler_kalender = new SchuelerKalender(); 
  $schueler_kalender->insert_rows($SchuljahrID, $SchuelerID); 
}

if(isset($_REQUEST["delete"])) {
  $schueler_kalender = new SchuelerKalender(); 
  $schueler_kalender->delete_rows($SchuljahrID, $SchuelerID); 
}

/* Schuljahr auswählen */
echo '<form action="" method="get">'.PHP_EOL;


$schuljahr= new Schuljahr(); 
echo 'Schuljahr: '.PHP_EOL; 
$schuljahr->print_preselect($SchuljahrID, '', true); 
// echo '<br><br>'; 

$schueler = new Schueler(); 
    echo ' &#9475;';    
echo ' Schüler: '.PHP_EOL; 
$schueler->print_preselect($SchuelerID); 


echo '</form>';           

echo '<p><a href="show_table4.php?ansicht=uebungstage&SchuljahrID='.$SchuljahrID.'" target="_blank">Übungstage anzeigen </a> </p>'; 
// echo '<br><br>';

echo '<hr>'; 
echo '<form action="" method="get">'.PHP_EOL;       
echo '<input type="hidden" name="SchuljahrID" value='.$SchuljahrID.'>'; 
echo '<input type="hidden" name="SchuelerID" value='.$SchuelerID.'>'; 
echo '<input type="submit" class="btnSave" name="insert" value="Übungstage einlesen">';
echo '</form>';  

echo '<p>Hinweise: 
  Das Schuljahr muss ausgewählt sein, optional kann ein Schüler ausgewählt werden. 
  Bereits bestehende Übungstage werden nicht überschrieben!</p>'; 

echo '<br><br>';

echo '<hr>'; 

echo '<form action="" method="get">'.PHP_EOL;       
echo '<input type="hidden" name="SchuljahrID" value='.$SchuljahrID.'>'; 
echo '<input type="hidden" name="SchuelerID" value='.$SchuelerID.'>'; 
echo '<input type="submit" class="btnSave" name="delete" value="Übungstage löschen">';
echo '</form>';           

echo '<p>Hinweise: 
  Das Schuljahr muss ausgewählt sein, optional kann ein Schüler ausgewählt werden. 
      Bereits bestehende Übungstage im Schuljahrzeitraum werden  gelöscht!
      Falls bereits Übungstage mit zugeordnete Übungen vorhanden sind, ist keine Löschung möglich. 
</p>'; 


          

?>


<hr >


<?php 

end: 

include_once('foot.php');
?>

