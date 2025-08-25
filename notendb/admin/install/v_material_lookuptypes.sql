CREATE OR REPLACE view v_material_lookuptypes as  
select MaterialID
   , GROUP_CONCAT(DISTINCT LookupList  order by LookupList SEPARATOR ' / ') LookupList
   , GROUP_CONCAT(DISTINCT LookupList2  order by LookupList SEPARATOR '<br /><br />') LookupList2
from 
(
select material_lookup.MaterialID 
        , lookup_type.ID as LookupTypeID
        , concat(lookup_type.Name,': ', GROUP_CONCAT(DISTINCT lookup.Name  order by lookup.Name SEPARATOR ', ')) LookupList          
        , concat(lookup_type.Name,':<br />', GROUP_CONCAT(DISTINCT lookup.Name  order by lookup.Name SEPARATOR ',<br >')) LookupList2       
    from material_lookup 
        left join lookup on lookup.ID = material_lookup.LookupID 
        left join lookup_type on lookup_type.ID = lookup.LookupTypeID
    -- where material_lookup.MaterialID = 64
    group by material_lookup.MaterialID ,  lookup_type.ID
) material_lookuptype 
group by MaterialID