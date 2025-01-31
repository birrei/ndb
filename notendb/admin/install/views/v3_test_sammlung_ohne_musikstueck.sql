CREATE OR REPLACE VIEW v3_test_sammlung_ohne_musikstueck AS 
select 
    standort.Name as Standort     
    , s.Name as Sammlung
    , s.ID
from sammlung s 
inner join standort on standort.ID= s.StandortID 
left join musikstueck m on s.ID = m.SammlungID 
where s.Erfasst=1
and m.ID is null 
order by standort.Name, s.Name