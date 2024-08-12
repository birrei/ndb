--- Besonderheiten zusammenfassen 

update lookup set LookupTypeID = 1 WHERE LookupTypeID BETWEEN 2 AND 10 ;

delete from lookup_type WHERE ID NOT IN (SELECT DISTINCT LookupTypeID from lookup); 

select * from v_lookup order by LookupTypeID; 

