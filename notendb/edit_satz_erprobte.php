
<?php 
include('head_raw.php');

include_once("cl_satz.php");
include_once("cl_satz_erprobt.php");

$satz=new Satz();
$satz->ID=$_GET["SatzID"]; 

if (isset($_GET["option"])){
    if($_GET["option"]=='insert') {
        if ($_GET["SchwierigkeitsgradID"]!='' & $_GET["InstrumentID"]!='') {
            $satz->add_erprobt(''); 
        }
    } 

    if($_GET["option"]=='delete') {
        $erprobt=new SatzErprobt(); 
        $erprobt->ID=$_GET["ID"]; 
        $erprobt->delete(); 
    }     
}

if (isset($_GET["option"])){

}



echo '<div style="float:left">'; 

// $satz->print_table_erprobte(basename(__FILE__)); 
$satz->print_table_erprobte(); 

echo '</div>'; 

echo '&nbsp;<a href="edit_satz_erprobt.php?SatzID='.$satz->ID.'&option=insert" class="form-link">Hinzufügen</a>'; 

    
include('foot_raw.php');

?>
