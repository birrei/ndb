
<?php 
include_once('head_raw.php');
include_once("classes/class.sammlung.php");

$sammlung=new Sammlung(); 
$sammlung->ID=$_GET["SammlungID"];  
$sammlung->print_table_material();

include_once('foot_raw.php');
?>
