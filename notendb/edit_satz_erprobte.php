
<?php 
include_once('head_raw.php');

include_once("classes/class.satz.php");
include_once("classes/class.satz_erprobt.php");

$satz=new Satz();
$satz->ID=$_GET["SatzID"]; 

if (isset($_GET["option"])){
    // XXX 
    // if($_GET["option"]=='insert') {
    //     if ($_GET["SchwierigkeitsgradID"]!='' & $_GET["InstrumentID"]!='') {
    //         $satz->add_erprobt(''); 
    //     }
    // } 

    if($_REQUEST["option"]=='delete') {
        $erprobt=new SatzErprobt(); 
        $erprobt->ID=$_REQUEST["ID"]; 

        if (isset($_POST["confirm"])) {
            $erprobt->delete(); 
        }
        else {
            echo '
            <form action="" method="post">
            <p>ID '.$erprobt->ID.' wird gelöscht 
            <input class="btnDelete" type="submit" name="confirm" value="Löschung bestätigen">
            <input type="hidden" name="ID" value="' . $erprobt->ID . '">  
            <input type="hidden" name="option" value="delete">        
            </form>
            </p>  '; 
        }

    }     
}



echo '<div style="float:left">'; 

// $satz->print_table_erprobte(basename(__FILE__)); 
$satz->print_table_erprobte(); 

echo '</div>'; 

echo '&nbsp;<a href="edit_satz_erprobt.php?SatzID='.$satz->ID.'&option=insert" class="form-link">Hinzufügen</a>'; 

    
include_once('foot_raw.php');

?>
