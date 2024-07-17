
<?php 
include('head.php');
include('cl_komponist.php');
include("cl_html_info.php");

echo '<h2>Komponist löschen</h2>'; 

$komponist=new Komponist(); 
$info=new HtmlInfo(); 

if (isset($_GET["ID"]) & !isset($_POST["confirm"])) {
  $komponist->ID= $_GET["ID"]; 
  $komponist->load_row(); 
  echo '
    <form action="delete_komponist.php" method="post">
    <p><b>Folgende Komponist wird gelöscht: </b>
    <br/>
    <br/>
    ID: '.$komponist->ID.'  <br/>
    Name: '.$komponist->Vorname.'  '.$komponist->Nachname.'  <br/><br/>

    <input class="btnDelete" type="submit" name="confirm" value="Löschung bestätigen">
    <input type="hidden" name="ID" value="' . $komponist->ID . '">
    <input type="hidden" name="title" value="Komponist löschen">        
    </form>
    </p> 
    <p> <a href="edit_komponist.php?ID='. $komponist->ID . '&title=Komponist">Abbrechen / Zurück</a></p> 
  '; 
  } 

if (isset($_POST["confirm"])) {
  $komponist->ID=$_POST["ID"]; 
  if($komponist->delete()) { 
    $info->print_link_show_table($komponist->table_name, 'sortcol=Nachname,Vorname', $komponist->Titles,false);     
  } else {
    $info->print_link_edit($komponist->table_name, $komponist->ID,$komponist->Title,'',false);
  }                       
}

include('foot.php');

?>

