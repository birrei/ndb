
<?php 
/** Link "Musikstücke sortieren". Wird in separatem Fenster/Registerblatt geöffnet */

$PageTitle='Sammlung Musikstücke Übersicht'; 
include_once('head.php');
include_once("classes/class.sammlung.php");
include_once("classes/class.musikstueck.php");

echo '<h3>'.$PageTitle.' - Sammlung ID: '.$_GET["SammlungID"].'</h3>'; 

$sammlung=new Sammlung(); 
$sammlung->ID=$_GET["SammlungID"]; 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'';

if(isset($_GET["ID"])){
    echo '<p>Aktive Aktion: Option "'.$option.'", Musikstück ID: '.$_GET["ID"].'. Seite neu laden um Aktion zu wiederholen oder <a href="'.basename(__FILE__).'?SammlungID='.$sammlung->ID.'">Aktion beenden</a></p>'; 
}

switch($option) {
    case 'order_up': 
        $musikstueck=new Musikstueck(); 
        $musikstueck->ID=$_GET["ID"]; 
        $musikstueck->move_order(-1); 
        
    break; 

    case 'order_down': 
        $musikstueck=new Musikstueck(); 
        $musikstueck->ID=$_GET["ID"]; 
        $musikstueck->move_order(1); 
        

    break; 
}



$sammlung->print_table_musikstuecke3(basename(__FILE__));

include_once('foot.php');
?>
