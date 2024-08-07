
<?php 
include('head.php');
include('cl_instrument.php');
include("cl_html_info.php");

echo '<h2>Instrument löschen</h2>'; 

$instrument=new Instrument(); 
$info=new HtmlInfo(); 

if (isset($_GET["ID"])) {
  $instrument->ID= $_GET["ID"]; 
  $instrument->load_row(); 
  if (!isset($_POST["confirm"])) {
      echo '
      <form action="delete_instrument.php" method="post">
      <p><b>Folgende Instrument wird gelöscht: </b>
      <br/>
      <br/>
      ID: '.$instrument->ID.'  <br/>
      Name:  '.$instrument->Name.'  <br/><br/>

      <input class="btnDelete" type="submit" name="confirm" value="Löschung bestätigen">
      <input type="hidden" name="ID" value="' . $instrument->ID . '">
      <input type="hidden" name="title" value="Instrument löschen">        
      </form>
      </p>  '; 
      $info->print_link_edit($instrument->table_name,$instrument->ID,$instrument->Title,false);           
  } 
}

if (isset($_POST["confirm"])) {
  $instrument->ID=$_POST["ID"]; 
  if($instrument->delete()) { 
    $info->print_link_table($instrument->table_name, 'sortcol=Name', $instrument->Titles,false);     
  } else {
    $info->print_link_edit($instrument->table_name, $instrument->ID,$instrument->Title,'',false);
  }                       
}

include('foot.php');

?>

