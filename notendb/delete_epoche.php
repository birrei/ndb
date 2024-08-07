
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
      '; 
      $info->print_link_edit($epoche->table_name,$epoche->ID,$epoche->Title,false);
  } 
}

if (isset($_POST["confirm"])) {
  $epoche->ID=$_POST["ID"]; 
  if($epoche->delete()) { 
    echo '<p>Die Seite kann geschlossen werden.</p>';
    $info->print_link_table($epoche->table_name, 'sortcol=Name', $epoche->Titles, false);     
  } else {
    $info->print_link_edit($epoche->table_name, $epoche->ID,$epoche->Title,'',false);
  }                   
}

include('foot.php');

?>

