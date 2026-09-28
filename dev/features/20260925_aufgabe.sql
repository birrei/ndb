
DROP TABLE aufgabe; 

CREATE TABLE aufgabe   (
    `ID` INT NOT NULL AUTO_INCREMENT PRIMARY KEY
    , Beschreibung VARCHAR(500) NULL 
    , Datum DATE NOT NULL 
    , SchuelerID INT NOT NULL 
    , Erledigt BOOLEAN default false     
    , ts_insert datetime DEFAULT current_timestamp()
    , ts_update datetime DEFAULT NULL ON UPDATE current_timestamp()  
    , CONSTRAINT fk_aufgabe_schueler 
        FOREIGN KEY (SchuelerID)
        REFERENCES schueler(ID)
        ON DELETE RESTRICT ON UPDATE RESTRICT     
)
; 


-- IL 
INSERT INTO aufgabe (SchuelerID, Beschreibung, Datum)
SELECT ID AS SchuelerID, Bemerkung, CURRENT_DATE() AS Datum 
FROM schueler 
WHERE COALESCE(Bemerkung, '') !=''
; 

SELECT * FROM aufgabe ; 
