
ALTER TABLE schueler_material ADD DatumVon date
; 

ALTER TABLE schueler_material ADD DatumBis date
; 

ALTER TABLE schueler_material ADD StatusID INT
; 

ALTER TABLE schueler_material 
ADD CONSTRAINT fkey_schueler_material_status
FOREIGN KEY (`StatusID`) 
REFERENCES `status` (`ID`)
; 
