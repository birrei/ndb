
<?php 
include('head.php');
include('cl_epoche.php');
include("cl_html_info.php");

echo '<h2>Epoche löschen</h2>'; 

$epoche=new Epoche(); 
$info=new HtmlInfo(); 

if (isset($_GET["ID"])) {
  $epoche->ID= $_GET["ID"]; 
  $epoche->load_row(); 
  if (!isset($_POST["confirm"])) {
      echo '
      <form action="delete_epoche.php" method="post">
      <p><b>Folgende Epoche wird gelöscht: </b>
      <br/>
      <br/>
      ID: '.$epoche->ID.'  <br/>
      Name:  '.$epoche->Name.'  <br/><br/>

      <input class="btnDelete" type="submit" name="confirm" value="Löschung bestätigen">
      <input type="hidden" name="ID" value="' . $epoche->ID . '">
      <input type="hidden" name="title" value="Epoche löschen">        
      </form>
      </p> 
      <p> <a href="edit_epoche.php?ID='. $epoche->ID . '&title=Epoche">Abbrechen / Zurück</a></p> 
      '; 
  } 
}

if (isset($_POST["confirm"])) {
  $epoche->ID=$_POST["ID"]; 
  if($epoche->delete()) { 
    echo '<p>Die Seite kann geschlossen werden.</p>';
    $info->print_link_show_table('epoche', 'sortcol=Name', 'Epocheen');     
  } else {
    echo '<p> <a href="edit_epoche.php?ID='. $epoche->ID .'&title=Epoche">Abbrechen / Zurück</a></p>';  
  }                   
}

include('foot.php');

?>

