
<?php 
include('head_raw.php');
include_once("cl_lookuptype.php");
include_once("cl_lookup.php");

$lookuptype=new Lookuptype();
$lookuptype->ID=$_GET["LookupTypeID"]; 


echo '<div style="float:left">'; 

$lookuptype->print_table_lookups('edit_lookup.php');

echo '</div>'; 

echo '&nbsp;<a href="edit_lookup.php?LookupTypeID='.$lookuptype->ID.'&option=insert&source=iframe" class="form-link">Hinzufügen</a>'; 

include('foot_raw.php');


?>
