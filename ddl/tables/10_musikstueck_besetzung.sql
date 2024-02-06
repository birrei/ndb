CREATE TABLE `musikstueck_besetzung` 
(
`ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT     
, `MusikstueckID` int(11) UNSIGNED  NOT NULL 
, `BesetzungID` int(11) UNSIGNED  NOT NULL 
, PRIMARY KEY (`ID`)   
) 
ENGINE = InnoDB;

ALTER TABLE `musikstueck_besetzung` 
ADD CONSTRAINT uc_musikstueck_besetzung 
UNIQUE (MusikstueckID,BesetzungID);

ALTER TABLE `musikstueck_besetzung` 
    ADD  FOREIGN KEY (`MusikstueckID`) 
    REFERENCES `musikstueck`(`ID`) 
    ON DELETE RESTRICT ON UPDATE RESTRICT;

ALTER TABLE `musikstueck_besetzung` 
    ADD  FOREIGN KEY (`BesetzungID`) 
    REFERENCES `besetzung`(`ID`) 
    ON DELETE RESTRICT ON UPDATE RESTRICT;

