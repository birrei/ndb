CREATE  OR REPLACE VIEW v3_test_musikstueck_ohne_satz AS 
select 
    standort.Name as Standort 
    , s.Name as Sammlung
    , m.Nummer
    , m.Name as Musikstueck
    , m.ID
from musikstueck m 
inner join  sammlung s on s.ID = m.SammlungID 
inner join standort on standort.ID= s.StandortID 
left join satz sa on sa.MusikstueckID = m.ID 
where s.Erfasst=0
and sa.ID is null 
and m.ID is not nULL 
order by standort.Name, s.Name, m.Nummer 
