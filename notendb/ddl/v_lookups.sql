create or replace view v_lookups as 

SELECT lookup.ID
    -- , lookup.Name
    , concat(lookup_type.Name, ': ', lookup.Name)  as Name 
    -- , lookup_type.Name as Typ         
    , lookup.Lookup_type_ID  
    FROM lookup 
    INNER JOIN lookup_type
      on lookup_type.ID = lookup.Lookup_type_ID
    ORDER by Name 