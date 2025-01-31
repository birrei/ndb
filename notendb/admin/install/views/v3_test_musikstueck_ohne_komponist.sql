
CREATE OR REPLACE VIEW v3_test_musikstueck_ohne_komponist AS
select 
    standort.Name as Standort 
    , s.Name as Sammlung
    , m.Nummer 
    , m.Name as Musikstueck
    , m.ID    
from sammlung s 
inner join standort on standort.ID= s.StandortID 
left join musikstueck m on s.ID = m.SammlungID 
left join komponist k 
on m.KomponistID = k.ID
where s.Erfasst=0
and k.ID is null 
order by standort.Name, s.Name, m.Nummer 