
<?php 
include_once('head_raw.php');
include_once("classes/class.sammlung.php");
include_once("classes/class.lookuptype.php");  

$sammlung=new Sammlung();
$sammlung->ID=$_GET["SammlungID"]; 

if (isset($_GET["option"])){
    if($_GET["option"]=='insert') {
      if (isset($_GET["LookupID"])){
        if ($_GET["LookupID"]!='') {
          $sammlung->add_lookup($_GET["LookupID"]); 
        }
      }
    } 
    if($_GET["option"]=='delete') {
        $sammlung->delete_lookup($_GET["ID"]); 
    } 
}


echo '<div style="float:left">'; 

$sammlung->print_table_lookups(basename(__FILE__), 0); 

echo '</div>'; 

echo '&nbsp;<a href="edit_sammlung_lookup.php?SammlungID='.$sammlung->ID.'" class="form-link">Hinzufügen</a>'; 


include_once('foot_raw.php');

?>
