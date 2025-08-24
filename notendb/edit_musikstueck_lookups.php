
<?php 
include_once('head_raw.php');
include_once("classes/class.musikstueck.php");
include_once("classes/class.lookuptype.php");  

$musikstueck=new Musikstueck();
$musikstueck->ID=$_GET["MusikstueckID"]; 

if (isset($_GET["option"])){
    if($_GET["option"]=='insert') {
      if (isset($_GET["LookupID"])){
        if ($_GET["LookupID"]!='') {
          $musikstueck->add_lookup($_GET["LookupID"]); 
        }
      }
    } 
    if($_GET["option"]=='delete') {
        $musikstueck->delete_lookup($_GET["ID"]); 
    } 
}


echo '<div style="float:left">'; 

$musikstueck->print_table_lookups(basename(__FILE__), 0); 

echo '</div>'; 

echo '&nbsp;<a href="edit_musikstueck_lookup.php?MusikstueckID='.$musikstueck->ID.'" class="form-link">Hinzufügen</a>'; 


include_once('foot_raw.php');

?>
