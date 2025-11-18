
<?php 
include_once('head_raw.php');
include_once("classes/class.uebung.php");
include_once("classes/class.lookuptype.php");  

$uebung=new Uebung();
$uebung->ID=$_GET["UebungID"]; 

if (isset($_GET["option"])){
    if($_GET["option"]=='insert') {
      if (isset($_GET["LookupID"])){
        if ($_GET["LookupID"]!='') {
          $uebung->add_lookup($_GET["LookupID"]); 
        }
      }
    } 
    if($_GET["option"]=='delete') {
        $uebung->delete_lookup($_GET["ID"]); 
    } 
}


echo '<div style="float:left">'; 

$uebung->print_table_lookups(basename(__FILE__)); 

echo '</div>'; 

echo '&nbsp;<a href="edit_uebung_lookup.php?UebungID='.$uebung->ID.'" class="form-link">Hinzufügen</a>'; 


include_once('foot_raw.php');

?>
