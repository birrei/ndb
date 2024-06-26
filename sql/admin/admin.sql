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

    -- create def. 
    SHOW CREATE TABLE test.satz; 

    SHOW CREATE view test.v_sammlung


    select * 
    from INFORMATION_SCHEMA.KEY_COLUMN_USAGE
    where 1=1
    -- and table_schema='test'
    and table_name='musikstueck'
