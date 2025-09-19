/* Übernahme der Material- Eigenschaften zu Musikstück 
-- musikstueck.Bemerkung 
-- musikstueck.MaterialtypID 


- class.musikstueck.php -> update, load, copy 
- class.sammlung.php -> print_table_musikstuecke
- class.suchabfrage.php -> Ebene 2 neue Spalten  


*/    

ALTER TABLE musikstueck ADD Bemerkung VARCHAR(500) NULL 
; 

ALTER TABLE musikstueck ADD MaterialtypID TINYINT NULL 
; 
    
ALTER TABLE musikstueck 
    ADD  FOREIGN KEY (MaterialtypID) 
    REFERENCES materialtyp(ID) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
    ;








-- XXXX Daten in MaterialtypID auffüllen 
