CREATE OR REPLACE view v_uebung_lookuptypes as  
select UebungID
   , GROUP_CONCAT(LookupList SEPARATOR ' / ') LookupList
   , GROUP_CONCAT(LookupList2 SEPARATOR '<br /><br />') LookupList2
from 
(
select uebung_lookup.UebungID 
        , lookup_type.ID as LookupTypeID
        , concat(lookup_type.Name,': ', GROUP_CONCAT(DISTINCT lookup.Name  order by lookup.Name SEPARATOR ', ')) LookupList          
        , concat(lookup_type.Name,':<br />', GROUP_CONCAT(DISTINCT lookup.Name  order by lookup.Name SEPARATOR ',<br >')) LookupList2       
    from uebung_lookup 
        left join lookup on lookup.ID = uebung_lookup.LookupID 
        left join lookup_type on lookup_type.ID = lookup.LookupTypeID
    -- where uebung_lookup.UebungID = 64
    group by uebung_lookup.UebungID ,  lookup_type.ID 
    order by uebung_lookup.UebungID, lookup_type.type_key
    ) uebung_lookuptype 
group by UebungID
-- order by LookupList2

