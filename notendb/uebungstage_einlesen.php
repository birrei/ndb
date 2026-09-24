<?php 

$PageTitle='Schuljahr Übungstage einlesen'; 

include_once('head.php');
include_once("classes/class.htmlinfo.php");
include_once("classes/class.schuljahr.php");
include_once("classes/class.schueler.php");
include_once("classes/class.kalender.php");

echo '<h3>'.$PageTitle.'</h3>'.PHP_EOL; 



$SchuljahrID=(isset($_REQUEST["SchuljahrID"])?$_REQUEST["SchuljahrID"]:'');   
$SchuelerID=(isset($_REQUEST["SchuelerID"])?$_REQUEST["SchuelerID"]:'');  
$Datum_ab=(isset($_REQUEST["Datum_ab"])?$_REQUEST["Datum_ab"]:'');  


if(isset($_REQUEST["insert"])) {
  $schueler_kalender = new SchuelerKalender(); 
  $schueler_kalender->insert_rows($SchuljahrID, $SchuelerID, $Datum_ab); 
}

if(isset($_REQUEST["delete"])) {
  $schueler_kalender = new SchuelerKalender(); 
  $schueler_kalender->delete_rows($SchuljahrID, $SchuelerID); 
}

echo '<p><a href="show_table4.php?ansicht=uebungstage&SchuljahrID='.$SchuljahrID.'" target="_blank">Übersicht Übungstage anzeigen </a> </p>'; 
// echo '<br><br>';

echo '<form action="" method="get">'.PHP_EOL;

$schuljahr= new Schuljahr(); 
echo 'Schuljahr: '.PHP_EOL; 
$schuljahr->print_preselect($SchuljahrID, '', true); 
// echo '<br><br>'; 

$schueler = new Schueler(); 
    echo ' &#9475;';    
echo ' Schüler (optional): '.PHP_EOL; 
$schueler->print_preselect($SchuelerID); 


echo '</form>';           



echo '<form action="" method="get">'.PHP_EOL;       
echo '<input type="hidden" name="SchuljahrID" value='.$SchuljahrID.'>'; 
echo '<input type="hidden" name="SchuelerID" value='.$SchuelerID.'>'; 

echo '<hr>'; 
echo '<h4>Übungstage einfügen</h4>'.PHP_EOL; 

echo '<p>Hinweise:  </p>
  <ul>
    <li>Das Schuljahr muss ausgewählt sein, optional kann ein Schüler ausgewählt werden.</li> 
    <li>Bereits bestehende Übungstage werden nicht überschrieben.</li> 
    <li>Verwendung von "Datum ab": Ab diesem Datum einlesen (für später im Schuljahr hinzukommende Schüler) </li> 
  </ul>'; 

echo 'Datum ab (optional): <input type="date" name="Datum_ab" value="'.$Datum_ab.'" onchange="this.form.submit()">'; 
echo '<br><br><input type="submit" class="btnSave" name="insert" value="Einfügen ausführen">';
echo '</form>';  



echo '<br><br>';

echo '<hr>'; 
echo '<h4>Übungstage löschen</h4>'.PHP_EOL; 

echo '<form action="" method="get">'.PHP_EOL;       
echo '<input type="hidden" name="SchuljahrID" value='.$SchuljahrID.'>'; 
echo '<input type="hidden" name="SchuelerID" value='.$SchuelerID.'>'; 


echo '<p>Hinweise:  </p>
  <ul>
    <li>Schuljahr und Schüler müssen ausgewählt sein.</li> 
    <li>Nicht gelöscht werden: 
      <br>* Manuell angelegte Übungstage
      <br>* Übungstage mit verknüpften Übungen
      <br>* Übungstage mit Text im Bemerkungs-Feld 
      </li> 
  </ul>'; 


echo '<input type="submit" class="btnSave" name="delete" value="Löschung ausführen">';
echo '</form>';           



          

?>




<?php 

end: 

include_once('foot.php');
?>

