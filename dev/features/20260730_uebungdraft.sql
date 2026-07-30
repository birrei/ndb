DROP TABLE IF EXISTS uebungdraft; 

CREATE TABLE `uebungdraft` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) NOT NULL,
  `Bemerkung` varchar(255) DEFAULT NULL,
  `UebungtypID` tinyint(4) DEFAULT NULL,
  `SchuelerID` tinyint(4) DEFAULT NULL,
  `Anzahl` int(11) DEFAULT NULL,
  `SatzID` int(10) unsigned DEFAULT NULL,
  `ts_insert` datetime DEFAULT current_timestamp(),
  `ts_update` datetime DEFAULT NULL ON UPDATE current_timestamp(),  
  PRIMARY KEY (`ID`),
  KEY `UebungtypID` (`UebungtypID`),
  KEY `SatzID` (`SatzID`), 
  CONSTRAINT `uebungdraft_satz` FOREIGN KEY (`SatzID`) REFERENCES `satz` (`ID`),
  CONSTRAINT `uebungdraft_uebungtyp` FOREIGN KEY (`UebungtypID`) REFERENCES `uebungtyp` (`ID`)
) 
; 

CREATE TABLE IF NOT EXISTS uebungdraft_lookup  (
    `ID` int NOT NULL AUTO_INCREMENT     
    , `UebungdraftID` INT NOT NULL     
    , `LookupID` INT NOT NULL 
    , PRIMARY KEY (`ID`)   
) 
;

ALTER TABLE uebungdraft_lookup 
ADD CONSTRAINT uc_uebungdraft_lookup 
UNIQUE (UebungdraftID, LookupID) 
;

ALTER TABLE uebungdraft_lookup  
    ADD  FOREIGN KEY (UebungdraftID) 
    REFERENCES uebungdraft(ID) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
    ;

ALTER TABLE uebungdraft_lookup  
    ADD  FOREIGN KEY (LookupID) 
    REFERENCES lookup(ID) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
    ;

insert into relation (Name) values('uebungdraft')
;


SELECT * FROM uebungdraft; 
SELECT * FROM uebungdraft_lookup; 
select * from relation;