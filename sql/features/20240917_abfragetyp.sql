/* Objekte: Abfrage soll eine Einteilung nach Abfragetyp erhalten */

ALTER TABLE abfrage DROP FOREIGN KEY IF EXISTS `fk_AbfragetypID`
;

ALTER TABLE abfrage DROP COLUMN IF EXISTS AbfragetypID
;

DROP TABLE IF EXISTS abfragetyp
; 

CREATE TABLE IF NOT EXISTS abfragetyp   (
    ID TINYINT NOT NULL AUTO_INCREMENT 
    , Name VARCHAR(100) NOT NULL 
    , PRIMARY KEY (ID)
)
;

ALTER TABLE `abfrage` ADD `AbfragetypID` TINYINT 
; 


ALTER TABLE abfrage 
ADD CONSTRAINT fk_AbfragetypID
FOREIGN KEY (AbfragetypID) 
REFERENCES abfragetyp(ID) 
ON DELETE RESTRICT 
ON UPDATE RESTRICT
;

/**********************************************/

INSERT INTO abfragetyp (Name) 
Values
     ('Vordefiniert')
    , ('Suche')     
    , ('Test')
    , ('Nachbearbeitung')
    
        
; 



select * from abfragetyp
;

select * from abfrage limit 1 
;


/**************************************/

UPDATE abfrage SET AbfragetypID=9 WHERE Beschreibung LIKE '%Vordefiniert%';


/*
-- sql\features\20240917_abfragetyp.sql

-- neu:        cl_abfragetyp.php 
-- neu:        edit_abfragetyp.php 
-- anpassen:   cl_abfrage.php 
-- anpassen:   edit_abfrage.php 
-- anpassen:   delete.php 
-- anpassen:   v_abfrage.sql 
-- anpassen:   suche.php -> Gespeicherte Abfrage 
-- anpassen:   show_table2.php, neues Feature dor: Filter für Tabellenanzeigen 
-- anpassen:   index.php Link auf Tabelle


admin/abfragen.php: Abfragtyp integrieren 




*/