
create OR REPLACE view v3_test_musikstueck_ohne_besetzung
AS 
select
    standort.Name as Standort 
    , s.Name as Sammlung
    , m.Nummer 
    , m.Name as Musikstueck
    , m.ID    
from sammlung s 
inner join standort on standort.ID= s.StandortID 
inner join musikstueck m on s.ID = m.SammlungID 
left join musikstueck_besetzung mb 
on m.ID = mb.MusikstueckID 
where s.Erfasst=1 
and mb.ID is null 
order by standort.Name, s.Name, m.Nummer 