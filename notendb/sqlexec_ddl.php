<?php 
/* 
Führt alle in ddl.sql enthaltenen SQLS aus. 
Die SQL-commands müssen durch ; voneinander getrennt sein. 
*/ 
include('head.php');
include("dbconnect.php"); // nur wenn benötigt 

$file_name=$_GET['script'].'.sql';

$sql=''; 
$sqltext = file_get_contents($file_name, true);
$cmds = explode(';', $sqltext);
foreach($cmds as $cmd){
  $sql= trim($cmd); 
  echo '<p>sql wird ausgeführt: <br /><pre>'.$sql.'</pre>'; 
  if (mysqli_query( $db, $sql)) {
    echo '<p>OK</p>';  
  }
  else  {
    echo '<p>Fehler: <br />'.pmysqli_error(); 
  } 
}


include('foot.php');

?>
