
CREATE OR REPLACE VIEW v3_test_sammlung_ohne_verlag AS 
select 
    standort.Name as Standort     
    , s.Name as Sammlung
    , s.ID
from sammlung s 
inner join standort  on standort.ID = s.StandortID
left join verlag v on s.VerlagID = v.ID
where s.Erfasst=0
and v.ID is null 
order by standort.Name, s.Name