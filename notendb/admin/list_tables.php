<?php

include('../head.php');
include("../cl_html_table.php");    
include("../cl_html_info.php");  
include("../cl_db.php");

$query = 'show tables';

$conn = new DbConn(); 
$db=$conn->db; 
$select = $db->prepare($query); 
      
try {
    $select->execute();   
    $html = new HtmlTable($select); 
    $html->print_table_tablelist(); 
  }
  catch (PDOException $e) {
    $info = new HtmlInfo();      
    $info->print_user_error(); 
    $info->print_error($select, $e); 
  }

include('../foot.php');

?>
