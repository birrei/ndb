
<?php 
include('head.php');
include('cl_erprobt.php');
include("cl_html_info.php");

echo '<h2>Erprobt löschen</h2>'; 

$erprobt=new Erprobt(); 
$info=new HtmlInfo(); 

if (isset($_GET["ID"])) {
  $erprobt->ID= $_GET["ID"]; 
  $erprobt->load_row(); 
  if (!isset($_POST["confirm"])) {
      echo '
      <form action="delete_erprobt.php" method="post">
      <p><b>Folgendes Eprobt-Attribut wird gelöscht: </b>
      <br/>
      <br/>
      ID: '.$erprobt->ID.'  <br/>
      Name:  '.$erprobt->Name.'  <br/><br/>

      <input class="btnDelete" type="submit" name="confirm" value="Löschung bestätigen">
      <input type="hidden" name="ID" value="' . $erprobt->ID . '">
      <input type="hidden" name="title" value="Erprobt löschen">        
      </form>
      </p> 
      <p> <a href="edit_erprobt.php?ID='. $erprobt->ID . '&title=Erprobt">Abbrechen / Zurück</a></p> 
      '; 
  } 
}

if (isset($_POST["confirm"])) {
  $erprobt->ID=$_POST["ID"]; 
  if($erprobt->delete()) { 
    echo '<p>Die Seite kann geschlossen werden.</p>';
    $info->print_link_show_table('erprobt', 'sortcol=Name', 'Erprobt');     
  } else {
    echo '<p> <a href="edit_erprobt.php?ID='. $erprobt->ID .'&title=Erprobt">Abbrechen / Zurück</a></p>';  
  }                   
}

include('foot.php');

?>

