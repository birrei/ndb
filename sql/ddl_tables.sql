-- CREATE TABLE IF NOT EXISTS besetzung  
-- (`ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT 
-- , Name VARCHAR(100) NOT NULL 
-- , PRIMARY KEY (`ID`)
-- )
-- ENGINE = InnoDB

-- ;
-- CREATE TABLE IF NOT EXISTS `komponist` (
--   `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
--   `Nachname` varchar(14) DEFAULT NULL,
--   `Vorname` varchar(23) DEFAULT NULL,
--   `Geburtsdatum` varchar(10) DEFAULT NULL,
--   `Sterbedatum` varchar(10) DEFAULT NULL,
--   `Geburtsjahr` varchar(6) DEFAULT NULL,
--   `Sterbejahr` varchar(4) DEFAULT NULL,
--    PRIMARY KEY (`ID`)      
-- ) ENGINE=InnoDB
-- ; 

-- CREATE TABLE IF NOT EXISTS `verlag` (
--   `ID` int(10) UNSIGNED NOT NULL  AUTO_INCREMENT,
--   `Name` varchar(100) DEFAULT NULL,
--   `Bemerkung` varchar(100) DEFAULT NULL,
--    PRIMARY KEY (`ID`)        
-- ) ENGINE=InnoDB 
-- ;


-- CREATE TABLE IF NOT EXISTS `sammlung` (
--   `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
--   `Name` varchar(56) DEFAULT NULL,
--   `Standort` varchar(50) DEFAULT NULL,
--   `VerlagID` int(10) UNSIGNED DEFAULT NULL,
--   `Bestellnummer` varchar(13) DEFAULT NULL,
--   `Bemerkung` varchar(80) DEFAULT NULL, 
--    PRIMARY KEY (`ID`)     
-- ) ENGINE=InnoDB 
-- ;

-- /* xxx hier noch if exists absichern */ 
-- ALTER TABLE `sammlung` 
--     ADD FOREIGN KEY (`VerlagID`) 
--     REFERENCES `verlag`(`ID`) ON DELETE RESTRICT ON UPDATE RESTRICT
-- ;

-- CREATE TABLE IF NOT EXISTS `musikstueck` (
--   `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
--   `Name` varchar(40) DEFAULT NULL,
--   `Opus` varchar(50) DEFAULT NULL,
--   `SammlungID` int(10) UNSIGNED DEFAULT NULL,
--   `Nummer` smallint(2) DEFAULT NULL,
--   `KomponistID` int(10) UNSIGNED DEFAULT NULL,
--   `Bearbeiter` varchar(26) DEFAULT NULL,
--   `Epoche` varchar(18) DEFAULT NULL,
--   `Verwendungszweck` varchar(100) DEFAULT NULL,
--   `Gattung` varchar(29) DEFAULT NULL,
--  --  `Besetzung` varchar(58) DEFAULT NULL, -- obsolete 
--   `JahrAuffuehrung` varchar(25) NOT NULL,
--    PRIMARY KEY (`ID`)      
-- ) ENGINE=InnoDB 
-- ;
-- /* xxx hier noch if exists absichern */ 
-- ALTER TABLE `musikstueck` ADD  FOREIGN KEY (`KomponistID`) 
-- REFERENCES `komponist`(`ID`) 
-- ON DELETE RESTRICT ON UPDATE RESTRICT
-- ;


-- CREATE TABLE IF NOT EXISTS `satz` (
--   `ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
--   `MusikstueckID` int(10) UNSIGNED DEFAULT NULL,
--   `Name` varchar(32) DEFAULT NULL,
--   `Nr` int(1) DEFAULT NULL,
--   `Tonart` varchar(14) DEFAULT NULL,
--   `Taktart` varchar(14) DEFAULT NULL,
--   `Tempobezeichnung` varchar(31) DEFAULT NULL,
--   `Spieldauer` varchar(3) DEFAULT NULL,
--   `Schwierigkeitsgrad` varchar(5) DEFAULT NULL,
--   `Lagen` varchar(7) DEFAULT NULL,
--   -- `Stricharten` varchar(64) DEFAULT NULL, -- obsolete 
--   `Erprobt` varchar(12) DEFAULT NULL,
--   `Bemerkung` varchar(162) DEFAULT NULL,
--   `Notenwerte` varchar(129) DEFAULT NULL,
--    PRIMARY KEY (`ID`)      
-- ) ENGINE=InnoDB

-- ;

-- /* Musikstück > Besetzungen */ 

-- ALTER TABLE `satz` ADD FOREIGN KEY (`MusikstueckID`) 
--     REFERENCES `musikstueck`(`ID`) 
--     ON DELETE RESTRICT ON UPDATE RESTRICT
-- ;

-- CREATE TABLE IF NOT EXISTS `musikstueck_besetzung` 
-- (
-- `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT     
-- , `MusikstueckID` int(11) UNSIGNED  NOT NULL 
-- , `BesetzungID` int(11) UNSIGNED  NOT NULL 
-- , PRIMARY KEY (`ID`)   
-- ) 
-- ENGINE = InnoDB
-- ;


-- ALTER TABLE `musikstueck_besetzung` 
-- ADD CONSTRAINT uc_musikstueck_besetzung 
-- UNIQUE (MusikstueckID,BesetzungID)
-- ;

-- ALTER TABLE `musikstueck_besetzung` 
--     ADD  FOREIGN KEY (`MusikstueckID`) 
--     REFERENCES `musikstueck`(`ID`) 
--     ON DELETE RESTRICT ON UPDATE RESTRICT
--     ;

-- ALTER TABLE `musikstueck_besetzung` 
--     ADD  FOREIGN KEY (`BesetzungID`) 
--     REFERENCES `besetzung`(`ID`) 
--     ON DELETE RESTRICT ON UPDATE RESTRICT
--   ;


-- /* Satz  > Stricharten */ 


-- CREATE TABLE IF NOT EXISTS `strichart`   
-- (`ID` int(10) UNSIGNED NOT NULL AUTO_INCREMENT 
-- , Name VARCHAR(100) NOT NULL 
-- , PRIMARY KEY (`ID`)
-- )
-- ENGINE = InnoDB; 

-- CREATE TABLE IF NOT EXISTS `satz_strichart` 
-- (
-- `ID` int(11) UNSIGNED NOT NULL AUTO_INCREMENT     
-- , `SatzID` int(11) UNSIGNED  NOT NULL 
-- , `StrichartID` int(11) UNSIGNED  NOT NULL 
-- , PRIMARY KEY (`ID`)   
-- ) 
-- ENGINE = InnoDB
-- ;

-- ALTER TABLE `satz_strichart` 
-- ADD CONSTRAINT uc_satz_strichart 
-- UNIQUE (SatzID, StrichartID)
-- ;

-- ALTER TABLE `satz_strichart` 
--     ADD  FOREIGN KEY (`SatzID`) 
--     REFERENCES `satz`(`ID`) 
--     ON DELETE RESTRICT ON UPDATE RESTRICT
--     ;

-- ALTER TABLE `satz_strichart` 
--     ADD  FOREIGN KEY (`StrichartID`) 
--     REFERENCES `strichart`(`ID`) 
--     ON DELETE RESTRICT ON UPDATE RESTRICT
--     ;



