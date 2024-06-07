<?php
include('head.php');

$table=$_GET['table'];
$table_edit=(substr($table,0,2)=='v_'?substr($table,2, strlen($table)-2):$table); // "v_" vorne abschneiden 


$edit_title=''; 
if (isset($_GET['title'])) {
  $edit_title=$_GET['title']; /* Title Ergänzung für den Bearbeiten-Link  */
}

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

$show_edit_link=false; // nur true setzen, wenn Tabelle eine Spalte ID besitzt und ein Bearbeitungsformular vorhanden ist 
if (isset($_GET['show_edit_link'])) {
    $show_edit_link=true;
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
  echo '<h3>Tabelle '.$table.'</h3>'; 
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
