
<?php 
include('head_raw.php');
include('cl_link.php');

echo '<h2>Link löschen</h2>'; 

$link=new Link(); 

if (isset($_GET["ID"])) {
  $link->ID= $_GET["ID"]; 
  $link->load_row(); 
  if (!isset($_POST["confirm"])) {
      echo '
      <form action="delete_link.php" method="post">
      <p><b>Folgender Link wird gelöscht: </b><br/>
      ID: '.$link->ID.'  <br/>
      Bezeichnung: '.$link->Bezeichnung.'  <br/>
      URL:  '.$link->URL.'  <br/><br/>

      <input class="btnDelete" type="submit" name="confirm" value="Löschung bestätigen">
      <input type="hidden" name="ID" value="' . $link->ID . '">
      <input type="hidden" name="title" value="Link löschen">        
      </form>
      </p> 
      <p> <a href="edit_sammlung_list_links.php?ID='. $link->SammlungID . '&title=Link">Abbrechen / Zurück</a></p> 
      '; 
  } 
}

if (isset($_POST["confirm"])) {
  $link->ID=$_POST["ID"]; 
  $link->delete(); 
 // echo '<p>Die Seite kann geschlossen werden.</p>';  // hier nicht sinnvoll, da Unterformular      
              
}


include('foot_raw.php');

?>

