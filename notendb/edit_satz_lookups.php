
<?php 
include_once('head_raw.php');
include_once("classes/class.satz.php");
include_once("classes/class.lookuptype.php");  

$satz=new Satz();
$satz->ID=$_GET["SatzID"]; 

if (isset($_GET["option"])){
    if($_GET["option"]=='insert') {
      if (isset($_GET["LookupID"])){
        if ($_GET["LookupID"]!='') {
          $satz->add_lookup($_GET["LookupID"]); 
        }
      }
    } 
    if($_GET["option"]=='delete') {
        $satz->delete_lookup($_GET["ID"]); 
    } 
}


echo '<div style="float:left">'; 

$satz->print_table_lookups(basename(__FILE__)); 

echo '</div>'; 

echo '&nbsp;<a href="edit_satz_lookup.php?SatzID='.$satz->ID.'" class="form-link">Hinzufügen</a>'; 


include_once('foot_raw.php');

?>
