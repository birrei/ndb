
CREATE  OR REPLACE VIEW v3_test_satz_ohne_schwierigkeitsgrad AS 
select 
    standort.Name as Standort 
    , s.Name as Sammlung
    , m.Nummer as MNr
    , m.Name as Musikstueck
        , sa.Nr as SatzNr
        , sa.Name as Satz
       , sa.ID        
from musikstueck m 
    inner join  sammlung s on s.ID = m.SammlungID 
    inner join standort on standort.ID= s.StandortID     
    inner join satz sa on sa.MusikstueckID = m.ID 
    left join satz_schwierigkeitsgrad on satz_schwierigkeitsgrad.SatzID = sa.ID 
where satz_schwierigkeitsgrad.ID is NULL
order by standort.Name, s.Name, m.Nummer, sa.Nr

