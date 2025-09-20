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



-- SELECT SammlungID, Name, -1 as Nummer, Bemerkung, MaterialtypID 
-- FROM material 
-- WHERE SammlungID = 254   




INSERT INTO musikstueck (SammlungID, Name, Nummer, Bemerkung, MaterialtypID )
SELECT SammlungID, Name, -1 as Nummer, Bemerkung, MaterialtypID 
FROM material 
WHERE SammlungID = 254   


INSERT INTO satz(MusikstueckID, Nr)
SELECT musikstueck.ID, 1 as Nr
FROM musikstueck
	 LEFT JOIN 
	 satz 
	 on musikstueck.ID = satz.MusikstueckID 
WHERE musikstueck.SammlungID = 254   
and musikstueck.Nummer  = -1
and satz.ID IS NULL 

insert into satz_schwierigkeitsgrad (SatzID, SchwierigkeitsgradID, InstrumentID )
SELECT satz.ID as SatzID
	  , material_schwierigkeitsgrad.SchwierigkeitsgradID 
	  , material_schwierigkeitsgrad.InstrumentID  
		-- material.ID, material_schwierigkeitsgrad.* 
FROM musikstueck 
	 INNER JOIN material on musikstueck.Name = material.Name
	 inner JOIN satz on satz.MusikstueckID  = musikstueck.ID 
	 inner join material_schwierigkeitsgrad 
	 on material_schwierigkeitsgrad.MaterialID = material.ID 
WHERE musikstueck.SammlungID = 254 
order by material.ID 


insert into musikstueck_lookup  (MusikstueckID, LookupID) 
SELECT musikstueck.ID as MusikstueckID
	  , material_lookup.LookupID  
FROM musikstueck 
	 INNER JOIN material on musikstueck.Name = material.Name
	 inner join material_lookup on material_lookup.MaterialID = material.ID 
WHERE musikstueck.SammlungID = 254 
order by material.ID 





-- XXXX Daten in MaterialtypID auffüllen 
