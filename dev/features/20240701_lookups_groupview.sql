-- SELECT lookup.ID
--     , lookup.Name 
--     , lookup_type.Name as LookupType
--     , lookup_type.type_key as LookupTypeKey         
--     , lookup.LookupTypeID  
--     FROM lookup 
--     LEFT JOIN lookup_type
--       on lookup_type.ID = lookup.LookupTypeID
--     ORDER by Name 



select satz.ID  
        , GROUP_CONCAT(DISTINCT concat(lookup_type.Name, ': ', lookup.Name)  order by  concat(lookup_type.Name, ': ', lookup.Name)  SEPARATOR ', ') Besonderheiten          
  
from satz 

    left join satz_lookup on satz_lookup.SatzID = satz.ID 
    left join lookup on lookup.ID = satz_lookup.LookupID 
    left join lookup_type on lookup_type.ID = lookup.LookupTypeID

where satz.ID = 64
 AND satz_lookup.LookupID IN (98)
group by satz.ID 



select satz.ID  
  , lookup.ID as LookupID
, lookup.Name as LookupName 
,  lookup_ext.LookupID as LookupID_ext 
, lookup_ext.Name as LookupName_ext
from satz 
    left join satz_lookup on satz_lookup.SatzID = satz.ID 
    left join lookup on lookup.ID = satz_lookup.LookupID 
    left join lookup_type on lookup_type.ID = lookup.LookupTypeID
    left join (
      select satz_lookup.satzID, satz_lookup.LookupID, lookup.Name 
      from satz_lookup 
      left join lookup on lookup.ID = satz_lookup.LookupID 
      left join lookup_type on lookup_type.ID = lookup.LookupTypeID
    ) as lookup_ext
on satz.ID = lookup_ext.SatzID 

where satz.ID = 64
 AND satz_lookup.LookupID IN (98)



 select satz.ID  
        , GROUP_CONCAT(DISTINCT concat(lookup_ext.LookupType, ': ', lookup_ext.Lookup)  order by  concat(lookup_ext.LookupType, ': ', lookup_ext.Lookup)  SEPARATOR ', ') Besonderheiten          
  
from satz 
    left join satz_lookup on satz_lookup.SatzID = satz.ID 
    left join lookup on lookup.ID = satz_lookup.LookupID 
    left join lookup_type on lookup_type.ID = lookup.LookupTypeID
    left join (
      select satz_lookup.satzID, satz_lookup.LookupID, lookup.Name as Lookup, lookup_type.Name as LookupType 
      from satz_lookup 
      left join lookup on lookup.ID = satz_lookup.LookupID 
      left join lookup_type on lookup_type.ID = lookup.LookupTypeID
    ) as lookup_ext
on satz.ID = lookup_ext.SatzID 

where satz.ID = 64
 AND satz_lookup.LookupID IN (98)
group by satz.ID


