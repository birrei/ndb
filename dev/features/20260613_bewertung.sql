
ALTER TABLE uebung  DROP CONSTRAINT IF EXISTS fk_uebung_bewertung; 

ALTER TABLE uebung  DROP COLUMN IF EXISTS BewertungID; 

ALTER TABLE uebung  ADD BewertungID INT NULL; 

DROP TABLE IF EXISTS bewertung; 

CREATE TABLE IF NOT EXISTS bewertung   (
      ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY 
    , Name VARCHAR(100) NOT NULL
    , ts_insert datetime DEFAULT CURRENT_TIMESTAMP
    , ts_update datetime ON UPDATE CURRENT_TIMESTAMP
)
; 

ALTER TABLE uebung
ADD CONSTRAINT fk_uebung_bewertung 
FOREIGN KEY (BewertungID)
REFERENCES bewertung(ID);


SELECT * FROM bewertung;  
select * from uebung LIMIT 1; 


------------------ MySQL 5.7 kompatible Version 


ALTER TABLE uebung  DROP  FOREIGN KEY fk_uebung_bewertung; 

ALTER TABLE uebung  DROP COLUMN BewertungID; 

DROP TABLE bewertung; 

CREATE TABLE IF NOT EXISTS bewertung   (
      ID INT NOT NULL AUTO_INCREMENT PRIMARY KEY 
    , Name VARCHAR(100) NOT NULL
    , Relation VARCHAR(100) NOT NULL -- Bezug Tabelle, z.B. "uebung", "schueler"
    , ts_insert datetime DEFAULT CURRENT_TIMESTAMP
    , ts_update datetime ON UPDATE CURRENT_TIMESTAMP
)
; 

ALTER TABLE uebung  ADD BewertungID INT NULL; 

ALTER TABLE uebung ADD CONSTRAINT fk_uebung_bewertung FOREIGN KEY (BewertungID) REFERENCES bewertung(ID);

SELECT * FROM bewertung  ;  

SELECT * FROM uebung LIMIT 1; 



