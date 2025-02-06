
/* Sammlung X Material X Schueler */

     select material.ID
            , material.Name
            , material.Bemerkung 
            , materialtyp.Name as Materialtyp
            , sammlung.Name as Sammlung 
            -- , material.ts_insert 
            -- , material.ts_update
            , material.MaterialtypID 
            , material.SammlungID 
            -- , sammlung.ID 
            , GROUP_CONCAT(DISTINCT schueler.Name order by schueler.Name SEPARATOR '; ') as Schueler  
        from material  
            LEFT JOIN 
            materialtyp on materialtyp.ID = material.MaterialtypID 
            left join 
            sammlung on sammlung.ID = material.SammlungID 
            left join 
            schueler_material on schueler_material.MaterialID  = material.ID 
            left join 
            schueler on schueler.ID=schueler_material.SchuelerID 
 group by material.ID 
 