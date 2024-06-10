
/* satz und Lookups */


select satz.ID
, satz.Name

FROM 
    satz 

    left join satz_lookup on satz_lookup.SatzID = satz.ID 
    left join lookup on lookup.ID = satz_lookup.LookupID 
    left join lookup_type on lookup_type.ID = lookup.LookupTypeID

group by satz.ID 


        

