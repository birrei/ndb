
<?php 
include('head.php');
include_once("cl_db.php");

$query='SELECT * FROM abfragen'; 

$conn = new DbConn(); 
$db=$conn->db; 
$select = $db->prepare($query); 
      
try {
    $select->execute();   
    $html = new HtmlTable($select); 
    $html->print_table(); 
  }
  catch (PDOException $e) {
    $info = new HtmlInfo();      
    $info->print_user_error(); 
    $info->print_error($select, $e); 
  }


    



include('foot.php');

?>
