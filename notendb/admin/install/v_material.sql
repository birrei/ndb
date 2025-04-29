create or replace view v_material as
select material.ID
    , material.Name
    , sammlung.Name as Sammlung             
    , material.Bemerkung 
    , materialtyp.Name as Materialtyp 
    , material.MaterialtypID 
    , material.SammlungID 
    -- , material.ts_insert 
    -- , material.ts_update            
from material  
    LEFT JOIN 
    materialtyp on materialtyp.ID = material.MaterialtypID 
    left join 
    sammlung on sammlung.ID = material.SammlungID 
