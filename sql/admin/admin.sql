/* Info  */ 

--- mysql Version anzeigen  
    select version();

    -- alle Tabellen anzeigen 
    show tables;


    --- alle views anzeigen 
    SELECT *
    FROM information_schema.TABLES 
    WHERE TABLE_TYPE LIKE 'VIEW'; 

    --- sql für views löschen  
    SELECT CONCAT('DROP VIEW IF EXISTS ', TABLE_NAME, ';') as cmd  
    FROM information_schema.TABLES 
    WHERE TABLE_TYPE LIKE 'VIEW'; 


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


/* DDL */

/***** unique key erstellen  ******/
    ALTER TABLE satz_schwierigkeitsgrad
    ADD CONSTRAINT uc_satz_schwierigkeitsgrad 
    UNIQUE (SatzID, SchwierigkeitsgradID, InstrumentID)
    ;

/***** foreign key erstellen  ******/
    ALTER TABLE satz_schwierigkeitsgrad 
        ADD  FOREIGN KEY (SatzID) 
        REFERENCES satz(ID) 
        ON DELETE RESTRICT ON UPDATE RESTRICT
        ;



/***** constraint löschen ******/
-- MariaDB: 
    ALTER TABLE satz DROP CONSTRAINT satz_ibfk_4;

-- MySQL (ev. bis 5.7.)
    -- the "single command" doesn't work as MySQL (at least 5.7.28 and AFAIK 8.0 too) 
    -- doesn't support DROP FOREIGN KEY IF EXISTS syntax. MariaDB supports it. – 
    -- https://stackoverflow.com/questions/14122031/how-to-remove-constraints-from-my-mysql-table

    ALTER TABLE `table_name` DROP FOREIGN KEY `id_name_fk`;
    ALTER TABLE `table_name` DROP INDEX  `id_name_fk`;


/***** spalte ergänzen ******/
    ALTER TABLE `lookup_type` ADD `Bemerkung` VARCHAR(100) NULL ; 
    ALTER TABLE `erprobt` ADD `Jahr` YEAR; -- https://mariadb.com/kb/en/year-data-type/   

/***** spalte datentyp ändern ******/
    ALTER TABLE schwierigkeitsgrad CHANGE `ID` `ID` INT NOT NULL ; 
    show columns from schwierigkeitsgrad;

/** Spalte vergrößern *****/
    ALTER TABLE `satz` CHANGE `Orchesterbesetzung` `Orchesterbesetzung` varchar(250); 

/***** spalte löschen ******/
    ALTER TABLE my_table DROP IF EXISTS my_column;
    ALTER TABLE satz DROP COLUMN Lagen;



/****************************************************/
-- Der Datentyp einer Fremdschlüssel-Spalte soll geändert werden 
     
     ALTER TABLE `satz` DROP FOREIGN KEY `satz_ibfk_2`;

     ALTER TABLE satz CHANGE `ErprobtID` `ErprobtID` INT; 

     ALTER TABLE erprobt CHANGE `ID` `INT` INT; 





/** nachträglich AUTO_INCREMENT hinzufügen *****/


    ALTER TABLE satz_erprobt DROP FOREIGN KEY `satz_erprobt_ibfk_2`;

    ALTER TABLE  erprobt CHANGE `ID` `ID` INT NOT NULL AUTO_INCREMENT; 
 
    ALTER TABLE satz_erprobt 
    ADD  FOREIGN KEY (ErprobtID) 
    REFERENCES erprobt(ID) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
    ;


    SHOW COLUMNS FROM erprobt;
    select * from erprobt;