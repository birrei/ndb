-- Übung, Auswahl Besonderheiten 

drop TABLE IF EXISTS uebung_lookup
; 
CREATE TABLE IF NOT EXISTS uebung_lookup (
    `ID` int NOT NULL AUTO_INCREMENT     
    , `UebungID` INT NOT NULL     
    , `LookupID` INT NOT NULL 
    , PRIMARY KEY (`ID`)   
) 
;

ALTER TABLE uebung_lookup
ADD CONSTRAINT uc_uebung_lookup
UNIQUE (UebungID, LookupID) 
;

ALTER TABLE uebung_lookup 
    ADD  FOREIGN KEY (UebungID) 
    REFERENCES uebung(ID) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
    ;

ALTER TABLE uebung_lookup 
    ADD  FOREIGN KEY (LookupID) 
    REFERENCES lookup(ID) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
    ;



insert into relation (Name) values('uebung');

select * from relation
