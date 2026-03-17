<?php 

/* Updates bezogen auf eine bestimmte Tabelle  */

include_once('head.php');
include_once("../classes/class.kalender.php"); 

$tabelle=$_REQUEST['tabelle']; 

switch($tabelle) {

    case 'kalender':

        $kalender = new Kalender(); 
        $kalender->insert_data('2024-01-01', '2034-12-31', true); // XXX konfigurierbar einrichten 

        break; 
}

include_once('foot.php');
?>





