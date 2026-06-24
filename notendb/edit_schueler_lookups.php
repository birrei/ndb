
<?php 
include_once('head_raw.php');
include_once("classes/class.schueler.php");
include_once("classes/class.lookuptype.php");  

$schueler=new Schueler();
$schueler->ID=$_GET["SchuelerID"]; 

if (isset($_GET["option"])){
    if($_GET["option"]=='insert') {
      if (isset($_GET["LookupID"])){
        if ($_GET["LookupID"]!='') {
          $schueler->add_lookup($_GET["LookupID"]); 
        }
      }
    } 
    if($_GET["option"]=='delete') {
        $schueler->delete_lookup($_GET["ID"]); 
    } 
}


echo '<div style="float:left">'; 

$schueler->print_table_lookups(basename(__FILE__)); 

echo '</div>'; 

echo '&nbsp;<a href="edit_schueler_lookup.php?SchuelerID='.$schueler->ID.'" class="form-link">Hinzufügen</a>'; 


include_once('foot_raw.php');

?>
