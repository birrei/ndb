
<?php 
include('head.php');
include('cl_verwendungszweck.php');
include("cl_html_info.php");

echo '<h2>Verwendungszweck löschen</h2>'; 

$verwendungszweck=new Verwendungszweck(); 
$info=new HtmlInfo(); 

if (isset($_GET["ID"])) {
  /* Aufruf Lösch-Link edit_musikstueck.php  */
  $verwendungszweck->ID= $_GET["ID"]; 
  $verwendungszweck->load_row(); 
  if (!isset($_POST["confirm"])) {
      echo '
      <form action="delete_verwendungszweck.php" method="post">
      <p><b>Folgende Verwendungszweck wird gelöscht: </b>
      <br/>
      <br/>
      ID: '.$verwendungszweck->ID.'  <br/>
      Name:  '.$verwendungszweck->Name.'  <br/><br/>

      <input class="btnDelete" type="submit" name="confirm" value="Löschung bestätigen">
      <input type="hidden" name="ID" value="' . $verwendungszweck->ID . '">
      <input type="hidden" name="title" value="Verwendungszweck löschen">        
      </form>
      </p> 
      <p> <a href="edit_verwendungszweck.php?ID='. $verwendungszweck->ID . '&title=Verwendungszweck">Abbrechen / Zurück</a></p> 
      '; 
  } 
}

if (isset($_POST["confirm"])) {
  $verwendungszweck->ID=$_POST["ID"]; 
  if($verwendungszweck->delete()) { 
    $info->print_link_show_table('verwendungszweck', 'sortcol=Name', 'Verwendungszwecke');     
  } else {
    $info->print_link_edit($verwendungszweck->table_name, $verwendungszweck->ID,$verwendungszweck->Title, '', false);
  }                   
}

include('foot.php');

?>

