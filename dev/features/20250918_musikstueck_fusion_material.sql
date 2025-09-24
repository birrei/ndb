/* Übernahme der Material- Eigenschaften zu Musikstück 
-- musikstueck.Bemerkung 
-- musikstueck.MaterialtypID 


- class.musikstueck.php -> update, load, copy 
- class.sammlung.php -> print_table_musikstuecke
- class.suchabfrage.php -> Ebene 2 neue Spalten  


*/    





-- ALTER TABLE musikstueck ADD Bemerkung VARCHAR(500) NULL 
-- ; 

-- ALTER TABLE musikstueck ADD MaterialtypID TINYINT NULL 
-- ; 
    
-- ALTER TABLE musikstueck 
--     ADD  FOREIGN KEY (MaterialtypID) 
--     REFERENCES materialtyp(ID) 
--     ON DELETE RESTRICT ON UPDATE RESTRICT
--     ;




------------------------------------------------
/* Migration Sammlung "Superstart Violin Level 1" 
 Spezial: Materialien müssen zwischen vorhandene Musikstücke einsortiert  werden 


-- SELECT SammlungID, Name, -1 as Nummer, Bemerkung, MaterialtypID 
-- FROM material 
-- WHERE SammlungID = 254   


*/

/* Musikstücke einfügen */

    -- INSERT INTO musikstueck (SammlungID, Name, Nummer, Bemerkung, MaterialtypID )
    -- SELECT SammlungID, Name, -1 as Nummer, Bemerkung, MaterialtypID 
    -- FROM material 
    -- WHERE SammlungID = 254   

/* Sätze einfügen, um Schwierigkeitsgrade + Besonderheiten zu übernehmen */

    -- INSERT INTO satz(MusikstueckID, Nr)
    -- SELECT musikstueck.ID, 1 as Nr
    -- FROM musikstueck
    -- 	 LEFT JOIN 
    -- 	 satz 
    -- 	 on musikstueck.ID = satz.MusikstueckID 
    -- WHERE musikstueck.SammlungID = 254   
    -- and musikstueck.Nummer  = -1
    -- and satz.ID IS NULL 

/*  Schwierigkeitsgrade  übernehmen  */

    -- insert into satz_schwierigkeitsgrad (SatzID, SchwierigkeitsgradID, InstrumentID )
    -- SELECT satz.ID as SatzID
    -- 	  , material_schwierigkeitsgrad.SchwierigkeitsgradID 
    -- 	  , material_schwierigkeitsgrad.InstrumentID  
    -- 		-- material.ID, material_schwierigkeitsgrad.* 
    -- FROM musikstueck 
    -- 	 INNER JOIN material on musikstueck.Name = material.Name
    -- 	 inner JOIN satz on satz.MusikstueckID  = musikstueck.ID 
    -- 	 inner join material_schwierigkeitsgrad 
    -- 	 on material_schwierigkeitsgrad.MaterialID = material.ID 
    -- WHERE musikstueck.SammlungID = 254 
    -- order by material.ID 


/*  Besonderheiten übernehmen */

    -- INSERT INTO satz_lookup  (SatzID, LookupID) 
    -- SELECT Satz.ID as SatzID 
    --     , material_lookup.LookupID  
    -- FROM musikstueck 
    --     INNER JOIN material on musikstueck.Name = material.Name
    --     inner join material_lookup on material_lookup.MaterialID = material.ID 
    --     INNER JOIN satz on satz.MusikstueckID  = musikstueck.ID      
    -- WHERE musikstueck.SammlungID = 254
    -- order by material.ID 


/*  Material-daten löschen  */

    -- DELETE FROM material_lookup where MaterialID IN (
    --     SELECT ID FROM material WHERE SammlungID = 254    
    -- )
    -- ; 

    -- DELETE FROM material_schwierigkeitsgrad where MaterialID IN (
    --     SELECT ID FROM material WHERE SammlungID = 254    
    -- )
    -- ; 

    -- delete FROM material WHERE SammlungID = 254     




