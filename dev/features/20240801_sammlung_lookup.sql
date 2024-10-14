drop TABLE IF EXISTS sammlung_lookup
; 
CREATE TABLE IF NOT EXISTS sammlung_lookup (
    `ID` int NOT NULL AUTO_INCREMENT     
    , `SammlungID` int(11) UNSIGNED  NOT NULL 
    , `LookupID` INT NOT NULL 
    , PRIMARY KEY (`ID`)   
) 
;


/*
select * from sammlung; 
select * from lookup order by ID desc; 
truncate table  sammlung_lookup ; 
insert into sammlung_lookup (SammlungID,LookupID) values(71,181) ; -- dev 
select * from sammlung_lookup;

*/

------------ Nachzug F-key 

-- delete from 
-- sammlung_lookup
-- USING 
-- sammlung_lookup 
-- left join sammlung on sammlung_lookup.SammlungID = sammlung.ID 
-- where sammlung.ID is null


ALTER TABLE sammlung_lookup 
    ADD  FOREIGN KEY (SammlungID) 
    REFERENCES sammlung(ID) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
    ;