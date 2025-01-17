<?php 

include('../head.php');
include("../../dbconn/cl_db.php"); 
include("../../cl_html_info.php");

echo '<p><a href="ddl.php?option=install_all">Installation starten</a></p>';

?>
<p> 

</p> 

<?php

$overwrite=true; // true: Tabelle wird gelöscht und neu angelegt 

/************************************************** */

if (isset($_GET["option"])) {

    // install_schueler($overwrite); 
    // install_schueler_schwierigkeitsgrad($overwrite);
    install_schueler_satz($overwrite);
    
    // echo '<p> Aktuell ist keine Installationsaufgabe aktiviert (Ablauf noch in Entwicklung) </p>'; 
    
    


}


/************************************************** */

function install_schueler_satz($overwrite=false) {
    $sql="
        CREATE TABLE schueler_satz (
        ID INT NOT NULL AUTO_INCREMENT,
        SchuelerID INT DEFAULT NULL,
        SatzID INT UNSIGNED NULL, -- XXX 
        Bemerkung VARCHAR(255) NULL, 
        PRIMARY KEY (ID),
        UNIQUE KEY uc_schueler_satz (SchuelerID,SatzID),
        KEY SatzID (SatzID),
        KEY SchuelerID (SchuelerID),
        CONSTRAINT fkey_schueler_satz_SchuelerID FOREIGN KEY (SchuelerID) REFERENCES schueler (ID),
        CONSTRAINT fkey_schueler_satz_SatzID FOREIGN KEY (SatzID) REFERENCES satz (ID)
        )     
    "; 
    install_table('schueler_satz', $sql, $overwrite); 
}

function install_schueler_schwierigkeitsgrad($overwrite=false) {
    $sql="
        CREATE TABLE schueler_schwierigkeitsgrad (
        ID INT NOT NULL AUTO_INCREMENT,
        SchuelerID INT NOT NULL,
        SchwierigkeitsgradID INT UNSIGNED NOT NULL, -- XXX 
        InstrumentID INT NOT NULL,
        PRIMARY KEY (ID),
        UNIQUE KEY uc_schueler_schwierigkeitsgrad (SchuelerID,SchwierigkeitsgradID,InstrumentID),
        KEY SchwierigkeitsgradID (SchwierigkeitsgradID),
        KEY InstrumentID (InstrumentID),
        -- XXX umbenennen, vergl. 'schueler_satz'': 
        CONSTRAINT fkey_SchuelerID FOREIGN KEY (SchuelerID) REFERENCES schueler (ID),
        CONSTRAINT fkey_SchwierigkeitsgradID FOREIGN KEY (SchwierigkeitsgradID) REFERENCES schwierigkeitsgrad (ID),
        CONSTRAINT fkey_InstrumentID FOREIGN KEY (InstrumentID) REFERENCES instrument (ID)
        )     
    "; 
    install_table('schueler_schwierigkeitsgrad', $sql, $overwrite); 
}

function install_schueler($overwrite=false) {
    $sql="CREATE TABLE IF NOT EXISTS schueler (
            ID INT NOT NULL AUTO_INCREMENT 
            , Name VARCHAR(100) NOT NULL 
            , Bemerkung VARCHAR(255) NULL
            , ts_insert datetime DEFAULT CURRENT_TIMESTAMP
            , ts_update datetime ON UPDATE CURRENT_TIMESTAMP        
            , PRIMARY KEY (ID)
        )"; 
        install_table('schueler', $sql, $overwrite); 
}

function install_table($table_name, $sql, $overwrite) {
    // $overwrite: Tabelle wird gelöscht und neu angelegt 
    $info = new HtmlInfo();        
    $conn = new DbConn(); 
    $db=$conn->db; 

    echo '<pre>'.$sql.'</p>'; 

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