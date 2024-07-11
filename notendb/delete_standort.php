
<?php 
include('head.php');
include('cl_standort.php');
include("cl_html_info.php");

echo '<h2>Standort löschen</h2>'; 

$standort=new Standort(); 
$info=new HtmlInfo(); 

if (isset($_GET["ID"]) & !isset($_POST["confirm"])) {
  $standort->ID= $_GET["ID"]; 
  $standort->load_row(); 
  echo '
    <form action="delete_standort.php" method="post">
    <p><b>Folgende Standort wird gelöscht: </b>
    <br/>
    <br/>
    ID: '.$standort->ID.'  <br/>
    Name: '.$standort->Name.'  <br/><br/>

    <input class="btnDelete" type="submit" name="confirm" value="Löschung bestätigen">
    <input type="hidden" name="ID" value="' . $standort->ID . '">
    <input type="hidden" name="title" value="Standort löschen">        
    </form>
    </p> 
    <p> <a href="edit_standort.php?ID='. $standort->ID . '&title=Standort">Abbrechen / Zurück</a></p> 
  '; 
  } 

if (isset($_POST["confirm"])) {
  $standort->ID=$_POST["ID"]; 
  if($standort->delete()) { 
    echo '<p>Die Seite kann geschlossen werden.</p>';
    $info->print_link_show_table('standort', 'sortcol=Name', 'Standorte');     
  } else {
    echo '<p> <a href="edit_standort.php?ID='. $standort->ID .'&title=Standort">Abbrechen / Zurück</a></p>';  
  }                   
}

include('foot.php');

?>

