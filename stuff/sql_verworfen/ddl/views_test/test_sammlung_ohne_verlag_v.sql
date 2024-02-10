-- sammlung ohne verlag 

CREATE OR REPLACE VIEW test_sammlung_ohne_verlag_v AS 
select s.* 
from sammlung s 
left join verlag v on s.VerlagID = v.ID
where v.ID is null 
