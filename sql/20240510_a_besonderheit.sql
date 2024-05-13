
/* Lookup */ 
ALTER TABLE `satz` ADD `BesonderheitID` INT NULL
 ;


drop TABLE IF EXISTS besonderheit
; 
CREATE TABLE IF NOT EXISTS `besonderheit`   
(`ID` INT NOT NULL AUTO_INCREMENT 
    , Typ  VARCHAR(25) NOT NULL 
    , Name VARCHAR(100) NOT NULL 
    , PRIMARY KEY (`ID`)
)
; 
select * from besonderheit
; 


/* Lookup Asoc */ 
drop TABLE IF EXISTS satz_besonderheit
; 
CREATE TABLE IF NOT EXISTS `satz_besonderheit` 
(
`ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT     
, `SatzID` int(11) UNSIGNED  NOT NULL 
, `BesonderheitID` INT NOT NULL 
, PRIMARY KEY (`ID`)   
) 
ENGINE = InnoDB
;

ALTER TABLE `satz_besonderheit` 
ADD CONSTRAINT uc_satz_besonderheit
UNIQUE (SatzID, BesonderheitID)
;

ALTER TABLE `satz_besonderheit` 
    ADD  FOREIGN KEY (`SatzID`) 
    REFERENCES `satz`(`ID`) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
;

ALTER TABLE `satz_besonderheit` 
    ADD  FOREIGN KEY (`BesonderheitID`) 
    REFERENCES `besonderheit`(`ID`) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
;

select * from satz_besonderheit
