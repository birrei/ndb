
<?php 
include('head.php');
include('cl_sammlung.php');

echo '<h2>Sammlung löschen</h2>'; 

$sammlung=new Sammlung(); 

if (isset($_GET["ID"])) {
  /* Aufruf Lösch-Link edit_musikstueck.php  */
  $sammlung->ID= $_GET["ID"]; 
  $sammlung->load_row(); 
  if (!isset($_POST["confirm"])) {
      echo '
      <form action="delete_sammlung.php" method="post">
      <p><b>Folgende Sammlung wird inklusive der vorhandenen Musikstücke und Sätze gelöscht: </b>
      <br/>
      <br/>
      ID: '.$sammlung->ID.'  <br/>
      Name:  '.$sammlung->Name.'  <br/><br/>

      <input class="btnDelete" type="submit" name="confirm" value="Löschung bestätigen">
      <input type="hidden" name="ID" value="' . $sammlung->ID . '">
      <input type="hidden" name="title" value="Satz löschen">        
      </form>
      </p> 
      <p> <a href="edit_sammlung.php?ID='. $sammlung->ID . '&title=Sammlung">Abbrechen / Zurück</a></p> 
      '; 
  } 
}

if (isset($_POST["confirm"])) {
  $sammlung->ID=$_POST["ID"]; 
  $sammlung->delete(); 
  echo '<p>Die Seite kann geschlossen werden.</p>';      
}


include('foot.php');

?>

