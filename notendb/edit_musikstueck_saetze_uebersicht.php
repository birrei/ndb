
<?php 
/** Link "Sätze sortieren". Wird in separatem Fenster/Registerblatt geöffnet */
$PageTitle='Musikstück Sätze Übersicht'; 

include_once('head.php');
include_once("classes/class.musikstueck.php");
include_once("classes/class.satz.php");

echo '<h3>'.$PageTitle.' - Musikstück ID: '.$_GET["MusikstueckID"].'</h3>'; 

$musikstueck = new Musikstueck(); 
$musikstueck->ID = $_GET["MusikstueckID"]; 

$option=isset($_REQUEST["option"])?$_REQUEST["option"]:'';

if(isset($_GET["ID"])){
    echo '<p>Aktive Aktion: Option "'.$option.'", Satz ID: '.$_GET["ID"].'. Seite neu laden um Aktion zu wiederholen oder <a href="'.basename(__FILE__).'?MusikstueckID='.$musikstueck->ID.'">Aktion beenden</a></p>'; 
}


switch($option) {
    case 'order_up': 
        $satz=new Satz(); 
        $satz->ID=$_GET["ID"]; 
        $satz->move_order(-1); 
        
    break; 

    case 'order_down': 
        $satz=new Satz(); 
        $satz->ID=$_GET["ID"]; 
        $satz->move_order(1); 
        
    break; 

    case 'rebase_numbers': 
        $musikstueck->rebase_numbers();  

    break;     
}


$musikstueck->print_table_saetze3(basename(__FILE__));

echo '<p><a href="'.basename(__FILE__).'?MusikstueckID='.$musikstueck->ID.'&option=rebase_numbers">Neu durchnummerieren</a></p>'; 


include_once('foot.php');

?>
