
create view test_musikstueck_ohne_Besetzung_v 
AS 
select m.* 
from musikstueck m 
left join musikstueck_besetzung mb 
on m.ID = mb.MusikstueckID 
where mb.ID is null 
