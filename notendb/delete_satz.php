
<?php 
include('head.php');
include('cl_satz.php');

echo '<h2>Satz löschen</h2>'; 

$satz=new Satz(); 

if (isset($_GET["ID"])) {
  /* noch nicht gelöscht  */
  $satz->ID= $_GET["ID"]; 
  $satz->load_row(); 
  if (!isset($_POST["confirm"])) {
      echo '
      <form action="delete_satz.php" method="post">
      <p><b>Folgender Satz wird gelöscht: </b><br/>
      ID: '.$satz->ID.'  <br/>
      Nummer: '.$satz->Nr.'  <br/>
      Name:  '.$satz->Name.'  <br/><br/>

      <input class="btnDelete" type="submit" name="confirm" value="Löschung bestätigen">
      <input type="hidden" name="ID" value="' . $satz->ID . '">
      <input type="hidden" name="title" value="Satz löschen">        
      </form>
      </p> 
      <p> <a href="edit_satz.php?ID='. $satz->ID . '&title=Satz">Abbrechen / Zurück</a></p> 
      '; 
  } 
}

if (isset($_POST["confirm"])) {
  $satz->ID=$_POST["ID"]; 
  $satz->delete();       
}


include('foot.php');

?>

