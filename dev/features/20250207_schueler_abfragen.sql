
-- Test 
select 
	s2.Name as Schueler
   , m.Name as Musikstueck
   , s.ID as SatzID
   , s.Name as SatzName
   , s.Nr as SatzNr 
	, m.ID as MusikstueckID 
	, m.SammlungID 
from musikstueck m 
inner join satz s on m.ID = s.MusikstueckID 
inner join schueler_satz ss  on ss.SatzID  = s.ID 
inner join schueler s2  on s2.ID  = ss.SchuelerID 
order by s2.Name


--  Sammlung x Schüler 
select 
	s2.ID 
	, s2.Name as Schueler
	, count(distinct m.SammlungID) as Anzahl_Sammlungen 
	, count(distinct m.ID) as Anzahl_Musikstuecke 
	, count(distinct s.ID) as Anzahl_Saetze
from musikstueck m 
inner join satz s on m.ID = s.MusikstueckID 
inner join schueler_satz ss  on ss.SatzID  = s.ID 
inner join schueler s2  on s2.ID  = ss.SchuelerID 
group by s2.ID 
having  count(distinct s.ID) > count(distinct m.ID) -- mehr Sätze als Musikstücke 
order by s2.Name


-- schueler x sammlung x material 
select 
	schueler.ID 
	, schueler.Name
	, schueler.Bemerkung as SchuelerBemerkung 
	, concat(sammlung.Name, ': ', musikstueck.Name, ': ', satz.Name) as Noten
	-- , GROUP_CONCAT(DISTINCT material.Name  order by material.Name SEPARATOR '; ') as Materialien 
	-- , GROUP_CONCAT(DISTINCT material.Name  order by material.Name SEPARATOR '; ') as Materialien 
	-- , count(distinct material.ID) as Anzahl_Materialien          
	-- , count(distinct satz.ID) as Anzahl_Saetze  
from schueler 
	left join 
	schueler_material on schueler_material.SchuelerID = schueler.ID
	left join 
	material on material.ID = schueler_material.MaterialID 
	left join 
	schueler_satz on schueler_satz.SchuelerID  = schueler.ID 
	left join 
	satz on satz.ID = schueler_satz.SatzID 
	left join 
	musikstueck on musikstueck.ID = satz.MusikstueckID
	left join 
	sammlung on sammlung.ID = musikstueck.SammlungID
-- group by schueler.ID 