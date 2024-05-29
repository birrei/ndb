create or replace view v_lookup as 

SELECT lookup.ID
    , lookup.Name 
    , lookup_type.Name as LookupType
    , lookup_type.type_key as LookupTypeKey         
    , lookup.LookupTypeID  
    FROM lookup 
    LEFT JOIN lookup_type
      on lookup_type.ID = lookup.LookupTypeID
    ORDER by Name 