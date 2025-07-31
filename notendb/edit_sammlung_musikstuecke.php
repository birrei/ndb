
<?php 
include_once('head_raw.php');
include_once("classes/class.sammlung.php");

$sammlung=new Sammlung(); 
$sammlung->ID=$_GET["SammlungID"];  
$sammlung->print_table_musikstuecke2();

include_once('foot_raw.php');
?>
