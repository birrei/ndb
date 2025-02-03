
<?php 
include('head_raw.php');
include("cl_sammlung.php");

$sammlung=new Sammlung(); 
$sammlung->ID=$_GET["SammlungID"];  
$sammlung->print_table_material();

include('foot_raw.php');
?>
