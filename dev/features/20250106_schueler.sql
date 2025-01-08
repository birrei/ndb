-- -- schueler initial-befüllung 

-- insert into schueler (Name)
-- select replace(Name, 'Planung Unterricht: ','') as NameInsert
-- 	-- , Name
-- from verwendungszweck 
-- where 1=1 
-- and Name LIKE '%Planung Unterricht%'
-- and Name not like '%besonders%'; 

-- select * from schueler;



CREATE TABLE `schueler_schwierigkeitsgrad` (
  `ID` INT NOT NULL AUTO_INCREMENT,
  `SchuelerID` INT NOT NULL,
  `SchwierigkeitsgradID` INT NOT NULL,
  `InstrumentID` INT NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `uc_satz_schwierigkeitsgrad` (`SchuelerID`,`SchwierigkeitsgradID`,`InstrumentID`),
  KEY `SchwierigkeitsgradID` (`SchwierigkeitsgradID`),
  KEY `InstrumentID` (`InstrumentID`),
  CONSTRAINT `satz_schwierigkeitsgrad_ibfk_1` FOREIGN KEY (`SchuelerID`) REFERENCES `schueler` (`ID`),
  CONSTRAINT `satz_schwierigkeitsgrad_ibfk_2` FOREIGN KEY (`SchwierigkeitsgradID`) REFERENCES `schwierigkeitsgrad` (`ID`),
  CONSTRAINT `satz_schwierigkeitsgrad_ibfk_3` FOREIGN KEY (`InstrumentID`) REFERENCES `instrument` (`ID`)
) 