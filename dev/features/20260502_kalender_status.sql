
ALTER TABLE kalender DROP COLUMN StatusID 
; 

ALTER TABLE kalender ADD StatusID INT;  
; 


CREATE TABLE IF NOT EXISTS statuskalender   (
    ID INT NOT NULL AUTO_INCREMENT 
    , Name VARCHAR(100) NOT NULL 
    , PRIMARY KEY (ID)
)
; 

ALTER TABLE statuskalender  ADD ts_insert datetime DEFAULT CURRENT_TIMESTAMP; 

ALTER TABLE statuskalender  ADD ts_update datetime ON UPDATE CURRENT_TIMESTAMP; 

