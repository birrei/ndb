CREATE OR REPLACE view v_satz_lookuptypes as  
select SatzID
   , GROUP_CONCAT(DISTINCT LookupList  order by LookupList SEPARATOR ' / ') LookupList
from 
(
select satz_lookup.SatzID 
        , lookup_type.ID as LookupTypeID
        , concat(lookup_type.Name,': ', GROUP_CONCAT(DISTINCT lookup.Name  order by lookup.Name SEPARATOR ', ')) LookupList          
    from satz_lookup 
        left join lookup on lookup.ID = satz_lookup.LookupID 
        left join lookup_type on lookup_type.ID = lookup.LookupTypeID
    -- where satz_lookup.SatzID = 64
    group by satz_lookup.SatzID ,  lookup_type.ID
) satz_lookuptype 
group by SatzID