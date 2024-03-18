
<?php 
include('head_raw.php');
include("dbconnect_pdo.php"); 
include("snippets.php");

if (isset($_GET["SammlungID"])) {

  $query = 'select ID, Name, Nummer from musikstueck where SammlungID='.$_GET["SammlungID"] ;
  $stmt = $db->query($query); // statement-Objekt 

  $html=get_html_table($stmt, 'musikstueck', true); 
  echo $html; 


}
include('foot_raw.php');

?>
