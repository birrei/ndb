
<?php 
include_once('head_raw.php');

include_once("classes/class.musikstueck.php");

$musikstueck=new Musikstueck();
$musikstueck->ID=$_GET["MusikstueckID"]; 

if (isset($_GET["option"])){
    if($_GET["option"]=='insert' and isset($_GET["VerwendungszweckID"])) {
        if ($_GET["VerwendungszweckID"]!='') {
         $musikstueck->add_verwendungszweck($_GET["VerwendungszweckID"]); 
        }
    } 
    if($_GET["option"]=='delete') {
        $musikstueck->delete_verwendungszweck($_GET["ID"]); // ID = musikstueck_verwendungszweck.ID 
    } 
}


echo '<div style="float:left">'; 

$musikstueck->print_table_verwendungszwecke(basename(__FILE__)); 

echo '</div>'; 

echo '&nbsp;<a href="edit_musikstueck_verwendungszweck.php?MusikstueckID='.$musikstueck->ID.'" class="form-link">Hinzufügen</a>'; 


include_once('foot_raw.php');

?>
