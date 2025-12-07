-- Sammlung: mehrere Standorte erfassen 

DROP TABLE IF EXISTS sammlung_standort
; 
CREATE TABLE IF NOT EXISTS sammlung_standort (
    `ID` int NOT NULL AUTO_INCREMENT     
    , `SammlungID` int(10) unsigned NOT NULL -- :-/ 
    , `StandortID` int(10) unsigned NOT NULL 
    , PRIMARY KEY (`ID`)   
) 
;

ALTER TABLE sammlung_standort
ADD CONSTRAINT uc_sammlung_standort
UNIQUE (SammlungID, StandortID) 
;

ALTER TABLE sammlung_standort 
    ADD  FOREIGN KEY (SammlungID) 
    REFERENCES sammlung(ID) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
    ;

ALTER TABLE sammlung_standort 
    ADD  FOREIGN KEY (StandortID) 
    REFERENCES standort(ID) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
    ;




/*


*/
















/*

Aufräumarbeiten: 

Feld löschen: sammlung.StandortID 





*/



