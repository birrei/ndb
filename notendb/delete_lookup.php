
<?php 
include('head_raw.php');
include('cl_lookup.php');
include("cl_html_info.php");

// echo '<h2>Besonderheit löschen</h2>'; 

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
      </p>    '; 
      $info->print_link_edit($lookup->table_name,$lookup->ID,$lookup->Title,false);             
  } 
}

if (isset($_POST["confirm"])) {
  $lookup->ID=$_POST["ID"]; 
  $lookup->load_row(); 
  if($lookup->delete()) { 
    echo '<p> <a href="edit_lookup_type_list_lookups.php?LookupTypeID='. $lookup->LookupTypeID .'">Zur Liste</a></p>';   
  } else {
    $info->print_link_edit($lookup->table_name, $lookup->ID,$lookup->Title,'',false);
  }                   
}

include('foot_raw.php');

?>

