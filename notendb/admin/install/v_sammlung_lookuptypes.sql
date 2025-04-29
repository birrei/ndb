CREATE OR REPLACE view v_sammlung_lookuptypes as  
select SammlungID
   , GROUP_CONCAT(DISTINCT LookupList  order by LookupList SEPARATOR ' / ') LookupList
 from 
 (
select sammlung_lookup.SammlungID 
        , lookup_type.ID as LookupTypeID
        , concat(lookup_type.Name,': ', GROUP_CONCAT(DISTINCT lookup.Name  order by lookup.Name SEPARATOR ', ')) LookupList          
    from sammlung_lookup 
        left join lookup on lookup.ID = sammlung_lookup.LookupID 
        left join lookup_type on lookup_type.ID = lookup.LookupTypeID
    group by sammlung_lookup.SammlungID ,  lookup_type.ID
) sammlung_lookuptype 
group by SammlungID