CREATE  OR REPLACE VIEW test_satz_ohne_musikstueck_v AS 
-- satz ohne musikstück  
select s.*
from satz s 
left join musikstueck m 
on s.MusikstueckID = m.ID 
where m.ID is null 

