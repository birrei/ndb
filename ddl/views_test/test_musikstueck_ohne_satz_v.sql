CREATE  OR REPLACE VIEW test_musikstueck_ohne_satz_v AS 
select m.*
from  musikstueck m 
left join satz s 
on s.MusikstueckID = m.ID 
where s.ID is null 

