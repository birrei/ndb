<?php 

$PageTitle='DDL'; 
include('../head.php');
include("../../dbconn/cl_db.php"); 
include("../../cl_html_info.php");

?>
<p><a href="ddl.php?option=install_all">Installation starten</a></p>
<?php

/************************************************** */

if (isset($_GET["option"])) {

/****** Material ******** */

    // drop_table('material'); 
    // drop_table('materialtyp'); 
    
    // install_table_materialtyp(); 
    // install_table_material(); 
    
    install_view_v_material(); 

/******** Schüler ****** */
    // install_table_schueler(); 
    // install_table_schueler_schwierigkeitsgrad();
    // install_table_schueler_satz();

    // drop_table('schueler_material'); 
    // install_table_schueler_material(); 

    install_view_v_schueler(); 


}


/************************************************** */

function install_view_v_schueler() {

      $sql=" create or replace view v_schueler as 
             select 
                schueler.ID 
                , schueler.Name
                , GROUP_CONCAT(DISTINCT material.Name  order by material.Name SEPARATOR '; ') as Materialien
                , GROUP_CONCAT(DISTINCT concat(sammlung.Name, ' / ', musikstueck.Name, ' / ', satz.Name)  
                                        order by sammlung.Name, musikstueck.Nummer 
                        SEPARATOR '<br />') as Noten 

                , schueler.Bemerkung 
        from schueler 
            left join 
            schueler_material on schueler_material.SchuelerID = schueler.ID
            left join 
            material on material.ID = schueler_material.MaterialID 
            left join 
            schueler_satz on schueler_satz.SchuelerID  = schueler.ID 
            left join 
            satz on satz.ID = schueler_satz.SatzID 
            left join 
            musikstueck on musikstueck.ID = satz.MusikstueckID
            left join 
            sammlung on sammlung.ID = musikstueck.SammlungID
        group by schueler.ID 
        order by schueler.Name 
    "; 
    // $sql="
    //     create or replace view v_schueler as 
    //     select 
    //         schueler.ID 
    //         , schueler.Name
    //         , schueler.Bemerkung 
    //         -- , GROUP_CONCAT(DISTINCT material.Name  order by material.Name SEPARATOR '; ') as Materialien  
    //         , count(distinct material.ID) as Anzahl_Materialien          
    //         , count(distinct satz.ID) as Anzahl_Saetze      
    //     from schueler 
    //         left join 
    //         schueler_material on schueler_material.SchuelerID = schueler.ID
    //         left join 
    //         material on material.ID = schueler_material.MaterialID 
    //         left join 
    //         schueler_satz 
    //         on schueler_satz.SchuelerID  = schueler.ID 
    //         left join 
    //         satz 
    //         on satz.ID = schueler_satz.SatzID 
    //     group by schueler.ID        
	 
    // "; 
    execute_sql($sql, 'install view v_schueler'); 
}

function install_table_schueler_material() {
    $sql="
        CREATE TABLE schueler_material (
        ID INT NOT NULL AUTO_INCREMENT,
        SchuelerID INT DEFAULT NULL,
        MaterialID INT DEFAULT NULL, 
        Bemerkung VARCHAR(255) NULL, 
        PRIMARY KEY (ID),
        UNIQUE KEY uc_schueler_material (SchuelerID,MaterialID),
        -- KEY SatzID (SatzID),
        -- KEY SchuelerID (SchuelerID),
        CONSTRAINT fkey_schueler_material_SchuelerID FOREIGN KEY (SchuelerID) REFERENCES schueler (ID),
        CONSTRAINT fkey_schueler_material_MaterialID FOREIGN KEY (MaterialID) REFERENCES material (ID)
        )     
    "; 
    execute_sql($sql, 'schueler_material'); 
}
function install_view_v_material() {
    $sql="
        create or replace view v_material as
        select material.ID
            , material.Name
            , material.Bemerkung 
            , materialtyp.Name as Materialtyp
            , sammlung.Name as Sammlung 
          , GROUP_CONCAT(DISTINCT schueler.Name order by schueler.Name SEPARATOR '; ') as Schueler  
            , material.MaterialtypID 
            , material.SammlungID 
           -- , material.ts_insert 
           -- , material.ts_update            
        from material  
            LEFT JOIN 
            materialtyp on materialtyp.ID = material.MaterialtypID 
            left join 
            sammlung on sammlung.ID = material.SammlungID 
            left join 
            schueler_material on schueler_material.MaterialID  = material.ID 
            left join 
            schueler on schueler.ID=schueler_material.SchuelerID 
 group by material.ID 
    "; 
    execute_sql($sql, 'install view v_material'); 
}

function install_table_materialtyp() {
    $sql="CREATE TABLE IF NOT EXISTS materialtyp (
            ID TINYINT NOT NULL AUTO_INCREMENT 
            , Name VARCHAR(100) NOT NULL 
            , ts_insert datetime DEFAULT CURRENT_TIMESTAMP
            , ts_update datetime ON UPDATE CURRENT_TIMESTAMP        
            , PRIMARY KEY (ID)

        )"; 
    execute_sql($sql, 'install table materialtyp'); 
}

function install_table_material() {
    $sql="CREATE TABLE IF NOT EXISTS material (
            `ID` int(11) NOT NULL AUTO_INCREMENT,
            `Name` varchar(100) NOT NULL,
            `Bemerkung` varchar(255) DEFAULT NULL,
            `MaterialtypID` int(11) DEFAULT NULL,
            `SammlungID` int(10) unsigned DEFAULT NULL,            
            `ts_insert` datetime DEFAULT current_timestamp(),
            `ts_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),
            PRIMARY KEY (`ID`),
            KEY `MaterialtypID` (`MaterialtypID`),
            KEY `SammlungID` (`SammlungID`),
            CONSTRAINT `material_ibfk_1` FOREIGN KEY (`MaterialtypID`) REFERENCES `materialtyp` (`ID`),
            CONSTRAINT `material_ibfk_2` FOREIGN KEY (`SammlungID`) REFERENCES `sammlung` (`ID`)                   
        )"; 
    execute_sql($sql, 'install table material'); 
}
function install_table_schueler_satz() {
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
    execute_sql($sql); 
}
function install_table_schueler_schwierigkeitsgrad() {
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
        CONSTRAINT schueler_schwierigkeitsgrad_fkey_SchuelerID FOREIGN KEY (SchuelerID) REFERENCES schueler (ID),
        CONSTRAINT schueler_schwierigkeitsgrad_fkey_SchwierigkeitsgradID FOREIGN KEY (SchwierigkeitsgradID) REFERENCES schwierigkeitsgrad (ID),
        CONSTRAINT schueler_schwierigkeitsgrad_fkey_InstrumentID FOREIGN KEY (InstrumentID) REFERENCES instrument (ID)
        )     
    "; 
    execute_sql($sql); 
}
function install_table_schueler() {
    $sql="CREATE TABLE IF NOT EXISTS schueler (
            ID INT NOT NULL AUTO_INCREMENT 
            , Name VARCHAR(100) NOT NULL 
            , Bemerkung VARCHAR(255) NULL
            , ts_insert datetime DEFAULT CURRENT_TIMESTAMP
            , ts_update datetime ON UPDATE CURRENT_TIMESTAMP        
            , PRIMARY KEY (ID)
        )"; 
    execute_sql($sql); 
}

/**************************************** */

function execute_sql($sql, $info='') {
    // : Tabelle wird gelöscht und neu angelegt       
    $conn = new DbConn(); 
    $db=$conn->db; 
    echo '<pre>----------------'.$info.'---------------------</pre>'.PHP_EOL; 
    echo '<pre>'.$sql.PHP_EOL.'</pre>'.PHP_EOL; 
    $create = $db->prepare($sql); 
    try {
        $create->execute(); 
        print_info('OK'); 
    }
    catch (PDOException $e) {
        print_error($e->getMessage()); 
    }
}
function drop_table($table_name) {
    $sql='DROP TABLE IF EXISTS '.$table_name;
    execute_sql($sql, $sql) ; 
}
function print_info($strText) {
    echo '<pre style="color: green;">'; 
    echo $strText.PHP_EOL; 
    echo '</pre>'.PHP_EOL;     
}
function print_error($strText) {
    echo '<pre style="color: red;">'; 
    echo $strText.PHP_EOL; 
    echo '</pre>';     
}







include('../foot.php');

?>