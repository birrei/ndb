CREATE OR REPLACE view v_schueler_lookuptypes as  
/* alle Lookups, die - über den Satz - mit dem Schüler verknüpft sind*/
select SchuelerID
   , GROUP_CONCAT(LookupList SEPARATOR ' / ') LookupList
   , GROUP_CONCAT(LookupList2 SEPARATOR '<br /><br />') LookupList2
from 
(
select schueler_satz.SchuelerID 
        , lookup_type.ID as LookupTypeID
        , concat(lookup_type.Name,': ', GROUP_CONCAT(DISTINCT lookup.Name  order by lookup.Name SEPARATOR ', ')) LookupList          
        , concat(lookup_type.Name,':<br />', GROUP_CONCAT(DISTINCT lookup.Name  order by lookup.Name SEPARATOR '<br />')) LookupList2       
    from satz_lookup 
        inner join lookup on lookup.ID = satz_lookup.LookupID 
        inner join lookup_type on lookup_type.ID = lookup.LookupTypeID
        inner join schueler_satz on schueler_satz.SatzID = satz_lookup.SatzID 
    group by schueler_satz.SchuelerID ,  lookup_type.ID 
    order by schueler_satz.SchuelerID, lookup_type.type_key
    ) satz_lookuptype 
group by SchuelerID
-- order by LookupList2