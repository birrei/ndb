
<?php 
include('head.php');
include('cl_gattung.php');
include("cl_html_info.php");

echo '<h2>Gattung löschen</h2>'; 

$gattung=new Gattung(); 
$info=new HtmlInfo(); 

if (isset($_GET["ID"])) {
  $gattung->ID= $_GET["ID"]; 
  $gattung->load_row(); 
  if (!isset($_POST["confirm"])) {
      echo '
      <form action="delete_gattung.php" method="post">
      <p><b>Folgende Gattung wird gelöscht: </b>
      <br/>
      <br/>
      ID: '.$gattung->ID.'  <br/>
      Name:  '.$gattung->Name.'  <br/><br/>

      <input class="btnDelete" type="submit" name="confirm" value="Löschung bestätigen">
      <input type="hidden" name="ID" value="' . $gattung->ID . '">
      <input type="hidden" name="title" value="Gattung löschen">        
      </form>
      </p> 
      <p> <a href="edit_gattung.php?ID='. $gattung->ID . '&title=Gattung">Abbrechen / Zurück</a></p> 
      '; 
  } 
}

if (isset($_POST["confirm"])) {
  $gattung->ID=$_POST["ID"]; 
  if($gattung->delete()) { 
    $info->print_link_table($gattung->table_name, 'sortcol=Name', $gattung->Titles);      
  } else {
    $info->print_link_edit($gattung->table_name, $gattung->ID,$gattung->Title,'',false);
  }                   
}

include('foot.php');

?>

