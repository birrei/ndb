
drop TABLE IF EXISTS abschnitt;

CREATE TABLE abschnitt (
  `ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `Name` varchar(100) NULL,
  `Bemerkung` varchar(255) DEFAULT NULL, 
  `SatzID` INT unsigned NOT NULL, 
   CONSTRAINT `abschnitt_satz` FOREIGN KEY (`SatzID`) REFERENCES `satz`(`ID`)  
) 


-- SHOW CREATE TABLE abschnitt

-- INSERT INTO abschnitt (Name, Bemerkung, SatzID) Values('Abschnitt 1', 'Bemerkung zu Abschnitt 1', 3982); 

SELECT * FROM abschnitt ORDER BY ID DESC 


