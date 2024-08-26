
-- satz_schwierigkeitsgrad muss nur pro satz / instrument eindeutig sein. 
-- diese alte Def ist unnötig / hinderlich: 
    -- ALTER TABLE satz_schwierigkeitsgrad
    -- ADD CONSTRAINT uc_satz_schwierigkeitsgrad 
    -- UNIQUE (SatzID, SchwierigkeitsgradID, InstrumentID)
    -- ;

--------------------------

SHOW CREATE TABLE satz_schwierigkeitsgrad; 

CREATE TABLE `satz_schwierigkeitsgrad` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SatzID` int(10) unsigned NOT NULL,
  `SchwierigkeitsgradID` int(11) NOT NULL,
  `InstrumentID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `uc_satz_schwierigkeitsgrad` (`SatzID`,`SchwierigkeitsgradID`,`InstrumentID`),
  KEY `SchwierigkeitsgradID` (`SchwierigkeitsgradID`),
  KEY `InstrumentID` (`InstrumentID`),
  CONSTRAINT `satz_schwierigkeitsgrad_ibfk_1` FOREIGN KEY (`SatzID`) REFERENCES `satz` (`ID`),
  CONSTRAINT `satz_schwierigkeitsgrad_ibfk_2` FOREIGN KEY (`SchwierigkeitsgradID`) REFERENCES `schwierigkeitsgrad` (`ID`),
  CONSTRAINT `satz_schwierigkeitsgrad_ibfk_3` FOREIGN KEY (`InstrumentID`) REFERENCES `instrument` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=62 DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci</td>

alter table satz_schwierigkeitsgrad 
drop constraint uc_satz_schwierigkeitsgrad;

-- Ein Fehler ist aufgetreten.
-- SQLSTATE[HY000]: General error: 1553 Cannot drop index 'uc_satz_schwierigkeitsgrad': needed in a foreign key constraint

--- also alle constraints löschen und neu anlegen 

-- ALTER TABLE satz_schwierigkeitsgrad DROP CONSTRAINT satz_schwierigkeitsgrad_ibfk_1;
-- ALTER TABLE satz_schwierigkeitsgrad DROP CONSTRAINT satz_schwierigkeitsgrad_ibfk_2;
-- ALTER TABLE satz_schwierigkeitsgrad DROP CONSTRAINT satz_schwierigkeitsgrad_ibfk_3;

--- o.a. nur MariaDB, MySQL 5.7: 
ALTER TABLE satz_schwierigkeitsgrad DROP FOREIGN KEY satz_schwierigkeitsgrad_ibfk_1;
ALTER TABLE satz_schwierigkeitsgrad DROP FOREIGN KEY satz_schwierigkeitsgrad_ibfk_2;
ALTER TABLE satz_schwierigkeitsgrad DROP FOREIGN KEY satz_schwierigkeitsgrad_ibfk_3;

alter table satz_schwierigkeitsgrad 
drop constraint uc_satz_schwierigkeitsgrad;

ALTER TABLE satz_schwierigkeitsgrad
ADD CONSTRAINT uc_satz_schwierigkeitsgrad 
UNIQUE (SatzID, InstrumentID) -- Änderung 
;

-- fkeys wieder anlegen wie zuvor 
ALTER TABLE satz_schwierigkeitsgrad 
    ADD  FOREIGN KEY (InstrumentID) 
    REFERENCES instrument(ID) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
    ;

ALTER TABLE satz_schwierigkeitsgrad 
    ADD  FOREIGN KEY (InstrumentID) 
    REFERENCES instrument(ID) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
    ;

ALTER TABLE satz_schwierigkeitsgrad 
    ADD  FOREIGN KEY (SchwierigkeitsgradID) 
    REFERENCES schwierigkeitsgrad(ID) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
    ;

--------------------------
--prod 

CREATE TABLE `satz_schwierigkeitsgrad` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `SatzID` int(10) unsigned NOT NULL,
  `SchwierigkeitsgradID` int(10) unsigned NOT NULL,
  `InstrumentID` int(11) NOT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `uc_satz_schwierigkeitsgrad` (`SatzID`,`SchwierigkeitsgradID`,`InstrumentID`),
  KEY `InstrumentID` (`InstrumentID`),
  KEY `SchwierigkeitsgradID` (`SchwierigkeitsgradID`),
  CONSTRAINT `satz_schwierigkeitsgrad_ibfk_1` FOREIGN KEY (`SatzID`) REFERENCES `satz` (`ID`),
  CONSTRAINT `satz_schwierigkeitsgrad_ibfk_2` FOREIGN KEY (`SchwierigkeitsgradID`) REFERENCES `schwierigkeitsgrad` (`ID`),
  CONSTRAINT `satz_schwierigkeitsgrad_ibfk_3` FOREIGN KEY (`InstrumentID`) REFERENCES `instrument` (`ID`),
  CONSTRAINT `satz_schwierigkeitsgrad_ibfk_4` FOREIGN KEY (`InstrumentID`) REFERENCES `instrument` (`ID`),
  CONSTRAINT `satz_schwierigkeitsgrad_ibfk_5` FOREIGN KEY (`InstrumentID`) REFERENCES `instrument` (`ID`),
  CONSTRAINT `satz_schwierigkeitsgrad_ibfk_6` FOREIGN KEY (`SchwierigkeitsgradID`) REFERENCES `schwierigkeitsgrad` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=1465 DEFAULT CHARSET=utf8</td>