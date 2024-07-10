
<?php 
include('head.php');
include('cl_instrument.php');

echo '<h2>Instrument löschen</h2>'; 

$instrument=new Instrument(); 

if (isset($_GET["ID"])) {
  /* Aufruf Lösch-Link edit_musikstueck.php  */
  $instrument->ID= $_GET["ID"]; 
  $instrument->load_row(); 
  if (!isset($_POST["confirm"])) {
      echo '
      <form action="delete_instrument.php" method="post">
      <p><b>Folgende Instrument wird gelöscht: </b>
      <br/>
      <br/>
      ID: '.$instrument->ID.'  <br/>
      Name:  '.$instrument->Name.'  <br/><br/>

      <input class="btnDelete" type="submit" name="confirm" value="Löschung bestätigen">
      <input type="hidden" name="ID" value="' . $instrument->ID . '">
      <input type="hidden" name="title" value="Instrument löschen">        
      </form>
      </p> 
      <p> <a href="edit_instrument.php?ID='. $instrument->ID . '&title=Instrument">Abbrechen / Zurück</a></p> 
      '; 
  } 
}

if (isset($_POST["confirm"])) {
  $instrument->ID=$_POST["ID"]; 
  $instrument->delete(); 
  echo '<p>Die Seite kann geschlossen werden.</p>';   
  $info->print_link_show_table('instrument', 'sortcol=Name', 'Instrumente'); 
}


include('foot.php');

?>

