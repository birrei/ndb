
<?php 
include('head.php');
include('cl_lookup.php');
// include('cl_lookuptype.php');

echo '<h2>Besonderheit löschen</h2>'; 

$lookup=new Lookup(); 


if (isset($_GET["ID"])) {
  /* noch nicht gelöscht  */
  $lookup->ID= $_GET["ID"]; 
  $lookup->load_row(); 
 
  if (!isset($_POST["confirm"])) {
      echo '
      <form action="" method="post">
      <p><b>Folgende Besonderheit wird gelöscht: </b><br/><br/>
      ID: '.$lookup->ID.'  <br/>
      Name: '.$lookup->Name.'  <br/>
      Typ: '.$lookup->LookupTypeName.'  <br/>      
      <br/>

      <input class="btnDelete" type="submit" name="confirm" value="Löschung bestätigen">
      <input type="hidden" name="ID" value="' . $lookup->ID . '">
      <input type="hidden" name="title" value="Besonderheit löschen">        
      </form>
      </p> 
      <p> <a href="edit_lookup.php?ID='. $lookup->ID . '&title=Besonderheit">Abbrechen / Zurück</a></p> 
      '; 
  } 
}

if (isset($_POST["confirm"])) {
  $lookup->ID=$_POST["ID"]; 
  if($lookup->delete()) { 
    echo '<p>Die Seite kann geschlossen werden.</p>';
  } else {
    echo '<p> <a href="edit_lookup.php?ID='. $lookup->ID . '&title=Besonderheit">Abbrechen / Zurück</a></p>';  
  }       
              
}


include('foot.php');

?>

