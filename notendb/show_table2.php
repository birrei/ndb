<?php
include('head.php');

$table=$_GET['table'];

/* Bearbeiten-Links, table */
$table_edit=$table; 
if (substr($table,0,2)=='v_') {
  // Views (suffix v_): "v_" vorne abschneiden
  $table_edit=substr($table,2, strlen($table)-2); 
}

/* Bearbeiten-Links, title */
$edit_title=''; 
if (isset($_GET['title'])) {
  $edit_title=$_GET['title']; 
}

/* Anzeigen-Links */
$add_link_show=false; 
if (isset($_GET['add_link_show'])) {
  $add_link_show=true; 
}

/* Sortierung */
$sortcol='';
if (isset($_GET['sortcol'])) {
    $sortcol=$_GET['sortcol'];
}
if (isset($_GET['sortorder'])) {
    $sortorder=$_GET['sortorder'];
}
else {
    $sortorder='ASC';
}

$query = 'SELECT * FROM '.$table.($sortcol!='' ?' ORDER BY '.$sortcol.' '.$sortorder:'');

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
  echo '<h3>Objekt: '.$table.'</h3>'; 
  $html->print_table($table_edit, true,'', $edit_title); 
}
catch (PDOException $e) {
  include_once("cl_html_info.php"); 
  $info = new HtmlInfo();      
  $info->print_user_error(); 
  $info->print_error($select, $e); 
}


include('foot.php');
?>
