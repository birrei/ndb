
<?php 
include_once('head_raw.php');
include_once("classes/class.lookuptype.php");
include_once("classes/class.lookup.php");

$lookuptype=new Lookuptype();
$lookuptype->ID=$_GET["LookuptypeID"]; 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'';

switch($option) {
    case 'insert': // über edit_lookup_type_relation.php
        $lookuptype->add_relation($_REQUEST["RelationID"] ); 
    break;  

    case 'delete':
        $lookuptype->delete_relation($_GET["ID"]); // ID = musikstueck_besetzung.ID         
    break;  
}


echo '<div style="float:left">'; 

$lookuptype->print_table_relationen(basename(__FILE__));

echo '</div>'; 

echo '&nbsp;<a href="edit_lookup_type_relation.php?LookuptypeID='.$lookuptype->ID.'&option=insert&source=iframe" class="form-link">Hinzufügen</a>'; 

include_once('foot_raw.php');


?>
