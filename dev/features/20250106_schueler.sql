-- -- schueler initial-befüllung 
insert into schueler (Name)
select replace(Name, 'Planung Unterricht: ','') as NameInsert
	-- , Name
from verwendungszweck 
where 1=1 
and Name LIKE '%Planung Unterricht%'
and Name not like '%besonders%'; 

-- test 
select * from schueler;


-- schueler_satz initialbefüllung 
insert into schueler_satz (SchuelerID, SatzID )
select distinct  s2.ID as SchuelerID, s.ID as SatzID 
-- , m.ID, m.Name as Musikstueck, s.ID, s.Name, s.Nr 
-- , v.Name as Verwendungszweck, replace(v.Name, 'Planung Unterricht: ','') as SchuelerV
-- , s2.Name  as Schueler
from musikstueck m 
inner join satz s on m.ID = s.MusikstueckID 
inner join musikstueck_verwendungszweck mv on mv.MusikstueckID = m.ID 
inner join verwendungszweck v  on mv.VerwendungszweckID = v.ID 
inner join schueler s2 on replace(v.Name, 'Planung Unterricht: ','')=s2.Name 
where (v.Name LIKE '%Planung Unterricht%' and  v.Name not like '%besonders%') 
order by m.ID, s.ID 

