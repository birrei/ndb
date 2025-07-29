<?php 
include('head_raw.php');
include_once("classes/class.satz.php");
include_once("classes/class.schueler_satz.php");

echo '<div style="display: grid; grid-template-columns: auto auto;">'; 

$satz=new Satz();
$satz->ID=$_GET["SatzID"]; 
$satz->print_table_schueler(); 

echo '<p> <a href="edit_satz_schueler.php?SatzID='.$satz->ID.'&option=insert" class="form-link">Hinzufügen</a> 
          <a href="edit_satz_schuelers2.php?SatzID='.$satz->ID.'&option=edit" class="form-link">Schnell-Zuordnung</a></p>'; 

echo '</div>'; 

include('foot_raw.php');
?>
