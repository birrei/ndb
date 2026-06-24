
INSERT INTO relation (Name) VALUES ('schueler'); 

CREATE TABLE `schueler_lookup` (
  `ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `SchuelerID` INT NOT NULL,
  `LookupID` INT NOT NULL,
  `ts_insert` datetime DEFAULT CURRENT_TIMESTAMP,
  `ts_update` datetime DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  UNIQUE KEY `uc_schueler_lookup` (`SchuelerID`,`LookupID`),
  CONSTRAINT `schueler_lookup_fk_SchuelerID` FOREIGN KEY (`SchuelerID`) REFERENCES `schueler` (`ID`),
  CONSTRAINT `schueler_lookup_fk_LookupID` FOREIGN KEY (`LookupID`) REFERENCES `lookup` (`ID`) 
) ; 



---------------------------- Abfragen -----------------

SELECT * FROM schueler_lookup


SELECT lookup_type.ID
        , lookup_type.Name 
  FROM lookup_type
      INNER JOIN lookuptype_relation ON lookup_type.ID=lookuptype_relation.LookuptypeID 
      INNER JOIN relation ON relation.ID = lookuptype_relation.RelationID  
  WHERE relation.Name='schueler'
      
  SELECT * FROM lookuptype_relation
  
  SELECT * FROM relation 
      
  
  