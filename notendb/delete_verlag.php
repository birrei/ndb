
<?php 
include('head.php');
include('cl_verlag.php');
include("cl_html_info.php");

echo '<h2>Verlag löschen</h2>'; 

$verlag=new Verlag(); 
$info=new HtmlInfo(); 


if (isset($_GET["ID"])) {
  /* Aufruf Lösch-Link edit_musikstueck.php  */
  $verlag->ID= $_GET["ID"]; 
  $verlag->load_row(); 
  if (!isset($_POST["confirm"])) {
      echo '
      <form action="delete_verlag.php" method="post">
      <p><b>Folgende Verlag wird gelöscht: </b>
      <br/>
      <br/>
      ID: '.$verlag->ID.'  <br/>
      Name:  '.$verlag->Name.'  <br/><br/>

      <input class="btnDelete" type="submit" name="confirm" value="Löschung bestätigen">
      <input type="hidden" name="ID" value="' . $verlag->ID . '">
      <input type="hidden" name="title" value="Verlag löschen">        
      </form>
      </p> 
      <p> <a href="edit_verlag.php?ID='. $verlag->ID . '&title=Verlag">Abbrechen / Zurück</a></p> 
      '; 
  } 
}

if (isset($_POST["confirm"])) {
  $verlag->ID=$_POST["ID"]; 
  if($verlag->delete()) { 
    echo '<p>Die Seite kann geschlossen werden.</p>';
    $info->print_link_show_table('verlag', 'sortcol=Name', 'Verlage');     
  } else {
    echo '<p> <a href="edit_verlag.php?ID='. $verlag->ID .'&title=Verlag">Abbrechen / Zurück</a></p>';  
  }                   
}

include('foot.php');

?>
