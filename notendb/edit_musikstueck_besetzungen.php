
<?php 
include_once('head_raw.php');
include_once("classes/class.musikstueck.php");

$musikstueck=new Musikstueck();
$musikstueck->ID=$_GET["MusikstueckID"]; 

if (isset($_GET["option"])){
    if($_GET["option"]=='insert' and isset($_GET["BesetzungID"])) {
        if ($_GET["BesetzungID"]!='') {
            $musikstueck->add_besetzung($_GET["BesetzungID"]); 
        }
    } 
    if($_GET["option"]=='delete') {
        $musikstueck->delete_besetzung($_GET["ID"]); // ID = musikstueck_besetzung.ID 
    } 
}

echo '<div style="float:left">'; 

$musikstueck->print_table_besetzungen(basename(__FILE__)); 

echo '</div>'; 

echo '&nbsp;<a href="edit_musikstueck_besetzung.php?MusikstueckID='.$musikstueck->ID.'" class="form-link">Hinzufügen</a>'; 


include_once('foot_raw.php');


?>
