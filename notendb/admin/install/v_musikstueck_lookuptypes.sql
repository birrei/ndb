CREATE OR REPLACE view v_musikstueck_lookuptypes as  
select MusikstueckID
   , GROUP_CONCAT(LookupList SEPARATOR ' / ') LookupList
   , GROUP_CONCAT(LookupList2 SEPARATOR '<br /><br />') LookupList2
from 
(
select musikstueck_lookup.MusikstueckID 
        , lookup_type.ID as LookupTypeID
        , concat(lookup_type.Name,': ', GROUP_CONCAT(DISTINCT lookup.Name  order by lookup.Name SEPARATOR ', ')) LookupList          
        , concat(lookup_type.Name,':<br />', GROUP_CONCAT(DISTINCT lookup.Name  order by lookup.Name SEPARATOR ',<br >')) LookupList2       
    from musikstueck_lookup 
        left join lookup on lookup.ID = musikstueck_lookup.LookupID 
        left join lookup_type on lookup_type.ID = lookup.LookupTypeID
    group by musikstueck_lookup.MusikstueckID ,  lookup_type.ID
    order by musikstueck_lookup.MusikstueckID, lookup_type.type_key    
) musikstueck_lookuptype 
group by MusikstueckID