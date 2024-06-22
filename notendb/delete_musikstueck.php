
<?php 
include('head.php');
include('cl_musikstueck.php');

echo '<h2>Musikstück löschen</h2>'; 

$musikstueck=new Musikstueck(); 


if (isset($_GET["ID"])) {
  /* Aufruf Lösch-Link edit_musikstueck.php  */
  $musikstueck->ID= $_GET["ID"]; 
  $musikstueck->load_row(); 
  if (!isset($_POST["confirm"])) {
      echo '
      <form action="delete_musikstueck.php" method="post">
      <p><b>Folgendes Musikstück wird inklusive der vorhandenen Sätze gelöscht: </b>
      <br/>
      <br/>
      ID: '.$musikstueck->ID.'  <br/>
      Nummer: '.$musikstueck->Nummer.'  <br/>
      Name:  '.$musikstueck->Name.'  <br/><br/>

      <input class="btnDelete" type="submit" name="confirm" value="Löschung bestätigen">
      <input type="hidden" name="ID" value="' . $musikstueck->ID . '">
      <input type="hidden" name="title" value="Satz löschen">        
      </form>
      </p> 
      <p> <a href="edit_musikstueck.php?ID='. $musikstueck->ID . '&title=Musikstück">Abbrechen / Zurück</a></p> 
      '; 
  } 
}

if (isset($_POST["confirm"])) {
  $musikstueck->ID=$_POST["ID"]; 
  $musikstueck->delete(); 
  echo '<p>Die Seite kann geschlossen werden.</p>';      
}


include('foot.php');

?>

