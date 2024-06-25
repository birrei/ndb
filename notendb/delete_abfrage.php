
<?php 
include('head.php');
include('cl_abfrage.php');

echo '<h2>Abfrage löschen</h2>'; 

$abfrage=new Abfrage(); 


if (isset($_GET["ID"])) {
  /* Aufruf Lösch-Link edit_musikstueck.php  */
  $abfrage->ID= $_GET["ID"]; 
  $abfrage->load_row(); 
  if (!isset($_POST["confirm"])) {
      echo '
      <form action="delete_abfrage.php" method="post">
      <p><b>Folgende Abfrage wird gelöscht: </b>
      <br/>
      <br/>
      ID: '.$abfrage->ID.'  <br/>
      Name:  '.$abfrage->Name.'  <br/><br/>

      <input class="btnDelete" type="submit" name="confirm" value="Löschung bestätigen">
      <input type="hidden" name="ID" value="' . $abfrage->ID . '">
      <input type="hidden" name="title" value="Abfage löschen">        
      </form>
      </p> 
      <p> <a href="edit_abfrage.php?ID='. $abfrage->ID . '&title=Abfrage">Abbrechen / Zurück</a></p> 
      '; 
  } 
}

if (isset($_POST["confirm"])) {
  $abfrage->ID=$_POST["ID"]; 
  $abfrage->delete(); 
  echo '<p>Die Seite kann geschlossen werden.</p>';      
}


include('foot.php');

?>

