CREATE OR REPLACE view v_besonderheiten as  

select lookup.ID
	, lookup.Name
	, lookup_type.Name as Typ 
    , lookup.LookupTypeID 
	, lookup_type.Relation     
from lookup 
	inner join lookup_type  
		on lookup_type.ID = lookup.LookupTypeID
