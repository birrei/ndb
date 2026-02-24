
ALTER TABLE uebung DROP COLUMN IF EXISTS Reihenfolge; 


ALTER TABLE uebung ADD Reihenfolge TINYINT DEFAULT 0 ;   


SELECT left(Name,2) from uebung 
WHERE left(Name,2)  REGEXP '^[0-9]+$' 


UPDATE uebung 
SET Reihenfolge = left(Name,2) 
WHERE left(Name,2)  REGEXP '^[0-9]+$' 

