
CREATE  OR REPLACE VIEW v_test_satz_ohne_schwierigkeitsgrad AS 
select s.Name as Sammlung_Name
        , m.Name as Musikstueck_Name
        , sa.Nr 
        , sa.Name as Satz_Name 
       , sa.ID        
from musikstueck m 
    inner join  sammlung s on s.ID = m.SammlungID 
    inner join satz sa on sa.MusikstueckID = m.ID 
    left join satz_schwierigkeitsgrad on satz_schwierigkeitsgrad.SatzID = sa.ID 
where satz_schwierigkeitsgrad.ID is NULL
order by sa.ID DESC