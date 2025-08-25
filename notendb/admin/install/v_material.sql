create or replace view v_material as
select material.ID
    , material.Name
    , sammlung.Name as Sammlung             
    , material.Bemerkung 
    , materialtyp.Name as Materialtyp   
    , GROUP_CONCAT(DISTINCT concat(instrument.Name, ': ', schwierigkeitsgrad.Name)  order by schwierigkeitsgrad.Name SEPARATOR ', ') `Schwierigkeitsgrade`               
    , v_material_lookuptypes.LookupList as Besonderheiten
    , material.MaterialtypID 
    , material.SammlungID                  
from material  
    LEFT JOIN 
    materialtyp on materialtyp.ID = material.MaterialtypID 
    left join 
    sammlung on sammlung.ID = material.SammlungID 

    LEFT JOIN material_schwierigkeitsgrad on material_schwierigkeitsgrad.MaterialID = material.ID 
    LEFT JOIN schwierigkeitsgrad on schwierigkeitsgrad.ID = material_schwierigkeitsgrad.SchwierigkeitsgradID 
    LEFT JOIN instrument on instrument.ID = material_schwierigkeitsgrad.InstrumentID     
    LEFT JOIN v_material_lookuptypes on v_material_lookuptypes.MaterialID = material.ID    
       
        GROUP BY material.ID 
        ORDER BY material.Name 