
<?php 
include_once('head_raw.php');
include_once("classes/class.sammlung.php");
include_once("classes/class.link.php");

$sammlung=new Sammlung(); 
$sammlung->ID=$_GET["SammlungID"];  


if (isset($_REQUEST["option"])){
    if($_REQUEST["option"]=='delete') {
        $link=new Link(); 
        $link->ID=$_REQUEST["ID"]; 

        if (isset($_POST["confirm"])) {
            $link->delete(); 
        }
        else {
            echo '
            <form action="" method="post">
            <p>ID '.$link->ID.' wird gelöscht 
            <input class="btnDelete" type="submit" name="confirm" value="Löschung bestätigen">
            <input type="hidden" name="ID" value="' . $link->ID . '">  
            <input type="hidden" name="option" value="delete">        
            </form>
            </p>  '; 
        }
    } 
}

echo '<div style="float:left">'; 

$sammlung->print_table_links();

echo '</div>'; 

echo '&nbsp;<a href="edit_sammlung_link.php?SammlungID='.$sammlung->ID.'&option=insert" class="form-link">Hinzufügen</a>'; 

include_once('foot_raw.php');
?>
