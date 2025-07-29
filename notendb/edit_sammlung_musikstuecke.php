
<?php 
include('head_raw.php');
include("classes/class.sammlung.php");

$sammlung=new Sammlung(); 
$sammlung->ID=$_GET["SammlungID"];  
$sammlung->print_table_musikstuecke2();

include('foot_raw.php');
?>
