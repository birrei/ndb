/*
In einer definierten Sammlung soll bei allen Schwierigkeitsgraden ein bestimmtes Instrument 
durch ein bestimmtes anderes Instrument ersetzt werden. 
*/

-- Viola -> Violine 
update satz_schwierigkeitsgrad 
inner join satz on satz_schwierigkeitsgrad.SatzID = satz.ID 
inner join musikstueck on satz.MusikstueckID = musikstueck.ID 
set InstrumentID=12 -- Violine 
where musikstueck.SammlungID=1334     
and satz_schwierigkeitsgrad.InstrumentID = 17 -- Viola

------------------------------------------------------
-- Viola 2 -> Violine 2 
-- select ID, Name from instrument where Name IN ('Viola 2', 'Violine 2')
-- 13	Violine 2
-- 24	Viola 2

update satz_schwierigkeitsgrad 
inner join satz on satz_schwierigkeitsgrad.SatzID = satz.ID 
inner join musikstueck on satz.MusikstueckID = musikstueck.ID 
set InstrumentID=13 -- Violine 
where musikstueck.SammlungID=1334     
and satz_schwierigkeitsgrad.InstrumentID = 24 -- Viola


------------------------------------------------------
-- Viola 3 -> Violine 3 
-- select ID, Name from instrument where Name IN ('Viola 3', 'Violine 3') 
-- 14	Violine 3
-- 27	Viola 3

update satz_schwierigkeitsgrad 
inner join satz on satz_schwierigkeitsgrad.SatzID = satz.ID 
inner join musikstueck on satz.MusikstueckID = musikstueck.ID 
set InstrumentID=14 -- Violine 
where musikstueck.SammlungID=1334     
and satz_schwierigkeitsgrad.InstrumentID = 27 -- Viola


