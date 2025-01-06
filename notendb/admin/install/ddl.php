<?php 

include('../head.php');
include("../../dbconn/cl_db.php"); 
include("../../cl_html_info.php");



echo '<p><a href="ddl.php?table=schueler&option=update">Tabelle Schüler installieren</a></p>';

?>
<p> 
<!--  
option: 
    overwrite: Tabelle wird gelöscht und neu angelegt 
    update: nur Änderungen an bestehender Tabelle (Daten bleiben erhalten)
--> 
</p> 

<?php


if(isset($_GET["option"])) {
    $overwrite=($_GET["option"]=='overwrite'?true:false); 

}

 if (isset($_GET["table"])) {
    switch($_GET["table"]) {
        case 'schueler'; 
            install_Schueler($overwrite); 
        break; 
    }
 }

/************************************************** */

function install_Schueler($overwrite=false) {
    $info = new HtmlInfo();        
    $conn = new DbConn(); 
    $db=$conn->db; 
    if ($overwrite) {
        $drop = $db->prepare("DROP TABLE IF EXISTS schueler"); 
        try {
            $drop->execute(); 
            $info ->print_info("dropped: table 'schueler'");
        }
        catch (PDOException $e) {
            $info->print_user_error(); 
            $info->print_error($drop, $e); 
        }        
    }
    $sql="CREATE TABLE IF NOT EXISTS schueler (
            ID INT NOT NULL AUTO_INCREMENT 
            , Name VARCHAR(100) NOT NULL 
            , Bemerkung VARCHAR(255) NULL
            , ts_insert datetime DEFAULT CURRENT_TIMESTAMP
            , ts_update datetime ON UPDATE CURRENT_TIMESTAMP        
            , PRIMARY KEY (ID)
        )"; 

    $create = $db->prepare($sql); 

    try {
        $create->execute(); 
        $info ->print_info("created: table 'schueler'.");        
    }
    catch (PDOException $e) {
        $info = new HtmlInfo();      
        $info->print_user_error(); 
        $info->print_error($create, $e); 
    }










}

include('../foot.php');

?>