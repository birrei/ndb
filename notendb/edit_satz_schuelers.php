
<?php 
include('head_raw.php');

include_once("cl_satz.php");
include_once("cl_schueler_satz.php");

$satz=new Satz();
$satz->ID=$_GET["SatzID"]; 

echo '<div style="float:left">'; 

$satz->print_table_schueler(); 

echo '</div>'; 

echo '&nbsp;<a href="edit_satz_schueler.php?SatzID='.$satz->ID.'&option=insert" class="form-link">Hinzufügen</a>'; 
    
include('foot_raw.php');

?>
