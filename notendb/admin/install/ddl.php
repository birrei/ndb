<?php 

include('../head.php');
include("../../dbconn/cl_db.php"); 
include("../../cl_html_info.php");



// echo '<p><a href="ddl.php?table=schueler&option=update">Tabelle Schüler installieren</a></p>';

?>
<p> 
<!--  
option: 
    overwrite: Tabelle wird gelöscht und neu angelegt 
    update: nur Änderungen an bestehender Tabelle (Daten bleiben erhalten)
--> 
</p> 

<?php
$overwrite=true; 

// install_schueler($overwrite); 

install_schueler_schwierigkeitsgrad($overwrite); 


/************************************************** */

function install_schueler($overwrite=false) {
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
function install_schueler_schwierigkeitsgrad($overwrite=false) {
    $sql="
        CREATE TABLE `schueler_schwierigkeitsgrad` (
        `ID` INT NOT NULL AUTO_INCREMENT,
        `SchuelerID` INT NOT NULL,
        `SchwierigkeitsgradID` INT UNSIGNED NOT NULL, -- XXX 
        `InstrumentID` INT NOT NULL,
        PRIMARY KEY (`ID`),
        UNIQUE KEY `uc_satz_schwierigkeitsgrad` (`SchuelerID`,`SchwierigkeitsgradID`,`InstrumentID`),
        KEY `SchwierigkeitsgradID` (`SchwierigkeitsgradID`),
        KEY `InstrumentID` (`InstrumentID`),
        CONSTRAINT `fkey_SchuelerID` FOREIGN KEY (`SchuelerID`) REFERENCES `schueler` (`ID`),
        CONSTRAINT `fkey_SchwierigkeitsgradID` FOREIGN KEY (`SchwierigkeitsgradID`) REFERENCES `schwierigkeitsgrad` (`ID`),
        CONSTRAINT `satz_InstrumentID` FOREIGN KEY (`InstrumentID`) REFERENCES `instrument` (`ID`)
        )     
    "; 
    install_table('schueler_schwierigkeitsgrad', $sql, $overwrite); 
}


function install_table($table_name, $sql, $overwrite) {
    // $overwrite: Tabelle wird gelöscht und neu angelegt 
    $info = new HtmlInfo();        
    $conn = new DbConn(); 
    $db=$conn->db; 

    if ($overwrite) {
        $drop = $db->prepare("DROP TABLE IF EXISTS ".$table_name.""); 
        try {
            $drop->execute(); 
            $info ->print_info("dropped: table ".$table_name."");
        }
        catch (PDOException $e) {
            $info->print_user_error(); 
            $info->print_error($drop, $e); 
        }        
    }
    $create = $db->prepare($sql); 
    try {
        $create->execute(); 
        $info ->print_info("created: table ".$table_name."");        
    }
    catch (PDOException $e) {
        $info = new HtmlInfo();      
        $info->print_user_error(); 
        $info->print_error($create, $e); 
    }

}





include('../foot.php');

?>