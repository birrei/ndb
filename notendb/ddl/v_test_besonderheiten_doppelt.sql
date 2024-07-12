create or replace view v_test_besonderheiten_doppelt as 

SELECT v_lookup.*,  dbl.anz_typen
from v_lookup
inner JOIN  (
select Name, count(distinct LookupTypeID)  anz_typen 
from v_lookup
group by Name  
having count(distinct LookupTypeID) > 1
) dbl
on v_lookup.Name = dbl.Name
order by v_lookup.Name