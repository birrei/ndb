<?php
include("dbconnect_pdo.php");
include('head.php');
include('snippets.php');

$table=$_GET['table'];
$table_edit=(substr($table,0,2)=='v_'?substr($table,2, strlen($table)-2):$table); // "v_" vorne abschneiden 


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

$select = $db->prepare($query);

try {
    $select->execute(); 
    // $html_table= get_html_table($select, $table, true);
    $html_table= get_html_table($select, $table_edit, false);  
    echo $html_table;  
}
catch (PDOException $e) {
    echo get_html_user_error_info(); 
    echo get_html_error_info($stmt, $e);      
}

include('foot.php');
?>
