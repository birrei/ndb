/* Datenbank */ 

--- Version 
    select version();

    -- alle Tabellen anzeigen 
    show tables;

    --- alle views anzeigen 
    SELECT CONCAT('DROP VIEW IF EXISTS ', TABLE_NAME, ';') as cmd  
    FROM information_schema.TABLES 
    WHERE TABLE_TYPE LIKE 'VIEW'; 


/* Objekte */

    /* Info Tabelle */ 
    describe test.verlag

    /* Spalten einer Tabelle anzeigen */ 
    SHOW COLUMNS FROM satz; 

    /*Tabellendef anzeigen */
    SHOW CREATE TABLE test.satz; 

    SHOW CREATE view test.v_sammlung


    select * 
    from INFORMATION_SCHEMA.KEY_COLUMN_USAGE
    where 1=1
    -- and table_schema='test'
    and table_name='musikstueck'


/* Foreign keys anzeigen */

USE INFORMATION_SCHEMA;
SELECT TABLE_NAME,
       COLUMN_NAME,
       CONSTRAINT_NAME,
       REFERENCED_TABLE_NAME,
       REFERENCED_COLUMN_NAME
FROM KEY_COLUMN_USAGE
WHERE 1=1 
aND TABLE_SCHEMA = 'test' 
      AND TABLE_NAME = 'satz'
      AND REFERENCED_COLUMN_NAME IS NOT NULL;


/***** foreign key löschen ******/


ALTER TABLE `lookup_type` ADD `Bemerkung` VARCHAR(100) NULL ; 


ALTER TABLE satz DROP CONSTRAINT satz_ibfk_4;


ALTER TABLE schwierigkeitsgrad CHANGE `ID` `ID` INT NOT NULL ; 
show columns from schwierigkeitsgrad;

/** Spalte vergrößern *****/
ALTER TABLE `satz` CHANGE `Orchesterbesetzung` `Orchesterbesetzung` varchar(250); 
