create or replace view v_lookup_groups as 
SELECT lookup.ID
    , lookup.Name 
    , lookup_type.Name as Typ         
    , lookup.LookupTypeID  
    FROM lookup 
    LEFT JOIN lookup_type
      on lookup_type.ID = lookup.LookupTypeID
    ORDER by Name 