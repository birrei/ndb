
<?php 
include('head_raw.php');

include_once("cl_musikstueck.php");


$musikstueck=new Musikstueck();
$musikstueck->ID=$_GET["MusikstueckID"]; 

if (isset($_GET["option"])){
    if($_GET["option"]=='insert') {
        $musikstueck->add_besetzung($_GET["BesetzungID"]); 
    } 
    if($_GET["option"]=='delete') {
        $musikstueck->delete_besetzung($_GET["ID"]); // ID = musikstueck_besetzung.ID 
    } 
}


$musikstueck->print_table_besetzungen(basename(__FILE__)); 

echo '<p> <a href="edit_musikstueck_add_besetzung.php?MusikstueckID='.$musikstueck->ID.'">[Besetzung hinzufügen]</a></p>'; 

include('foot_raw.php');


?>
