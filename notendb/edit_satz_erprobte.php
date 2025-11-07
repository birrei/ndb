<?php 
include_once('head_raw.php');

include_once("classes/class.satz.php");
include_once("classes/class.satz_erprobt.php");

$satz=new Satz();
$satz->ID=$_GET["SatzID"]; 

echo '<div style="float:left">'; 

$satz->print_table_erprobte(); 

echo '</div>'; 

echo '&nbsp;<a href="edit_satz_erprobt.php?SatzID='.$satz->ID.'&option=insert" class="form-link">Hinzufügen</a>'; 

include_once('foot_raw.php');
?>
