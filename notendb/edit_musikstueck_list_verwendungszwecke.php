
<?php 
include('head_raw.php');

include_once("cl_musikstueck.php");

$musikstueck=new Musikstueck();
$musikstueck->ID=$_GET["MusikstueckID"]; 

if (isset($_GET["option"])){
    if($_GET["option"]=='insert' and isset($_GET["VerwendungszweckID"])) {
        $musikstueck->add_verwendungszweck($_GET["VerwendungszweckID"]); 
    } 
    if($_GET["option"]=='delete') {
        $musikstueck->delete_verwendungszweck($_GET["ID"]); // ID = musikstueck_verwendungszweck.ID 
    } 
}

$musikstueck->print_table_verwendungszwecke(basename(__FILE__)); 

echo '<p> <a href="edit_musikstueck_add_verwendungszweck.php?MusikstueckID='.$musikstueck->ID.'">[Verwendungszweck hinzufügen]</a></p>'; 

include('foot_raw.php');

?>
