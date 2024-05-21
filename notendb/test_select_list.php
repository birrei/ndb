<?php

include('head.php');
include("cl_html_table.php");    
include("cl_html_info.php");  
include("cl_lookup.php"); 

$query1 = 'select ID, Name from lookup_type order by ID';

include_once("cl_db.php");
$conn = new DbConn(); 
$db=$conn->db; 
$select = $db->prepare($query1); 
$select->execute(); 
//echo $select->columnCount(). PHP_EOL; 
$result = $select->fetchAll(PDO::FETCH_ASSOC);
// echo count($result). PHP_EOL; 

foreach ($result as $row) {
  echo $row["ID"] .' ' . $row["Name"].'<p>'; 
  $lookup=New Lookup(); 
  echo '<p>';     
  $lookup->print_select_multi($row["ID"]); 
  echo '</p>'; 
}





      
// try {
//     $select->execute();   
//     $html = new HtmlTable($select); 
//     // $html->show_table_link=True; 
//     $html->print_table(); 
//   }
//   catch (PDOException $e) {
//     $info = new HtmlInfo();      
//     $info->print_user_error(); 
//     $info->print_error($select, $e); 
//   }

include('foot.php');

?>
