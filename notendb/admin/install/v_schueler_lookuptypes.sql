CREATE OR REPLACE view v_schueler_lookuptypes as  
select SchuelerID
   , GROUP_CONCAT(LookupList SEPARATOR ' / ') LookupList
   , GROUP_CONCAT(LookupList2 SEPARATOR '<br /><br />') LookupList2
from 
(
select schueler_lookup.SchuelerID 
        , lookup_type.ID as LookupTypeID
        , concat(lookup_type.Name,': ', GROUP_CONCAT(DISTINCT lookup.Name  order by lookup.Name SEPARATOR ', ')) LookupList          
        , concat(lookup_type.Name,':<br />', GROUP_CONCAT(DISTINCT lookup.Name  order by lookup.Name SEPARATOR ',<br >')) LookupList2       
    from schueler_lookup 
        left join lookup on lookup.ID = schueler_lookup.LookupID 
        left join lookup_type on lookup_type.ID = lookup.LookupTypeID
    -- where schueler_lookup.SchuelerID = 64
    group by schueler_lookup.SchuelerID ,  lookup_type.ID 
    order by schueler_lookup.SchuelerID, lookup_type.type_key
    ) schueler_lookuptype 
group by SchuelerID
-- order by LookupList2

