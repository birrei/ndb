<?php 
/* 
Führt alle in ddl.sql enthaltenen SQLS aus. 
Die SQL-commands müssen durch ; voneinander getrennt sein. 
*/ 
include('head.php');
include("cl_db.php"); 


$file_name=$_GET['script'].'.sql';

$sql=''; 
$sqltext = file_get_contents($file_name, true);
$cmds = explode(';', $sqltext);

$conn = new DbConn(); 
$db=$conn->db; 

foreach($cmds as $cmd){
  $sql= trim($cmd); 
  $stmt = $db->prepare($sql); 
  echo '<p>/********************************************/<br />'; 

  try {    
    $stmt->execute(); 
    echo '<p>sql wurde ausgeführt: <br /><pre>'.$sql.'</pre>'; 

  }
  catch (PDOException $e) {
    include_once("cl_html_info.php"); 
    $info = new HtmlInfo();      
    $info->print_user_error(); 
    $info->print_error($stmt, $e); 
  }

}

include('foot.php');

?>
