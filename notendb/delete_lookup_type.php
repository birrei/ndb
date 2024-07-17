
<?php 
include('head.php');
include('cl_lookuptype.php');
include("cl_html_info.php");

echo '<h2>Besonderheit-Typ löschen</h2>'; 

$lookuptype=new Lookuptype(); 
$info=new HtmlInfo(); 


if (isset($_GET["ID"])) {
  /* Aufruf Lösch-Link edit_musikstueck.php  */
  $lookuptype->ID= $_GET["ID"]; 
  $lookuptype->load_row(); 
  if (!isset($_POST["confirm"])) {
      echo '
      <form action="delete_lookup_type.php" method="post">
      <p><b>Folgender Besonderheit-Typ wird gelöscht: </b>
      <br/>
      <br/>
      ID: '.$lookuptype->ID.'  <br/>
      Name:  '.$lookuptype->Name.'  <br/><br/>

      <input class="btnDelete" type="submit" name="confirm" value="Löschung bestätigen">
      <input type="hidden" name="ID" value="' . $lookuptype->ID . '">
      <input type="hidden" name="title" value="Lookuptype löschen">        
      </form>
      </p> 
      <p> <a href="edit_lookup_type.php?ID='. $lookuptype->ID . '&title=Lookuptype">Abbrechen / Zurück</a></p> 
      '; 
  } 
}

if (isset($_POST["confirm"])) {
  $lookuptype->ID=$_POST["ID"]; 
  if($lookuptype->delete()) { 
    $info->print_link_show_table($lookuptype->table_name, 'sortcol=Name', $lookuptype->Titles);     
  } else {
     $info->print_link_edit($lookuptype->table_name, $lookuptype->ID,$lookuptype->Title);
  }                   
}

include('foot.php');

?>

