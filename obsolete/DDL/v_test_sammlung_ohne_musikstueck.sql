CREATE OR REPLACE VIEW v_test_sammlung_ohne_musikstueck AS 
select s.ID, s.Name
from sammlung s 
left join musikstueck m on s.ID = m.SammlungID 
where m.ID is null 
order by s.ID DESC 