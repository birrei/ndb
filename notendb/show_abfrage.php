<?php
include_once('head.php');
include_once("classes/class.abfrage.php");
include_once("classes/class.htmlinfo.php");

// echo '<h2>Abfrage bearbeiten</h2>'; 

$abfrage = new Abfrage();
$abfrage->ID=$_GET['ID'];

$info = new HTML_Info(); 

if ($abfrage->load_row()) {

  $query = $abfrage->Abfrage; 
  $table_edit = $abfrage->Tabelle; 
  $edit_title=ucfirst($table_edit); 
  $show_edit_link=true;

  echo '<h3>'.$abfrage->Name.'</h3>'; 
  echo '<pre>'.$abfrage->Beschreibung.'</pre>';

  $info->print_link_edit($abfrage->table_name, $abfrage->ID,$abfrage->Title,false, '<p></p>'); 

  // echo '<pre>'.$query.'</pre>'; 

  if ($query!='') {
    include_once("classes/dbconn/class.db.php");
    $conn = new DBConnection(); 
    $db=$conn->db; 
    
    $select = $db->prepare($query); 
      
    try {
      $select->execute(); 
      include_once("classes/class.htmltable.php");      
      $html = new HTML_Table($select); 
      if ($table_edit!='') {
        $html->edit_link_table=$table_edit;    
        $html->add_link_edit = true; 
      } else {
        $html->add_link_edit = false; 
      }
      $html->edit_link_open_newpage=true; 
      $html->print_table2();

    }
    catch (PDOException $e) {
      include_once("classes/class.htmlinfo.php"); 
      $info = new HTML_Info();      
      $info->print_user_error(); 
      $info->print_error($select, $e); 
    }  
  } else {
    echo '<p>Für diese Abfrage ist kein SQL-Code hinterlegt.</p>';  
  }
}

include_once('foot.php');
?>
