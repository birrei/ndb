drop TABLE IF EXISTS material_lookup
; 

CREATE TABLE IF NOT EXISTS material_lookup (
    `ID` int NOT NULL AUTO_INCREMENT     
    , `MaterialID` INT NOT NULL 
    , `LookupID` INT NOT NULL 
    , PRIMARY KEY (`ID`)   
) 
;

ALTER TABLE material_lookup
ADD CONSTRAINT uc_material_lookup
UNIQUE (MaterialID, LookupID) 
;

ALTER TABLE material_lookup 
    ADD  FOREIGN KEY (MaterialID) 
    REFERENCES material(ID) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
    ;

ALTER TABLE material_lookup 
    ADD  FOREIGN KEY (LookupID) 
    REFERENCES lookup(ID) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
    ;


