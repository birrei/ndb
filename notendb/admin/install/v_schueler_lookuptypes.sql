CREATE OR REPLACE view v_schueler_lookuptypes as  
select SchuelerID
	, Status 
   , GROUP_CONCAT(LookupList SEPARATOR ' / ') LookupList
   , GROUP_CONCAT(LookupList2 SEPARATOR '<br /><br />') LookupList2
from 
(
select schueler_satz.SchuelerID 
        , lookup_type.ID as LookupTypeID
        , schueler_satz.StatusID 
        , status.Name as Status 
        , concat(lookup_type.Name,': ', GROUP_CONCAT(DISTINCT lookup.Name  order by lookup.Name SEPARATOR ', ')) LookupList          
        , concat(lookup_type.Name,':<br />', GROUP_CONCAT(DISTINCT lookup.Name  order by lookup.Name SEPARATOR '<br />')) LookupList2       
    from satz_lookup 
        inner join lookup on lookup.ID = satz_lookup.LookupID 
        inner join lookup_type on lookup_type.ID = lookup.LookupTypeID
        inner join schueler_satz on schueler_satz.SatzID = satz_lookup.SatzID
        inner join status on status.ID = schueler_satz.StatusID 
    where schueler_satz.SchuelerID = 32
    group by schueler_satz.SchuelerID ,  lookup_type.ID, schueler_satz.StatusID 
    order by schueler_satz.SchuelerID, status.Name, lookup_type.type_key
    ) satz_lookuptype 
    group by SchuelerID, Status  
    order by Status

