/* 

Wie Version 1, hier aber Kombi mit Viola 


*/

/* Viola  */
insert into musikstueck_besetzung (MusikstueckID, BesetzungID)
select MusikstueckID, 146 as BesetzungID -- Viola  
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
and musikstueck.SammlungID=1319       -- XXX 
group by musikstueck.ID 
order by musikstueck.ID 
) as update_base 
where Instrumente='Viola'






/* Viola und Klavier */
insert into musikstueck_besetzung (MusikstueckID, BesetzungID)
select MusikstueckID, 130 as BesetzungID -- Viola und Klavier 
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
and musikstueck.SammlungID=1319    -- XXX 
group by musikstueck.ID 
order by musikstueck.ID 
) as update_base 
where Instrumente='Klavier, Viola'




/* 2 Violen */
insert into musikstueck_besetzung (MusikstueckID, BesetzungID)
select MusikstueckID, 145 as BesetzungID -- 2 Violen
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
and musikstueck.SammlungID=1319 -- XXX 
group by musikstueck.ID 
order by musikstueck.ID 
) as update_base 
where Instrumente='Viola, Viola 2'



/* 2 Violen und Klavier */
insert into musikstueck_besetzung (MusikstueckID, BesetzungID)
select MusikstueckID, 192 as BesetzungID -- 2 Violen und Klavier 
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
and musikstueck.SammlungID=1319 -- XXX 
group by musikstueck.ID 
order by musikstueck.ID 
) as update_base 
where Instrumente='Klavier, Viola, Viola 2'


-- 
