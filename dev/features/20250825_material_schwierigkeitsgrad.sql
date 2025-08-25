
-- show columns from schwierigkeitsgrad;
-- show columns from material;
-- 

DROP table IF EXISTS material_schwierigkeitsgrad
; 
CREATE TABLE IF NOT EXISTS material_schwierigkeitsgrad
(
    ID INT NOT NULL AUTO_INCREMENT     
    , MaterialID int Not NULL 
    , SchwierigkeitsgradID 	int(10) unsigned  NOT NULL 
    , InstrumentID INT NOT NULL 
    , PRIMARY KEY (ID)   
) 
; 

ALTER TABLE material_schwierigkeitsgrad
ADD CONSTRAINT uc_material_schwierigkeitsgrad 
UNIQUE (MaterialID, SchwierigkeitsgradID, InstrumentID)
;

ALTER TABLE material_schwierigkeitsgrad 
    ADD  FOREIGN KEY (MaterialID) 
    REFERENCES material(ID) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
    ;

ALTER TABLE material_schwierigkeitsgrad 
    ADD  FOREIGN KEY (SchwierigkeitsgradID) 
    REFERENCES schwierigkeitsgrad(ID) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
    ;

ALTER TABLE material_schwierigkeitsgrad 
    ADD  FOREIGN KEY (InstrumentID) 
    REFERENCES instrument(ID) 
    ON DELETE RESTRICT ON UPDATE RESTRICT
    ;



-- select * from material_schwierigkeitsgrad;
-- select * from instrument;
-- select * from schwierigkeitsgrad; 
-- select * from material where name like '%test%';



-- -- alle  Schwierigkeitsgrade mit "Orchester" kombinieren. 
-- insert into material_schwierigkeitsgrad (MaterialID, SchwierigkeitsgradID, InstrumentID) 
-- select material.ID as MaterialID 
--     , material.SchwierigkeitsgradID
--     , 1 as InstrumentID_default -- Orchester 
--    -- , material_schwierigkeitsgrad.InstrumentID
-- from material 
-- left join material_schwierigkeitsgrad
--     on material_schwierigkeitsgrad.MaterialID = material.ID 
--     and material_schwierigkeitsgrad.SchwierigkeitsgradID = material.SchwierigkeitsgradID
--     and material_schwierigkeitsgrad.InstrumentID = 1 
--   where material.SchwierigkeitsgradID is not null 
--   and material_schwierigkeitsgrad.ID IS NULL
-- order by material.ID


-- --- Test 
-- select material.ID 
--     , material.SchwierigkeitsgradID
--     , schwierigkeitsgrad_alt.Name as Schwierigkeitsgrad_alt 
--     , schwierigkeitsgrad.Name as Schwierigkeitsgrad_neu 
--     , instrument.Name as Instrument 
-- from material 
-- left join schwierigkeitsgrad as schwierigkeitsgrad_alt 
--     on material.SchwierigkeitsgradID = schwierigkeitsgrad_alt.ID
-- left JOIN material_schwierigkeitsgrad 
--     on material_schwierigkeitsgrad.MaterialID = material.ID  
-- left join schwierigkeitsgrad 
--     on  schwierigkeitsgrad.ID = material_schwierigkeitsgrad.SchwierigkeitsgradID
-- left join instrument
--     on instrument.ID = material_schwierigkeitsgrad.InstrumentID
-- where schwierigkeitsgrad_alt.ID 



/*****************************

offene Aufgaben: 




