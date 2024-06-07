
CREATE OR REPLACE VIEW v_test_musikstueck_ohne_komponist AS
select s.Name as Sammlung_Name, m.ID, m.Name as Musikstueck_Name
from sammlung s 
left join musikstueck m on s.ID = m.SammlungID 
left join komponist k 
on m.KomponistID = k.ID
where k.ID is null 
