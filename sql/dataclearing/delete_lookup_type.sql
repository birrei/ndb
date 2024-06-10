
/* prüfen */

    select * from lookup_type where ID=4; 

    select * from lookup where LookupTypeID=4;  

    select satz.ID
        , satz.Name as SatzName 
        , lookup.Name as LookupName 
        , lookup_type.Name as TypeName 
    FROM 
        satz 
        left join satz_lookup on satz_lookup.SatzID = satz.ID 
        left join lookup on lookup.ID = satz_lookup.LookupID 
        left join lookup_type on lookup_type.ID = lookup.LookupTypeID
    where lookup.LookupTypeID =4; 








/* ein Lookup Type löschen */ 

    delete from satz_lookup
    USING satz_lookup 
    inner JOIN lookup on lookup.ID = satz_lookup.LookupID 
    where lookup.LookupTypeID=4; 

    delete from lookup where LookupTypeID=4; 

    delete from lookup_type where ID=4; 


