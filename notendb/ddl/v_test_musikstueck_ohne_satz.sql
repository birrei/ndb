CREATE  OR REPLACE VIEW v_test_musikstueck_ohne_satz
AS 
select s.Name as Sammlung_Name, m.ID, m.Name as Musikstueck_Name
from musikstueck m 
inner join  sammlung s on s.ID = m.SammlungID 
left join satz sa on sa.MusikstueckID = m.ID 
where sa.ID is null 
and m.ID is not nULL 

