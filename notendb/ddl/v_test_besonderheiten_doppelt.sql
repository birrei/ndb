create or replace view v_test_besonderheiten_doppelt as 

SELECT v_lookups.*,  dbl.anz_typen
from v_lookups
inner JOIN  (
select Name, count(distinct LookupTypeID)  anz_typen 
from v_lookups
group by Name  
having count(distinct LookupTypeID) > 1
) dbl
on v_lookups.Name = dbl.Name
order by v_lookups.Name