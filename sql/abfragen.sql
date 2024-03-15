SELECT CONCAT('DROP VIEW IF EXISTS ', TABLE_NAME, ';') as cmd  
FROM information_schema.TABLES 
WHERE TABLE_TYPE LIKE 'VIEW'; 

/* Spalten einer Tabelle anzeigen */ 
SHOW COLUMNS FROM test.satz; 


/* nicht verwendete verlage löschen */ 
delete from verlag where ID not in (select distinct VerlagID from sammlung where VerlagID is not NULL)  


delete from sammlung where ID not in (select distinct SammlungID from musikstueck where SammlungID is not null) 
