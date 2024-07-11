<?php
include('head.php');

$object=$_GET['table']; // obligatorisch 

/****************/
// optionale Übergabeparameter
$edit_table=''; // Tabelle, auf die im Bearbeiten-Link verwiesen werden soll.  
$sortcol='ID';  // Spalte, nach der sortiert werden soll, default: ID
$sortorder='ASC'; // Sortier-Reihenfolge, default aufwärts 
$edit_table_title=''; // Titel der Seite, die über den Bearbeiten-Link aufgerufen wird 
$add_link_show=false;  // true, falls eine zusätzlliche Spalte "Anzeigen" ergänzt werden soll
$edit_link_show_newpage=false; // true: Das öffnen des Bearbeiten-Links soll in einem neuen Fenster erfolgen 
$tables_exclude_insertlink=array('musikstueck','satz');
$tables_use_insertfile=array('lookup');

/*************** */

if (isset($_GET['edit_table'])) {
  $edit_table=$_GET['edit_table']; 
} else {
  $edit_table=$object; 
  if (substr($object,0,2)=='v_') {
    $edit_table=substr($object,2, strlen($object)-2);     // bei Views (suffix v_): "v_" vorne abschneiden
  }
}
if (isset($_GET['title'])) {
  $edit_table_title=$_GET['title']; 
}
if (isset($_GET['add_link_show'])) {
  $add_link_show=true; 
}
if (isset($_GET['sortcol'])) {
  $sortcol=$_GET['sortcol'];
} 
if (isset($_GET['sortorder'])) {
    $sortorder=$_GET['sortorder'];
}
if (isset($_GET['edit_link_show_newpage'])) {
  $edit_link_show_newpage=true; 
}

/*************** */

$query = 'SELECT * FROM '.$object.($sortcol!='' ?' ORDER BY '.$sortcol.' '.$sortorder:'');

// echo '<pre>'.$query.'</pre>'; 

include_once("cl_db.php");
$conn = new DbConn(); 
$db=$conn->db; 

$select = $db->prepare($query); 
  
try {
  $select->execute(); 
  include_once("cl_html_table.php");      
  $html = new HtmlTable($select); 
  $html->add_link_show=$add_link_show; 
  echo '<h3>'.$edit_table_title.'</h3>'; 
  
  // Link für Neu-Erfassung anzeigen? 
  if (!in_array($edit_table,$tables_exclude_insertlink)) {
    if (in_array($edit_table, $tables_use_insertfile)) {
      echo '<p><a href="insert_'.$edit_table.'.php?title='.$edit_table_title.'&option=insert">Neu erfassen</a></p>';
    }
    else {
      echo '<p><a href="edit_'.$edit_table.'.php?title='.$edit_table_title.'&option=insert">Neu erfassen</a></p>';
    }      
  }
  $html->print_table($edit_table, $edit_link_show_newpage,'', $edit_table_title); 
}
catch (PDOException $e) {
  include_once("cl_html_info.php"); 
  $info = new HtmlInfo();      
  $info->print_user_error(); 
  $info->print_error($select, $e); 
}


include('foot.php');
?>
