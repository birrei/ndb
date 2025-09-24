


INSERT INTO musikstueck (SammlungID, Name, Nummer, Bemerkung, MaterialtypID )
SELECT SammlungID, Name, -1 as Nummer, Bemerkung, MaterialtypID 
FROM material 
WHERE SammlungID = 40       
; 

INSERT INTO satz(MusikstueckID, Nr)
SELECT musikstueck.ID, 1 as Nr
FROM musikstueck
	 LEFT JOIN 
	 satz 
	 on musikstueck.ID = satz.MusikstueckID 
WHERE musikstueck.SammlungID = 40       
and musikstueck.Nummer  = -1
and satz.ID IS NULL
; 

insert into satz_schwierigkeitsgrad (SatzID, SchwierigkeitsgradID, InstrumentID )
SELECT satz.ID as SatzID
	  , material_schwierigkeitsgrad.SchwierigkeitsgradID 
	  , material_schwierigkeitsgrad.InstrumentID  
FROM musikstueck 
	 INNER JOIN material on musikstueck.Name = material.Name
	 inner JOIN satz on satz.MusikstueckID  = musikstueck.ID 
	 inner join material_schwierigkeitsgrad 
	 on material_schwierigkeitsgrad.MaterialID = material.ID 
WHERE musikstueck.SammlungID = 40     
order by material.ID 
; 

INSERT INTO satz_lookup  (SatzID, LookupID) 
SELECT satz.ID as SatzID 
    , material_lookup.LookupID  
FROM musikstueck 
    INNER JOIN material on musikstueck.Name = material.Name
    inner join material_lookup on material_lookup.MaterialID = material.ID 
    INNER JOIN satz on satz.MusikstueckID  = musikstueck.ID      
WHERE musikstueck.SammlungID = 40    
order by material.ID
; 


INSERT INTO schueler_satz  (SatzID, SchuelerID, StatusID) 
SELECT satz.ID as SatzID 
    , schueler_material.SchuelerID
    , schueler_material.StatusID     
FROM musikstueck 
    INNER JOIN material on musikstueck.Name = material.Name
    inner join schueler_material on schueler_material.MaterialID = material.ID 
    INNER JOIN satz on satz.MusikstueckID  = musikstueck.ID      
WHERE musikstueck.SammlungID = 40    
order by material.ID
; 


DELETE FROM material_lookup where MaterialID IN (SELECT ID FROM material WHERE SammlungID = 40        )
; 
DELETE FROM material_schwierigkeitsgrad where MaterialID IN (SELECT ID FROM material WHERE SammlungID = 40     )
; 
DELETE FROM schueler_material where MaterialID IN  (select ID from material WHERE SammlungID = 40 )
; 
DELETE FROM material WHERE SammlungID = 40         




