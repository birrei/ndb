<?php
include('head.php');
include("cl_abfrage.php");
include("cl_html_info.php");

// echo '<h2>Abfrage bearbeiten</h2>'; 

$abfrage = new Abfrage();
$abfrage->ID=$_GET['ID'];
$abfrage->load_row(); 

$query = $abfrage->Abfrage; 
$table_edit = $abfrage->Tabelle; 
$edit_title=ucfirst($table_edit); 
$show_edit_link=true;

echo '<h3>'.$abfrage->Name.'</h3>'; 
echo '<h4>'.$abfrage->Beschreibung.'</h4>';

echo '<p><a href="edit_abfrage.php?ID='.$abfrage->ID.'&title=Abfrage">Abfrage bearbeiten</a></p> '; 

// echo '<pre>'.$query.'</pre>'; 

if ($query!='') {
  include_once("cl_db.php");
  $conn = new DbConn(); 
  $db=$conn->db; 
  
  $select = $db->prepare($query); 
    
  try {
    $select->execute(); 
    include_once("cl_html_table.php");      
    $html = new HtmlTable($select); 
   
    $html->print_table($table_edit, true,'', $edit_title); 
  }
  catch (PDOException $e) {
    include_once("cl_html_info.php"); 
    $info = new HtmlInfo();      
    $info->print_user_error(); 
    $info->print_error($select, $e); 
  }  
} else {
  echo '<p>Für diese Abfrage ist kein SQL-Code hinterlegt.</p>';  
}


include('foot.php');
?>
