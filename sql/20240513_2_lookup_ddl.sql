
/****************************************************/

drop TABLE IF EXISTS lookup_type
; 

CREATE TABLE IF NOT EXISTS `lookup_type`   
(`ID` TINYINT NOT NULL AUTO_INCREMENT 
, Name VARCHAR(100) NOT NULL 
, Relation  VARCHAR(20) NOT NULL /* = Zordnungs-Tabelle, z.B. 'musikstueck', 'satz', ... */
, PRIMARY KEY (`ID`)
)
ENGINE = InnoDB
; 


/****************************************************/
drop TABLE IF EXISTS satz_lookup
; 
CREATE TABLE IF NOT EXISTS `satz_lookup` 
(
`ID` int NOT NULL AUTO_INCREMENT     
, `SatzID` int(11) UNSIGNED  NOT NULL 
, `LookupID` INT NOT NULL 
, PRIMARY KEY (`ID`)   
) 
ENGINE = InnoDB
;

/****************************************************/

drop TABLE IF EXISTS lookup
; 

CREATE TABLE IF NOT EXISTS `lookup` (
 `ID` int NOT NULL AUTO_INCREMENT 
, Name VARCHAR(100) NOT NULL 
, LookupTypeID INT
, PRIMARY KEY (`ID`)
); 

ALTER TABLE `satz_lookup` 
    ADD  FOREIGN KEY (`SatzID`) 
    REFERENCES `satz`(`ID`) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `satz_lookup` 
ADD CONSTRAINT uc_satz_lookup 
UNIQUE (SatzID, LookupID)
;

ALTER TABLE `satz_lookup` 
    ADD  FOREIGN KEY (`SatzID`) 
    REFERENCES `satz`(`ID`) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `satz_lookup` 
    ADD  FOREIGN KEY (`LookupID`) 
    REFERENCES `lookup`(`ID`) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
;