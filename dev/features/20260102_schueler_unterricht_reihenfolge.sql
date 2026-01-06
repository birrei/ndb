


ALTER TABLE schueler DROP COLUMN Unterricht_Reihenfolge; 

ALTER TABLE schueler ADD Unterricht_Reihenfolge TINYINT Default 0;   




-- ALTER TABLE schueler 
--     ADD  FOREIGN KEY (Unterricht_Wochentag) 
--     REFERENCES wochentage(ID) 
--     ON DELETE RESTRICT ON UPDATE RESTRICT
--     ;
