
create OR REPLACE view v_test_musikstueck_ohne_besetzung
AS 
select s.Name as Sammlung_Name, m.ID, m.Name as Musikstueck_Name
from sammlung s 
inner join musikstueck m on s.ID = m.SammlungID 
left join musikstueck_besetzung mb 
on m.ID = mb.MusikstueckID 
where mb.ID is null 
; 
