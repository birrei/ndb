drop TABLE IF EXISTS musikstueck_lookup
; 

CREATE TABLE IF NOT EXISTS musikstueck_lookup (
    `ID` int NOT NULL AUTO_INCREMENT     
    , `MusikstueckID` int(11) UNSIGNED  NOT NULL     
    , `LookupID` INT NOT NULL 
    , PRIMARY KEY (`ID`)   
) 
;

ALTER TABLE musikstueck_lookup
ADD CONSTRAINT uc_musikstueck_lookup
UNIQUE (MusikstueckID, LookupID) 
;

ALTER TABLE musikstueck_lookup 
    ADD  FOREIGN KEY (MusikstueckID) 
    REFERENCES musikstueck(ID) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
    ;

ALTER TABLE musikstueck_lookup 
    ADD  FOREIGN KEY (LookupID) 
    REFERENCES lookup(ID) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
    ;


