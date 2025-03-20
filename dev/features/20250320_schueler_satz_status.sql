


ALTER TABLE schueler_satz ADD StatusID INT
; 

ALTER TABLE schueler_satz 
ADD CONSTRAINT `fkey_schueler_satz_status` 
FOREIGN KEY (`StatusID`) 
REFERENCES `status` (`ID`)
        
  
-- show create table schueler_satz
