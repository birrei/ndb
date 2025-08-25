create or replace view v_lookup as 

SELECT lookup.ID
    , lookup.Name 
    , lookup_type.Name as LookupTypeName
    , lookup_type.type_key as LookupTypeKey         
    , lookup.LookupTypeID 
    -- , lookup_type.Relation  
    FROM lookup 
    LEFT JOIN lookup_type
      on lookup_type.ID = lookup.LookupTypeID
    ORDER by Name 