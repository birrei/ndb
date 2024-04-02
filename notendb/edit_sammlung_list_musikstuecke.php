
<?php 
include('head_raw.php');

include("cl_musikstueck.php");
include("cl_sammlung.php");

$sammlung = new Sammlung(); 
$sammlung->ID = $_GET["SammlungID"]; 

// echo '<p>'.$sammlung->ID ; 

$musikstueck=new Musikstueck(); 
$musikstueck->SammlungID=$_GET["SammlungID"];  

if (isset($_GET["option"])){
  if($_GET["option"]=='insert') {
    $musikstueck->insert_row($_GET["Nummer"], $_GET["Name"]); 
  } 
}
$musikstueck->print_table_from_sammlung($_GET["SammlungID"]);

// echo $musikstueck->get_next_nummer(); 

echo '<p> <a href="edit_sammlung_add_musikstueck.php?SammlungID='.$_GET["SammlungID"].'">Musikstück hinzufügen</a></p>'; 
echo '<p> <a href="edit_sammlung_list_musikstuecke.php?SammlungID='.$_GET["SammlungID"].'">Aktualisieren</a></p>'; 
 
include('foot_raw.php');
?>
