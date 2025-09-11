CREATE OR REPLACE view v_satz_lookuptypes as  
select SatzID
   , GROUP_CONCAT(LookupList SEPARATOR ' / ') LookupList
   , GROUP_CONCAT(LookupList2 SEPARATOR '<br /><br />') LookupList2
from 
(
select satz_lookup.SatzID 
        , lookup_type.ID as LookupTypeID
        , concat(lookup_type.Name,': ', GROUP_CONCAT(DISTINCT lookup.Name  order by lookup.Name SEPARATOR ', ')) LookupList          
        , concat(lookup_type.Name,':<br />', GROUP_CONCAT(DISTINCT lookup.Name  order by lookup.Name SEPARATOR ',<br >')) LookupList2       
    from satz_lookup 
        left join lookup on lookup.ID = satz_lookup.LookupID 
        left join lookup_type on lookup_type.ID = lookup.LookupTypeID
    -- where satz_lookup.SatzID = 64
    group by satz_lookup.SatzID ,  lookup_type.ID 
    order by satz_lookup.SatzID, lookup_type.type_key
    ) satz_lookuptype 
group by SatzID
-- order by LookupList2

