/*
Automatisches Hinzufügen von Attributen 

*/

CREATE TABLE IF NOT EXISTS auto_update (
    ID INT NOT NULL AUTO_INCREMENT     
    , StandortID 	INT 
    , BesetzungID INT 
    , VerwendungszweckID YEAR
    , ErprobtID VARCHAR(100)
    , PRIMARY KEY (ID)   
) 




INSERT INTO auto_update (StandortID)