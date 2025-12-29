/* 
Ergänzung Musikstück > Besetzungen aus Satz > Schwierigkeitsgrad- Instrumenten 
Hinweis: u.a. Abfragen funktionieren nur für Musikstücke, bei denen noch kein Besetzungs-Eintrag zugeordnet wurde 
*/

/* Violine */
insert into musikstueck_besetzung (MusikstueckID, BesetzungID)
select MusikstueckID, 2 as BesetzungID -- Violine 
-- select * 
from (
select sammlung.ID as SammlungID 
	, sammlung.name as SammlungName 
	, musikstueck.ID as MusikstueckID 
	, musikstueck.Name as MusikstueckName 
	, GROUP_CONCAT(instrument.Name  ORDER BY instrument.Name SEPARATOR ', ') Instrumente 
-- select count(*)
from sammlung 
inner join musikstueck on sammlung.ID = musikstueck.SammlungID 
inner join satz on satz.MusikstueckID = musikstueck.ID 
inner join satz_schwierigkeitsgrad on satz_schwierigkeitsgrad.SatzID = satz.ID 
inner join instrument on instrument.ID = satz_schwierigkeitsgrad.InstrumentID 
left join musikstueck_besetzung on musikstueck_besetzung.MusikstueckID=musikstueck.ID 
where 1=1 
and musikstueck_besetzung.ID IS NULL 
and musikstueck.SammlungID=1253   
group by musikstueck.ID 
order by musikstueck.ID 
) as update_base 
where Instrumente='Violine'



/* Violine und Klavier */
insert into musikstueck_besetzung (MusikstueckID, BesetzungID)
select MusikstueckID, 1 as BesetzungID -- Violine und Klavier 
-- select * 
from (
select sammlung.ID as SammlungID 
	, sammlung.name as SammlungName 
	, musikstueck.ID as MusikstueckID 
	, musikstueck.Name as MusikstueckName 
	, GROUP_CONCAT(instrument.Name  ORDER BY instrument.Name SEPARATOR ', ') Instrumente 
-- select count(*)
from sammlung 
inner join musikstueck on sammlung.ID = musikstueck.SammlungID 
inner join satz on satz.MusikstueckID = musikstueck.ID 
inner join satz_schwierigkeitsgrad on satz_schwierigkeitsgrad.SatzID = satz.ID 
inner join instrument on instrument.ID = satz_schwierigkeitsgrad.InstrumentID 
left join musikstueck_besetzung on musikstueck_besetzung.MusikstueckID=musikstueck.ID 
where 1=1 
and musikstueck_besetzung.ID IS NULL 
and musikstueck.SammlungID=1253   
group by musikstueck.ID 
order by musikstueck.ID 
) as update_base 
where Instrumente='Klavier, Violine'




/* 2 Violinen */
insert into musikstueck_besetzung (MusikstueckID, BesetzungID)
select MusikstueckID, 123 as BesetzungID -- 2 Violinen
-- select * 
from (
select sammlung.ID as SammlungID 
	, sammlung.name as SammlungName 
	, musikstueck.ID as MusikstueckID 
	, musikstueck.Name as MusikstueckName 
	, GROUP_CONCAT(instrument.Name  ORDER BY instrument.Name SEPARATOR ', ') Instrumente 
-- select count(*)
from sammlung 
inner join musikstueck on sammlung.ID = musikstueck.SammlungID 
inner join satz on satz.MusikstueckID = musikstueck.ID 
inner join satz_schwierigkeitsgrad on satz_schwierigkeitsgrad.SatzID = satz.ID 
inner join instrument on instrument.ID = satz_schwierigkeitsgrad.InstrumentID 
left join musikstueck_besetzung on musikstueck_besetzung.MusikstueckID=musikstueck.ID 
where 1=1 
and musikstueck_besetzung.ID IS NULL 
and musikstueck.SammlungID=1253
group by musikstueck.ID 
order by musikstueck.ID 
) as update_base 
where Instrumente='Violine, Violine 2'


