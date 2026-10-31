<?php 
include_once('head_raw.php');
include_once("classes/class.satz.php");
include_once("classes/class.abschnitt.php");

echo '<div style="display: grid; grid-template-columns: auto auto;">'; 

$satz=new Satz();
$satz->ID=$_GET["SatzID"]; 
$satz->print_table_abschnitte(); 

echo '<p> <a href="edit_abschnitt.php?SatzID='.$satz->ID.'&option=insert" class="form-link">Hinzufügen</a> '; 

echo '</div>'; 

include_once('foot_raw.php');
?>
