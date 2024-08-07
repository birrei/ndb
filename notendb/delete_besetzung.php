
<?php 
include('head.php');
include('cl_besetzung.php');
include("cl_html_info.php");

echo '<h2>Besetzung löschen</h2>'; 

$besetzung=new Besetzung(); 
$info=new HtmlInfo(); 


if (isset($_GET["ID"])) {
  /* Aufruf Lösch-Link edit_musikstueck.php  */
  $besetzung->ID= $_GET["ID"]; 
  $besetzung->load_row(); 
  if (!isset($_POST["confirm"])) {
      echo '
      <form action="delete_besetzung.php" method="post">
      <p><b>Folgende Besetzung wird gelöscht: </b>
      <br/>
      <br/>
      ID: '.$besetzung->ID.'  <br/>
      Name:  '.$besetzung->Name.'  <br/><br/>

      <input class="btnDelete" type="submit" name="confirm" value="Löschung bestätigen">
      <input type="hidden" name="ID" value="' . $besetzung->ID . '">
      <input type="hidden" name="title" value="Besetzung löschen">        
      </form>
      </p> 
      '; 
      $info->print_link_edit($besetzung->table_name,$besetzung->ID,$besetzung->Title,false); 
  } 
}

if (isset($_POST["confirm"])) {
  $besetzung->ID=$_POST["ID"]; 
  if($besetzung->delete()) { 
    $info->print_link_table($besetzung->table_name, 'sortcol=Name', $besetzung->Titles, false);     
  } else {
    $info->print_link_edit($besetzung->table_name, $besetzung->ID,$besetzung->Title,'',false);     
  }                   
}

include('foot.php');

?>

