<?php 
/* 
Führt alle in ddl.sql enthaltenen SQLS aus. 
Die SQL-commands müssen durch ; voneinander getrennt sein. 
*/ 
include('head.php');
include("dbconnect.php"); // nur wenn benötigt 

$file_name='ddl.sql'; 
$sqltext = file_get_contents($file_name, true);
$cmds = explode(';', $sqltext);
foreach($cmds as $cmd){
  if (mysqli_query( $db, $cmd)) {
     echo '<p>sql wurde ausgeführt: <br />'.$cmd; 
  }
  else 
  {
    echo '<p>Fehler: <br />'.pmysqli_error(); 
  } 
}

include('foot.php');

?>
