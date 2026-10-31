
drop TABLE IF EXISTS abschnitt;


CREATE TABLE abschnitt (
  `ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Name` varchar(100) NULL,
  `Bemerkung` varchar(255) DEFAULT NULL, 
  `SatzID` INT unsigned NOT NULL, 
   CONSTRAINT `abschnitt_satz` FOREIGN KEY (`SatzID`) REFERENCES `satz`(`ID`)  
) 


SHOW CREATE TABLE abschnitt

-- INSERT INTO abschnitt (Name, Bemerkung, SatzID) Values('Abschnitt 1', 'Bemerkung zu Abschnitt 1', 3982); 

SELECT * FROM abschnitt ORDER BY ID DESC 




-- drop TABLE IF EXISTS uebungtyp; 

-- CREATE TABLE `uebungtyp` (
--   `ID` tinyint(4) NOT NULL AUTO_INCREMENT,
--   `Name` varchar(100) NULL,
--   `Einheit` varchar(50) NULL,
--   `ts_insert` datetime DEFAULT current_timestamp(),
--   `ts_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),
--   PRIMARY KEY (`ID`)
-- ) 
-- ; 
-- CREATE TABLE `uebung` (
--   `ID` INT NOT NULL AUTO_INCREMENT,
--   `Name` varchar(100) NOT NULL,
--   `Bemerkung` varchar(255) DEFAULT NULL,
--   `UebungtypID` tinyint(4) DEFAULT NULL,
--   `SchuelerID` tinyint(4) DEFAULT NULL,  
--   -- `Datum` date DEFAULT CURRENT_DATE(), -- funktioniert nicht für mysql 5.7 
--   `Datum` date DEFAULT NULL,  
--   `Anzahl` INT DEFAULT NULL,
--   `ts_insert` datetime DEFAULT current_timestamp(),   
--   `ts_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),  
--   PRIMARY KEY (`ID`),
--   KEY `UebungtypID` (`UebungtypID`),
--   CONSTRAINT `uebung_uebungtyp` FOREIGN KEY (`UebungtypID`) REFERENCES `uebungtyp` (`ID`)
-- )
-- ; 


-- ALTER TABLE uebung  ADD SatzID INT unsigned NULL; 

-- ALTER TABLE uebung  
-- ADD CONSTRAINT `uebung_satz` 
-- FOREIGN KEY (`SatzID`) 
-- REFERENCES `satz` (`ID`); 

-- ALTER TABLE uebung  ADD MaterialID INT NULL; 

-- ALTER TABLE uebung  
-- ADD CONSTRAINT `uebung_material` 
-- FOREIGN KEY (`MaterialID`) 
-- REFERENCES `material` (`ID`); 

