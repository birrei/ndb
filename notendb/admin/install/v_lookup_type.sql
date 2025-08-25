create or replace view v_lookup_type as 
select lookup_type.ID
    , lookup_type.Name
    , type_key 
    , GROUP_CONCAT(DISTINCT relation.Name ORDER BY relation.Name SEPARATOR ',') as Relationen 
from lookup_type
     LEFT JOIN lookuptype_relation 
        on  lookuptype_relation.LookuptypeID = lookup_type.ID 
    LEFT JOIN
        relation on relation.ID = lookuptype_relation.RelationID 
group by lookup_type.ID 

