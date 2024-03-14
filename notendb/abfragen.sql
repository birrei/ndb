SELECT CONCAT('DROP VIEW IF EXISTS ', TABLE_NAME, ';') as cmd  
FROM information_schema.TABLES 
WHERE TABLE_TYPE LIKE 'VIEW'; 

SHOW COLUMNS FROM test.verlag; 


/* nicht verwendete verlage löschen */ 
delete from verlag where ID not in (select distinct VerlagID from sammlung where VerlagID is not NULL)  