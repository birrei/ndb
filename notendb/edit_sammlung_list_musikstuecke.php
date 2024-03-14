
<?php 
include('head_raw.php');
include("cl_musikstueck.php");

if (isset($_GET["SammlungID"])) {
  $SammlungID=$_GET["SammlungID"]; 
  $musikstueck = new Musikstueck();
  $musikstueck->print_table_from_sammlung($SammlungID);
}
echo '<p> <a href="edit_sammlung_add_musikstueck.php?SammlungID='.$_GET["SammlungID"].'">Musikstück hinzufügen</a></p>'; 
echo '<p> <a href="edit_sammlung_list_musikstuecke.php?SammlungID='.$_GET["SammlungID"].'">Aktualisieren</a></p>'; 
 
include('foot_raw.php');
?>
