
<?php 
include_once('head_raw.php');

include_once("classes/class.schuljahr.php");

$schuljahr = new Schuljahr(); 
$schuljahr->ID = $_REQUEST["SchuljahrID"]; 

echo '<div style="float:left">'; 

$schuljahr->print_table_ferien(); 

echo '</div>'; 

echo '&nbsp;<a href="edit_ferien.php?SchuljahrID='.$schuljahr->ID.'&option=insert" target="_blank" class="form-link">Hinzufügen</a>'; 

include_once('foot_raw.php');

?>
