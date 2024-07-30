
<?php 
include('head.php');
include('cl_verlag.php');
include("cl_html_info.php");

echo '<h2>Verlag löschen</h2>'; 

$verlag=new Verlag(); 
$info=new HtmlInfo(); 


if (isset($_GET["ID"])) {
  $verlag->ID= $_GET["ID"]; 
  $verlag->load_row(); 
  if (!isset($_POST["confirm"])) {
      echo '
      <form action="delete_verlag.php" method="post">
      <p><b>Folgender Verlag wird gelöscht: </b>
      <br/>
      <br/>
      ID: '.$verlag->ID.'  <br/>
      Name:  '.$verlag->Name.'  <br/><br/>

      <input class="btnDelete" type="submit" name="confirm" value="Löschung bestätigen">
      <input type="hidden" name="ID" value="' . $verlag->ID . '">
      <input type="hidden" name="title" value="Verlag löschen">        
      </form>
      </p> 
      '; 
      $info->print_link_edit($verlag->table_name,$verlag->ID,$verlag->Title,false);      
  } 
}

if (isset($_POST["confirm"])) {
  $verlag->ID=$_POST["ID"]; 
  if($verlag->delete()) { 
    $info->print_link_table($verlag->table_name, 'sortcol=Name', $verlag->Titles,false);     
  } else {
    $info->print_link_edit($verlag->table_name, $verlag->ID,$verlag->Title,'',false);
  }                   
}

include('foot.php');

?>

