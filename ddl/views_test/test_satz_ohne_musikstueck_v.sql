CREATE  OR REPLACE VIEW test_satz_ohne_musikstueck_v AS 
select s.*
from satz s 
left join musikstueck m 
on s.MusikstueckID = m.ID 
where m.ID is null 

