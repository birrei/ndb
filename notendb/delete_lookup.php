
<?php 
include('head_raw.php');
include('cl_lookup.php');
include("cl_html_info.php");

echo '<h2>Besonderheit löschen</h2>'; 

$lookup=new Lookup(); 
$info=new HtmlInfo(); 

if (isset($_GET["ID"])) {
  $lookup->ID= $_GET["ID"]; 
  $lookup->load_row(); 
  if (!isset($_POST["confirm"])) {
  /* noch nicht gelöscht  */    
      echo '
      <form action="" method="post">
      <p><b>Folgende Besonderheit wird gelöscht: </b><br/><br/>
      ID: '.$lookup->ID.'  <br/>
      Name: '.$lookup->Name.'  <br/>
      Typ: '.$lookup->LookupTypeName.'  <br/>      
      <br/>

      <input class="btnDelete" type="submit" name="confirm" value="Löschung bestätigen">
      <input type="hidden" name="ID" value="' . $lookup->ID . '">
      <input type="hidden" name="title" value="Besonderheit löschen">        
      </form>
      </p> 
      <p> <a href="edit_lookup.php?ID='. $lookup->ID . '&title=Besonderheit">Abbrechen / Zurück</a></p> 
      '; 
  } 
}

if (isset($_POST["confirm"])) {
  $lookup->ID=$_POST["ID"]; 
  $lookup->load_row(); 
  if($lookup->delete()) { 
    echo '<p> <a href="edit_lookup_type_list_lookups.php?LookupTypeID='. $lookup->LookupTypeID .'">Zur Liste</a></p>'; 
    // echo '<p>Die Seite kann geschlossen werden.</p>';
    // $info->print_link_show_table('v_lookup', 'sortcol=Name', 'Besonderheiten');     
  } else {
    echo '<p> <a href="edit_lookup.php?ID='. $lookup->ID .'&title=Besonderheit">Abbrechen / Zurück</a></p>';  
  }                   
}

include('foot_raw.php');

?>

