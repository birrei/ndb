

ALTER TABLE schueler DROP COLUMN Unterricht_Wochentag; 

ALTER TABLE schueler ADD COLUMN Unterricht_Wochentag TINYINT Default 0; 





-- ALTER TABLE schueler 
--     ADD  FOREIGN KEY (Unterricht_Wochentag) 
--     REFERENCES wochentage(ID) 
--     ON DELETE RESTRICT ON UPDATE RESTRICT
--     ;
