CREATE  OR REPLACE VIEW v3_test_satz_ohne_spieldauer AS 
select 
    standort.Name as Standort 
    , s.Name as Sammlung
    , m.Nummer as MNummer
    , m.Name as Musikstueck
    , sa.Nr as SatzNr
    , sa.Name  as satz
    , sa.Spieldauer
    , sa.ID        
from musikstueck m 
    inner join  sammlung s on s.ID = m.SammlungID 
    inner join standort on standort.ID= s.StandortID        
    inner join satz sa on sa.MusikstueckID = m.ID 
where sa.Spieldauer is NULL
order by standort.Name, s.Name, m.Nummer, sa.Nr