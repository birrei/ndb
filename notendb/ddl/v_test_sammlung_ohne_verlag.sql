
CREATE OR REPLACE VIEW v_test_sammlung_ohne_verlag AS 
select s.ID, s.Name
from sammlung s 
left join verlag v on s.VerlagID = v.ID
where v.ID is null 
order by s.ID DESC 