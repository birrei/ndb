
/* satz und dazugehörige Lookups */

    select satz.ID
    , satz.Name
    FROM 
        satz 
        left join satz_lookup on satz_lookup.SatzID = satz.ID 
        left join lookup on lookup.ID = satz_lookup.LookupID 
        left join lookup_type on lookup_type.ID = lookup.LookupTypeID
    -- where satz_lookup.SatzID is not nULL 
    group by satz.ID 


/* satz mit lookups */ 

    select satz.ID
        , satz.Name as SatzName 
        , lookup.Name as LookupName 
        , lookup_type.Name as TypeName 
    FROM 
        satz 
        left join satz_lookup on satz_lookup.SatzID = satz.ID 
        left join lookup on lookup.ID = satz_lookup.LookupID 
        left join lookup_type on lookup_type.ID = lookup.LookupTypeID
    where lookup.LookupTypeID =4



