<?php 

/* Updates bezogen auf eine bestimmte Tabelle  */

include_once('head.php');
include_once("../classes/class.kalender.php"); 

$tabelle=$_REQUEST['tabelle']; 

switch($tabelle) {

    case 'kalender':

        $date_start=(isset($_REQUEST["date_start"])?$_REQUEST["date_start"]:''); 
        $date_end=(isset($_REQUEST["date_end"])?$_REQUEST["date_end"]:''); 

        echo '<form action="" method="get">'.PHP_EOL;  
        echo 'Start: <input type="date" name="date_start" value="'.$date_start.'">'; 
        echo 'Ende: <input type="date" name="date_end" value="'.$date_end.'">'; 
        echo '<input type="submit" class="btnSave" name="senden" value="Start">';
        echo '<input type="hidden" name="tabelle" value="'.$tabelle.'">'; 
        echo '</form><br>';       


        if($date_start!='' & $date_end!='') {
            $kalender = new Kalender(); 
            $kalender->insert_data( $date_start,  $date_end, true); // 

        } else {
            echo '<p>Bitte Start- und Enddatum auswählen. </p>'; 
        }
        break; 
    case 'schueler_kalender':
        
        break; 
}

include_once('foot.php');
?>





