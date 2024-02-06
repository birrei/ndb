
CREATE OR REPLACE VIEW test_musikstueck_ohne_komponist_v AS

select m.* 
from musikstueck m 
left join komponist k 
on m.KomponistID = k.ID
where k.ID is null 

