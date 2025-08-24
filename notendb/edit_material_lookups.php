
<?php 
include_once('head_raw.php');
include_once("classes/class.material.php");
include_once("classes/class.lookuptype.php");  

$material=new Material();
$material->ID=$_GET["MaterialID"]; 

if (isset($_GET["option"])){
    if($_GET["option"]=='insert') {
      if (isset($_GET["LookupID"])){
        if ($_GET["LookupID"]!='') {
          $material->add_lookup($_GET["LookupID"]); 
        }
      }
    } 
    if($_GET["option"]=='delete') {
        $material->delete_lookup($_GET["ID"]); 
    } 
}


echo '<div style="float:left">'; 

$material->print_table_lookups(basename(__FILE__), 0); 

echo '</div>'; 

echo '&nbsp;<a href="edit_material_lookup.php?MaterialID='.$material->ID.'" class="form-link">Hinzufügen</a>'; 


include_once('foot_raw.php');

?>
