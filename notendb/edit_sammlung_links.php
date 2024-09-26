
<?php 
include('head_raw.php');
include("cl_sammlung.php");
include("cl_link.php");

$sammlung=new Sammlung(); 
$sammlung->ID=$_GET["SammlungID"];  


if (isset($_GET["option"])){
    if($_GET["option"]=='delete') {
        $link=new Link(); 
        $link->ID=$_GET["ID"]; 
        $link->delete(); 
    } 
}

echo '<div style="float:left">'; 

$sammlung->print_table_links();

echo '</div>'; 

echo '&nbsp;<a href="edit_sammlung_link.php?SammlungID='.$sammlung->ID.'&option=insert" class="form-link">Hinzufügen</a>'; 


include('foot_raw.php');
?>
